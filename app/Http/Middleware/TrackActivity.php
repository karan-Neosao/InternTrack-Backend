<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
     * Record visitor / user activity
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

        // Resolve Geolocation & ISP
        $geo = ActivityLog::resolveIpDetails($ip);
        $city = $geo['city'] ?? null;
        $region = $geo['region'] ?? null;
        $country = $geo['country'] ?? null;
        $isp = $geo['isp'] ?? null;

        // Check if admin has given a custom label to this IP
        $customLabel = null;
        try {
            $customLabel = DB::table('ip_labels')->where('ip_address', $ip)->value('label');
        } catch (\Throwable $e) {}

        // Determine user details and identity
        if ($user) {
            $userId = $user->id;
            $userName = $user->name;
            $userEmail = $user->email;
            $userRole = $user->role ?? 'user';
        } elseif ($customLabel) {
            $userId = null;
            $userName = $customLabel;
            $userEmail = ($city ? "{$city}, " : "") . ($isp ?: "Visitor");
            $userRole = 'guest';
        } else {
            // Check if this IP previously belonged to an authenticated user
            $pastUserLog = ActivityLog::where('ip_address', $ip)
                ->whereNotNull('user_id')
                ->whereNotNull('user_name')
                ->latest('id')
                ->first();

            $userId = null;
            if ($pastUserLog) {
                $userName = $pastUserLog->user_name . ' (Recognized)';
                $userEmail = $pastUserLog->user_email;
                $userRole = $pastUserLog->user_role;
            } elseif ($city && $isp) {
                $userName = "{$city} Visitor • {$isp}";
                $userEmail = "{$city}, {$country}";
                $userRole = 'guest';
            } elseif ($city) {
                $userName = "{$city} Visitor";
                $userEmail = "{$city}, {$country}";
                $userRole = 'guest';
            } else {
                $userName = 'Guest Visitor';
                $userEmail = $isp ? "Network: {$isp}" : 'guest@visitor';
                $userRole = 'guest';
            }
        }

        $fullUrl = substr($request->fullUrl(), 0, 1000);
        $userAgent = $request->userAgent();
        $device = ActivityLog::parseDevice($userAgent);
        $action = ActivityLog::determineAction($request);
        $method = $request->method();

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
                    'custom_label' => $customLabel,
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
            'custom_label' => $customLabel,
            'user_agent' => $userAgent ? substr($userAgent, 0, 500) : null,
            'device' => $device,
            'url' => $fullUrl,
            'method' => $method,
            'action' => $action,
        ]);
    }
}
