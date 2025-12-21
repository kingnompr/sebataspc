<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== MEMORY PRODUCTS & IMAGES ===\n\n";

$memoryCategory = Category::where('slug', 'memory')->first();

if ($memoryCategory) {
    $memoryProducts = Product::where('category_id', $memoryCategory->id)->get();
    
    echo "Total Memory Products: " . $memoryProducts->count() . "\n\n";
    
    foreach ($memoryProducts as $product) {
        $hasImage = !empty($product->image) && $product->image !== 'products/default.jpg';
        $status = $hasImage ? "✅" : "❌";
        echo "$status {$product->name}\n";
        if ($hasImage) {
            echo "   Image: {$product->image}\n";
        }
    }
}
