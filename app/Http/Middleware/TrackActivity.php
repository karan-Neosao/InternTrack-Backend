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
     * Record visitor / user activity
     */
    protected function logActivity(Request $request): void
    {
        $path = $request->path();

        // Skip healthcheck, asset files, debug endpoints, and clearing logs
        if ($path === 'up' || str_contains($path, 'activity-logs') || preg_match('/\.(ico|png|jpg|jpeg|gif|css|js|svg|woff|woff2|ttf|map)$/i', $path)) {
            return;
        }

        $ip = $request->ip() ?: '127.0.0.1';
        $user = auth()->user();

        $userId = $user ? $user->id : null;
        $userName = $user ? $user->name : 'Guest Visitor';
        $userEmail = $user ? $user->email : 'guest@visitor';
        $userRole = $user ? ($user->role ?? 'user') : 'guest';

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
            'user_agent' => $userAgent ? substr($userAgent, 0, 500) : null,
            'device' => $device,
            'url' => $fullUrl,
            'method' => $method,
            'action' => $action,
        ]);
    }
}
