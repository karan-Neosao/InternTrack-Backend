<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "<h1>InternTrack Diagnostics</h1>";

try {
    define('LARAVEL_START', microtime(true));

    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $request = Illuminate\Http\Request::capture();
    $response = $app->handleRequest($request);

    echo "<h3>Response Status: " . $response->getStatusCode() . "</h3>";
    echo "<h3>Response Headers:</h3><pre>" . print_r($response->headers->all(), true) . "</pre>";
    echo "<h3>Response Content Preview:</h3>";
    echo substr($response->getContent(), 0, 1000);
} catch (\Throwable $e) {
    echo "<h3>REAL ERROR CAUGHT:</h3>";
    echo "<b>Message:</b> " . htmlspecialchars($e->getMessage()) . "<br>";
    echo "<b>Class:</b> " . get_class($e) . "<br>";
    echo "<b>File:</b> " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "<br>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
