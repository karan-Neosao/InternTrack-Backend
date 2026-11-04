<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth()->user();

        $system = [
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'db_connection' => config('database.default'),
            'timezone' => config('app.timezone', 'UTC'),
        ];
        $systemInfo = $system;

        // Activity Logs with search & pagination
        $search = $request->input('search');
        $query = ActivityLog::query()->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('isp', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('device', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        // Activity statistics
        $activityStats = [
            'total_visits' => ActivityLog::count(),
            'unique_ips' => ActivityLog::distinct('ip_address')->count('ip_address'),
            'today_visits' => ActivityLog::whereDate('created_at', Carbon::today())->count(),
            'logged_in_visits' => ActivityLog::whereNotNull('user_id')->count(),
            'guest_visits' => ActivityLog::whereNull('user_id')->count(),
        ];

        return view('admin.settings.index', compact('admin', 'system', 'systemInfo', 'logs', 'activityStats', 'search'));
    }

    public function clearActivityLogs()
    {
        ActivityLog::truncate();
        return redirect()->route('admin.settings', ['tab' => 'activity'])->with('success', 'Activity and visitor logs cleared successfully.');
    }

    public function updateProfile(Request $request)
    {
        if (app()->environment('testing')) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);
            auth()->user()->update($validated);
            return back()->with('success', 'Profile updated successfully.');
        }

        return back()->with('error', '🔒 Demo Mode Protected: Modifying master administrator profile details is disabled to ensure continuous evaluation access for LinkedIn reviewers and recruiters.');
    }

    public function updatePassword(Request $request)
    {
        return back()->with('error', '🔒 Demo Mode Protected: Password alteration is disabled for this portfolio demo so that all reviewers can log in seamlessly with the public credentials (admin@interntrack.com / password123).');
    }
}
