<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Trust Cloudflare and Render reverse proxies for proper HTTPS protocol detection
        $middleware->trustProxies(at: '*');

        // Exempt admin login from CSRF token verification to prevent 419 Page Expired errors on initial or idle login
        $middleware->validateCsrfTokens(except: [
            '/admin/login',
            'admin/login',
        ]);

        $middleware->redirectTo(
            guests: '/admin/login',
            users: '/admin/dashboard',
        );

        $middleware->web(append: [
            \App\Http\Middleware\TrackActivity::class,
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Gracefully handle any CSRF token mismatch across the app by redirecting to login with message
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            return redirect()->to('/admin/login')->with('error', 'Session expired. Please sign in again.');
        });
    })->create();
