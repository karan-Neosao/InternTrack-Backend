<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;
use Carbon\Carbon;

class TrackActivity
{
    /**
     * Handle an incoming request and record activity.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Run logging after response is generated to avoid slowing down request
        try {
            $this->logActivity($request);
        } catch (\Throwable $e) {
            // Silently swallow logging errors so user requests are never interrupted
        }

        return $response;
    }

    /**
     * Record visitor / user activity automatically
     */
    protected function logActivity(Request $request): void
    {
        $path = $request->path();

        // Skip healthcheck, asset files, debug endpoints, and clearing logs
        if ($path === 'up' || str_contains($path, 'activity-logs') || preg_match('/\.(ico|png|jpg|jpeg|gif|css|js|svg|woff|woff2|ttf|map)$/i', $path)) {
            return;
        }

        $ip = ActivityLog::getRealClientIp($request);
        $user = auth()->user();

        // Automatically resolve Geolocation & ISP from IP
        $geo = ActivityLog::resolveIpDetails($ip);
        $city = $geo['city'] ?? null;
        $region = $geo['region'] ?? null;
        $country = $geo['country'] ?? null;
        $isp = $geo['isp'] ?? null;

        $userAgent = $request->userAgent();
        $device = ActivityLog::parseDevice($userAgent);
        $action = ActivityLog::determineAction($request);
        $method = $request->method();

        // Automatically determine user identity and display name
        if ($user) {
            $userId = $user->id;
            $userName = $user->name;
            $userEmail = $user->email;
            $userRole = $user->role ?? 'user';
        } else {
            // Check if this IP previously belonged to a logged-in student/admin/company
            $pastUserLog = ActivityLog::where('ip_address', $ip)
                ->whereNotNull('user_id')
                ->whereNotNull('user_name')
                ->latest('id')
                ->first();

            $userId = null;
            if ($pastUserLog) {
                $userName = $pastUserLog->user_name . ' (Recognized User)';
                $userEmail = $pastUserLog->user_email;
                $userRole = $pastUserLog->user_role;
            } elseif ($city && $isp) {
                $userName = "{$city} Visitor ({$isp})";
                $userEmail = "{$city}, {$country}";
                $userRole = 'guest';
            } elseif ($city) {
                $userName = "{$city} Visitor";
                $userEmail = "{$city}, {$country}";
                $userRole = 'guest';
            } elseif ($isp) {
                $userName = "{$isp} Visitor";
                $userEmail = "Network: {$isp}";
                $userRole = 'guest';
            } else {
                $platform = trim(explode('•', $device)[0] ?? 'Web');
                $userName = "{$platform} Visitor";
                $userEmail = 'Public Web Visitor';
                $userRole = 'guest';
            }
        }

        $fullUrl = substr($request->fullUrl(), 0, 1000);

        // Throttle rapid consecutive refreshes by same IP & path within 20 seconds
        $recentDuplicate = ActivityLog::where('ip_address', $ip)
            ->where('url', $fullUrl)
            ->where('created_at', '>=', Carbon::now()->subSeconds(20))
            ->latest('id')
            ->first();

        if ($recentDuplicate) {
            // Update updated_at and user details if newly authenticated
            if ($user && !$recentDuplicate->user_id) {
                $recentDuplicate->update([
                    'user_id' => $userId,
                    'user_name' => $userName,
                    'user_email' => $userEmail,
                    'user_role' => $userRole,
                    'city' => $city,
                    'region' => $region,
                    'country' => $country,
                    'isp' => $isp,
                ]);
            } else {
                $recentDuplicate->touch();
            }
            return;
        }

        ActivityLog::create([
            'user_id' => $userId,
            'user_name' => $userName,
            'user_email' => $userEmail,
            'user_role' => $userRole,
            'ip_address' => $ip,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'isp' => $isp,
            'user_agent' => $userAgent ? substr($userAgent, 0, 500) : null,
            'device' => $device,
            'url' => $fullUrl,
            'method' => $method,
            'action' => $action,
        ]);
    }
}
