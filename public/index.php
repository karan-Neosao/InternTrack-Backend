<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

try {
    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<div style='font-family:sans-serif;padding:30px;background:#fef2f2;border:2px solid #ef4444;border-radius:10px;margin:20px;'>";
    echo "<h2 style='color:#dc2626;'>Laravel Startup Error</h2>";
    echo "<p><b>Message:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><b>File:</b> " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "</p>";
    echo "<pre style='background:#fff;padding:15px;overflow:auto;border-radius:5px;border:1px solid #fca5a5;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}
