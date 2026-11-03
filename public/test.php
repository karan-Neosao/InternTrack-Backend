<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "<h1>InternTrack Diagnostics</h1>";
echo "PHP Version: " . phpversion() . "<br>";
echo "PDO Drivers: " . implode(', ', PDO::getAvailableDrivers()) . "<br>";
echo "APP_KEY set: " . (!empty(getenv('APP_KEY')) ? 'YES' : 'NO') . "<br>";
echo "DB_CONNECTION: " . getenv('DB_CONNECTION') . "<br>";

try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "Autoload: OK<br>";
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "Bootstrap: OK<br>";
    
    // Check config
    echo "Config APP_KEY: " . (config('app.key') ? 'FOUND' : 'MISSING') . "<br>";
    echo "Config DB Default: " . config('database.default') . "<br>";
    
    // Test DB connection
    Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "DB Connection: OK<br>";
    
    echo "Everything looks good!";
} catch (\Throwable $e) {
    echo "<h3>ERROR CAUGHT:</h3>";
    echo "<b>Message:</b> " . htmlspecialchars($e->getMessage()) . "<br>";
    echo "<b>File:</b> " . htmlspecialchars($e->getFile()) . ":" . $e->getLine() . "<br>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
