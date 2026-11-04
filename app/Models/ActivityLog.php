<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_role',
        'ip_address',
        'city',
        'region',
        'country',
        'isp',
        'custom_label',
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
     * Accurately determine the real client IP (works behind Cloudflare, Render, proxies)
     */
    public static function getRealClientIp(Request $request): string
    {
        // 1. Cloudflare connecting IP
        if ($cfIp = $request->server('HTTP_CF_CONNECTING_IP') ?: $request->header('CF-Connecting-IP')) {
            $candidate = trim(explode(',', $cfIp)[0]);
            if (filter_var($candidate, FILTER_VALIDATE_IP)) {
                return $candidate;
            }
        }

        // 2. X-Real-IP
        if ($realIp = $request->server('HTTP_X_REAL_IP') ?: $request->header('X-Real-IP')) {
            $candidate = trim(explode(',', $realIp)[0]);
            if (filter_var($candidate, FILTER_VALIDATE_IP)) {
                return $candidate;
            }
        }

        // 3. X-Forwarded-For: The first non-private IP is the actual visitor
        $forwarded = $request->server('HTTP_X_FORWARDED_FOR') ?: $request->header('X-Forwarded-For');
        if ($forwarded) {
            $ips = array_map('trim', explode(',', $forwarded));
            foreach ($ips as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
            if (!empty($ips[0]) && filter_var($ips[0], FILTER_VALIDATE_IP)) {
                return $ips[0];
            }
        }

        return $request->ip() ?: '127.0.0.1';
    }

    /**
     * Geolocation & ISP lookup for an IP address (cached 7 days)
     */
    public static function resolveIpDetails(string $ip): array
    {
        // For private, local, or loopback IPs
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return [
                'city' => 'Localhost',
                'region' => 'Local Network',
                'country' => 'India',
                'isp' => 'Local Dev Gateway',
            ];
        }

        return Cache::remember("geo_ip_{$ip}", 86400 * 7, function () use ($ip) {
            try {
                $response = Http::timeout(2)
                    ->get("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city,isp,org");

                if ($response->successful()) {
                    $data = $response->json();
                    if (($data['status'] ?? '') === 'success') {
                        return [
                            'city' => $data['city'] ?? null,
                            'region' => $data['regionName'] ?? null,
                            'country' => $data['country'] ?? null,
                            'isp' => $data['org'] ?? ($data['isp'] ?? null),
                        ];
                    }
                }
            } catch (\Throwable $e) {
                // Return nulls on network issue or timeout
            }

            return [
                'city' => null,
                'region' => null,
                'country' => null,
                'isp' => null,
            ];
        });
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
