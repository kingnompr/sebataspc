<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\DB;

echo "=== Checking Database Structure ===\n\n";

// Get first product to see raw data
$product = Product::first();
if ($product) {
    echo "Product: {$product->name}\n";
    echo "Raw attributes:\n";
    print_r($product->getAttributes());
}
