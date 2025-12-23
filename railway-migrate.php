<?php
// Script untuk force migration di Railway

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== Railway Migration Script ===\n\n";

try {
    // Test database connection
    echo "1. Testing database connection...\n";
    $pdo = DB::connection()->getPdo();
    echo "✅ Database connected successfully!\n";
    echo "   Database: " . env('DB_DATABASE') . "\n";
    echo "   Host: " . env('DB_HOST') . "\n\n";
    
    // Run migrations
    echo "2. Running migrations...\n";
    Artisan::call('migrate:fresh', ['--force' => true]);
    echo Artisan::output();
    
    // Run seeders
    echo "\n3. Running seeders...\n";
    Artisan::call('db:seed', ['--force' => true]);
    echo Artisan::output();
    
    echo "\n✅ Migration completed successfully!\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
