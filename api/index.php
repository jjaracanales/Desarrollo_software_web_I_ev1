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

// Generate a proper Laravel application key (32 bytes for AES-256-CBC)
$appKey = 'base64:' . base64_encode(random_bytes(32));

// Set minimal environment for Vercel
putenv('APP_ENV=production');
putenv('APP_DEBUG=true'); // Enable debug temporarily
putenv('APP_KEY=' . $appKey);
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
$_ENV['APP_KEY'] = $appKey;
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = '/tmp/database.sqlite';

// Create minimal database
@touch('/tmp/database.sqlite');
@chmod('/tmp/database.sqlite', 0666);

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

    // CRITICAL: Initialize database BEFORE handling any requests
    if (!file_exists('/tmp/db_ready')) {
        try {
            echo "<!-- Inicializando base de datos... -->";
            
            // Check if database file exists and is writable
            if (!file_exists('/tmp/database.sqlite')) {
                touch('/tmp/database.sqlite');
                chmod('/tmp/database.sqlite', 0666);
            }
            
            // Run fresh migrations
            \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
            echo "<!-- Migraciones ejecutadas -->";
            
            // Run seeders
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'ProyectoSeeder', '--force' => true]);
            echo "<!-- Seeders ejecutados -->";
            
            // Verify table exists
            $pdo = new PDO('sqlite:/tmp/database.sqlite');
            $result = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='proyectos'");
            if ($result && $result->fetch()) {
                echo "<!-- Tabla proyectos verificada -->";
                // Create ready flag
                file_put_contents('/tmp/db_ready', 'true');
            } else {
                throw new Exception('Table proyectos was not created');
            }
            
        } catch (Exception $e) {
            echo "<!-- Error en inicialización BD: " . $e->getMessage() . " -->";
            error_log('Database initialization error: ' . $e->getMessage());
            
            // Show detailed error for debugging
            echo "<!-- Intentando recuperación de BD... -->";
            try {
                // Force create table if needed
                $pdo = new PDO('sqlite:/tmp/database.sqlite');
                $createTable = "
                CREATE TABLE IF NOT EXISTS proyectos (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nombre VARCHAR(255) NOT NULL,
                    fecha_inicio DATE NOT NULL,
                    estado VARCHAR(50) NOT NULL,
                    responsable VARCHAR(255) NOT NULL,
                    monto DECIMAL(15,2) NOT NULL,
                    created_at TIMESTAMP,
                    updated_at TIMESTAMP
                )";
                $pdo->exec($createTable);
                echo "<!-- Tabla creada manualmente -->";
                
                // Insert sample data
                $insertData = "
                INSERT INTO proyectos (nombre, fecha_inicio, estado, responsable, monto, created_at, updated_at) VALUES 
                ('Sistema de Gestión de Inventarios', '2025-01-15', 'En Progreso', 'Carlos Rodríguez', 15000000, datetime('now'), datetime('now')),
                ('Plataforma E-commerce', '2025-02-01', 'Pendiente', 'Ana García', 25000000, datetime('now'), datetime('now')),
                ('Aplicación Móvil de Delivery', '2025-01-20', 'En Progreso', 'Miguel Torres', 18000000, datetime('now'), datetime('now')),
                ('Sistema de Facturación', '2025-02-10', 'Completado', 'Laura Sánchez', 12000000, datetime('now'), datetime('now')),
                ('Portal Web Corporativo', '2025-01-25', 'Pendiente', 'Roberto Flores', 8000000, datetime('now'), datetime('now'))
                ";
                $pdo->exec($insertData);
                echo "<!-- Datos insertados manualmente -->";
                
                file_put_contents('/tmp/db_ready', 'manual');
            } catch (Exception $e2) {
                echo "<!-- Error en recuperación: " . $e2->getMessage() . " -->";
            }
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