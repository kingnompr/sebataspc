<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING PRODUCT IMAGE URLs ===\n\n";

$products = App\Models\Product::with('category')->take(5)->get();

foreach($products as $product) {
    echo "Product: {$product->name}\n";
    echo "Category: {$product->category->name}\n";
    echo "Image Path: {$product->image}\n";
    echo "Image URL: {$product->image_url}\n";
    echo str_repeat('-', 80) . "\n\n";
}
