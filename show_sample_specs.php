<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;

echo "=== Sample Product Specifications (Like Screenshot) ===\n\n";

// Get RAM product (like in screenshot)
$ramProduct = Product::whereHas('category', function($q) {
    $q->where('slug', 'ram');
})->where('name', 'LIKE', '%16GB%')->first();

if ($ramProduct) {
    echo "RAM Example:\n";
    echo "Product: {$ramProduct->name}\n";
    echo "Specifications JSON:\n";
    echo json_encode($ramProduct->specifications, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";
    echo str_repeat("-", 70) . "\n\n";
}

// Get CPU product
$cpuProduct = Product::whereHas('category', function($q) {
    $q->where('slug', 'cpu');
})->first();

if ($cpuProduct) {
    echo "CPU Example:\n";
    echo "Product: {$cpuProduct->name}\n";
    echo "Specifications JSON:\n";
    echo json_encode($cpuProduct->specifications, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";
    echo str_repeat("-", 70) . "\n\n";
}

// Get GPU product
$gpuProduct = Product::whereHas('category', function($q) {
    $q->where('slug', 'gpu');
})->first();

if ($gpuProduct) {
    echo "GPU Example:\n";
    echo "Product: {$gpuProduct->name}\n";
    echo "Specifications JSON:\n";
    echo json_encode($gpuProduct->specifications, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";
}

echo "\n=== All products now have detailed specifications! ===\n";
