<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if vendor directory exists
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    http_response_code(503);
    exit('Sistema en configuración. Intenta en unos minutos.');
}

// Register the Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Set minimal environment for Vercel
putenv('APP_ENV=production');
putenv('APP_DEBUG=true'); // Enable debug temporarily
putenv('APP_KEY=base64:' . base64_encode('desarrollo-software-web-i-ev1-key32'));
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=/tmp/database.sqlite');
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=array');
putenv('LOG_CHANNEL=stderr');

// Set globals for Laravel
$_ENV['APP_ENV'] = 'production';
$_ENV['APP_DEBUG'] = 'true'; // Enable debug temporarily
$_ENV['APP_KEY'] = 'base64:' . base64_encode('desarrollo-software-web-i-ev1-key32');
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = '/tmp/database.sqlite';

// Create minimal database
@touch('/tmp/database.sqlite');

// Initialize database if not already done
if (!file_exists('/tmp/db_initialized')) {
    try {
        echo "<!-- Initializing database... -->";
        include_once __DIR__ . '/../init-db.php';
        echo "<!-- Database initialized -->";
    } catch (Exception $e) {
        echo "<!-- Database initialization error: " . $e->getMessage() . " -->";
        error_log('Database initialization error: ' . $e->getMessage());
    }
}

try {
    // Bootstrap Laravel
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // Handle the request
    $app->handleRequest(Request::capture());
} catch (Exception $e) {
    echo "Error starting Laravel: " . $e->getMessage();
    echo "\nFile: " . $e->getFile();
    echo "\nLine: " . $e->getLine();
} 