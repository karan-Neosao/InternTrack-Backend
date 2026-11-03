<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        $user = $request->user();

        if ($user->role !== 'admin') {
            auth()->logout();

            return redirect()
                ->route('admin.login')
                ->with('error', 'You are not authorized to access the admin panel.');
        }

        if (!$user->is_active) {
            auth()->logout();

            return redirect()
                ->route('admin.login')
                ->with('error', 'Your admin account has been deactivated.');
        }

        return $next($request);
    }
}
