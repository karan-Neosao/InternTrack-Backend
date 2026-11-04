<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_role',
        'ip_address',
        'user_agent',
        'device',
        'url',
        'method',
        'action',
    ];

    /**
     * Associated user relationship (nullable)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Parse User-Agent into clean "OS • Browser" format
     */
    public static function parseDevice(?string $userAgent): string
    {
        if (empty($userAgent)) {
            return 'Unknown Device';
        }

        $platform = 'Unknown OS';
        if (preg_match('/windows|win32/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $platform = 'macOS';
        } elseif (preg_match('/android/i', $userAgent)) {
            $platform = 'Android';
        } elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
            $platform = 'iOS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $platform = 'Linux';
        }

        $browser = 'Browser';
        if (preg_match('/edg/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/chrome|crios/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/firefox|fxios/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/opera|opr/i', $userAgent)) {
            $browser = 'Opera';
        }

        return "{$platform} • {$browser}";
    }

    /**
     * Generate human-readable action label from route/path
     */
    public static function determineAction(Request $request): string
    {
        $path = trim($request->path(), '/');

        if ($path === '' || $path === '/') {
            return 'Visited Homepage / Root';
        }

        if (str_starts_with($path, 'admin/login')) {
            return 'Visited Admin Login';
        }
        if (str_starts_with($path, 'admin/dashboard')) {
            return 'Viewed Admin Dashboard';
        }
        if (str_starts_with($path, 'admin/students')) {
            return 'Viewed Students Directory';
        }
        if (str_starts_with($path, 'admin/companies')) {
            return 'Viewed Companies Directory';
        }
        if (str_starts_with($path, 'admin/internships')) {
            return 'Viewed Internships Management';
        }
        if (str_starts_with($path, 'admin/applications')) {
            return 'Viewed Internship Applications';
        }
        if (str_starts_with($path, 'admin/reports')) {
            return 'Viewed Reports & Analytics';
        }
        if (str_starts_with($path, 'admin/settings')) {
            return 'Viewed System Settings';
        }
        if (str_starts_with($path, 'admin/notifications')) {
            return 'Viewed Notifications Center';
        }
        if (str_starts_with($path, 'api/')) {
            return 'API Endpoint Access (' . $path . ')';
        }

        return 'Viewed Page (/' . $path . ')';
    }
}
