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

// CRITICAL: Set Laravel cache paths to /tmp (writable in Vercel)
putenv('VIEW_COMPILED_PATH=/tmp/views');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');

// Set globals for Laravel
$_ENV['APP_ENV'] = 'production';
$_ENV['APP_DEBUG'] = 'true'; // Enable debug temporarily
$_ENV['APP_KEY'] = 'base64:' . base64_encode('desarrollo-software-web-i-ev1-key32');
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = '/tmp/database.sqlite';

// Create minimal database
@touch('/tmp/database.sqlite');

// Create ALL necessary directories in /tmp (writable area)
$writableDirs = [
    '/tmp/bootstrap',
    '/tmp/bootstrap/cache',
    '/tmp/storage',
    '/tmp/storage/logs',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/views'
];

foreach ($writableDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Create symlinks from Laravel directories to writable /tmp directories
$projectRoot = __DIR__ . '/..';
$symlinks = [
    $projectRoot . '/bootstrap/cache' => '/tmp/bootstrap/cache',
    $projectRoot . '/storage/logs' => '/tmp/storage/logs',
    $projectRoot . '/storage/framework/cache' => '/tmp/storage/framework/cache',
    $projectRoot . '/storage/framework/sessions' => '/tmp/storage/framework/sessions',
    $projectRoot . '/storage/framework/views' => '/tmp/storage/framework/views'
];

foreach ($symlinks as $link => $target) {
    if (!file_exists($link) && !is_link($link)) {
        @symlink($target, $link);
    }
}

try {
    // Bootstrap Laravel
    $app = require_once $projectRoot . '/bootstrap/app.php';
    
    if (!$app || !is_object($app)) {
        throw new Exception('Laravel app bootstrap failed');
    }

    // Initialize database AFTER Laravel is bootstrapped
    if (!file_exists('/tmp/db_initialized')) {
        try {
            echo "<!-- Initializing database... -->";
            
            // Run migrations using the proper app instance
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'ProyectoSeeder', '--force' => true]);
            
            // Create flag file
            file_put_contents('/tmp/db_initialized', 'true');
            echo "<!-- Database initialized -->";
        } catch (Exception $e) {
            echo "<!-- Database initialization error: " . $e->getMessage() . " -->";
            error_log('Database initialization error: ' . $e->getMessage());
        }
    }

    // Handle the request
    $app->handleRequest(Request::capture());
    
} catch (Exception $e) {
    echo "Error starting Laravel: " . $e->getMessage();
    echo "\nFile: " . $e->getFile();
    echo "\nLine: " . $e->getLine();
    echo "\nTrace: " . $e->getTraceAsString();
} 