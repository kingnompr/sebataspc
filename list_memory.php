<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

$category = Category::where('slug', 'memory')->first();

if ($category) {
    $products = Product::where('category_id', $category->id)
        ->orderBy('name')
        ->get();
    
    echo "=== ALL MEMORY PRODUCTS ===\n\n";
    
    foreach ($products as $product) {
        $status = $product->image && $product->image !== 'products/default.jpg' ? '✅' : '❌';
        echo "$status {$product->name}\n";
        if ($product->image) {
            echo "   📷 {$product->image}\n";
        }
    }
    
    echo "\nTotal: " . $products->count() . " memory products\n";
}
