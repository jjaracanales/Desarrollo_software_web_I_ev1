<?php
// Script de inicialización de base de datos para Vercel

require_once __DIR__ . '/vendor/autoload.php';

// Set environment
putenv('APP_ENV=production');
putenv('APP_DEBUG=false');
putenv('APP_KEY=base64:' . base64_encode('desarrollo-software-web-i-ev1-key32'));
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=/tmp/database.sqlite');

$_ENV['APP_ENV'] = 'production';
$_ENV['APP_DEBUG'] = 'false';
$_ENV['APP_KEY'] = 'base64:' . base64_encode('desarrollo-software-web-i-ev1-key32');
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = '/tmp/database.sqlite';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';

try {
    // Run migrations
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "Migrations executed successfully\n";
    
    // Run seeders
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'ProyectoSeeder', '--force' => true]);
    echo "Seeders executed successfully\n";
    
    // Create flag file
    file_put_contents('/tmp/db_initialized', 'true');
    echo "Database initialization completed\n";
    
} catch (Exception $e) {
    echo "Error initializing database: " . $e->getMessage() . "\n";
} 