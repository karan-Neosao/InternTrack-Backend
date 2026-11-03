<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingController extends Controller
{
    public function index()
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

        return view('admin.settings.index', compact('admin', 'system', 'systemInfo'));
    }

    public function updateProfile(Request $request)
    {
        return back()->with('error', '🔒 Demo Mode Protected: Modifying master administrator profile details is disabled to ensure continuous evaluation access for LinkedIn reviewers and recruiters.');
    }

    public function updatePassword(Request $request)
    {
        return back()->with('error', '🔒 Demo Mode Protected: Password alteration is disabled for this portfolio demo so that all reviewers can log in seamlessly with the public credentials (admin@interntrack.com / password123).');
    }
}
