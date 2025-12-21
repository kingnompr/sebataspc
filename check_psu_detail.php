<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== DETAIL PSU PRODUCTS IN DATABASE ===\n\n";

$category = Category::where('slug', 'psu')
    ->orWhere('slug', 'power-supply')
    ->orWhere('name', 'LIKE', '%Power Supply%')
    ->first();

if ($category) {
    $products = Product::where('category_id', $category->id)
        ->orderBy('name')
        ->get();
    
    foreach ($products as $product) {
        echo "ID {$product->id}: {$product->name}\n";
        echo "  Image: " . ($product->image ?: 'NULL') . "\n";
        echo "  Price: Rp " . number_format($product->price, 0, ',', '.') . "\n\n";
    }
}
