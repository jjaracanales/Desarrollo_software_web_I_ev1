<?php

// Vercel PHP Runtime for Laravel
// Compatible con Windows (local) y Vercel (producción)

define('LARAVEL_START', microtime(true));

// Check if vendor directory exists
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    http_response_code(503);
    exit('Sistema en configuración. Intenta en unos minutos.');
}

// Register the Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Detectar si estamos en Vercel o local
$isVercel = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || 
            (isset($_ENV['NOW_REGION']) || isset($_SERVER['NOW_REGION']));

// Configurar rutas según el entorno
if ($isVercel) {
    // Configuración para Vercel (Linux)
    $tempDir = '/tmp';
    $dbPath = '/tmp/database.sqlite';
    $storageBase = '/tmp';
} else {
    // Configuración para desarrollo local (Windows/Linux/Mac)
    $tempDir = sys_get_temp_dir();
    $dbPath = __DIR__ . '/../storage/database.sqlite';
    $storageBase = __DIR__ . '/../storage';
}

// Set basic environment variables
$_ENV['APP_ENV'] = $isVercel ? 'production' : 'local';
$_ENV['APP_DEBUG'] = $isVercel ? 'false' : 'true';
$_ENV['APP_KEY'] = 'base64:' . base64_encode('desarrollo-software-web-i-ev1-key32');
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $dbPath;
$_ENV['CACHE_DRIVER'] = $isVercel ? 'array' : 'file';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['LOG_CHANNEL'] = $isVercel ? 'stderr' : 'stack';

// Set environment variables using putenv for Laravel
putenv('APP_ENV=' . $_ENV['APP_ENV']);
putenv('APP_DEBUG=' . $_ENV['APP_DEBUG']);
putenv('APP_KEY=' . $_ENV['APP_KEY']);
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=' . $dbPath);
putenv('CACHE_DRIVER=' . $_ENV['CACHE_DRIVER']);
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=' . $_ENV['LOG_CHANNEL']);

// Create database directory if needed
$dbDir = dirname($dbPath);
if (!is_dir($dbDir)) {
    @mkdir($dbDir, 0755, true);
}

// Create SQLite database
if (!file_exists($dbPath)) {
    @touch($dbPath);
    @chmod($dbPath, 0664);
}

// Create necessary directories
$storageDirs = [
    $storageBase . '/logs',
    $storageBase . '/framework',
    $storageBase . '/framework/cache',
    $storageBase . '/framework/sessions',
    $storageBase . '/framework/views',
];

// Solo crear directorios bootstrap/cache en Vercel
if ($isVercel) {
    $storageDirs[] = '/tmp/bootstrap';
    $storageDirs[] = '/tmp/bootstrap/cache';
}

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Initialize database (run once)
static $initialized = false;
if (!$initialized && file_exists($dbPath) && filesize($dbPath) === 0) {
    try {
        // Run migrations and seeders
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $initialized = true;
    } catch (Exception $e) {
        error_log('Database setup error: ' . $e->getMessage());
    }
}

// Handle the request
use Illuminate\Http\Request;
$app->handleRequest(Request::capture()); 