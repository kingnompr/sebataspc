<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== CHECK COOLING IMAGES ===\n\n";

$category = Category::where('slug', 'cooling')
    ->orWhere('slug', 'cpu-cooler')
    ->orWhere('name', 'LIKE', '%Cooling%')
    ->first();

if ($category) {
    $products = Product::where('category_id', $category->id)
        ->orderBy('name')
        ->get();
    
    echo "Total: {$products->count()} cooling products\n\n";
    
    foreach ($products as $product) {
        $hasImage = $product->image && $product->image !== 'products/default.jpg';
        $status = $hasImage ? '✅' : '❌';
        echo "$status {$product->name}\n";
        if ($hasImage) {
            echo "   📷 {$product->image}\n";
        }
    }
}
