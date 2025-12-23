<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;

echo "=== Checking Image Paths ===\n\n";

// Sample products
$products = Product::whereNotNull('image')->take(10)->get();

foreach ($products as $p) {
    $fullPath = public_path($p->image);
    $exists = file_exists($fullPath) ? '✅' : '❌';
    echo "$exists {$p->name}\n   Path: {$p->image}\n   File: " . ($exists == '✅' ? 'EXISTS' : 'NOT FOUND') . "\n\n";
}

echo "\n=== Total Products: " . Product::count() . " ===\n";
echo "=== Products with images: " . Product::whereNotNull('image')->count() . " ===\n";
