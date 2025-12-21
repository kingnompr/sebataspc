<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== CHECK MOTHERBOARD PRODUCTS ===\n\n";

$category = Category::where('slug', 'motherboard')
    ->orWhere('name', 'LIKE', '%Motherboard%')
    ->first();

if (!$category) {
    echo "❌ Motherboard category not found\n";
    exit;
}

$products = Product::where('category_id', $category->id)
    ->orderBy('name')
    ->get();

echo "Total: {$products->count()} motherboard products\n\n";

foreach ($products as $product) {
    $hasImage = $product->image && 
                $product->image !== 'products/default.jpg' && 
                !str_starts_with($product->image, 'products/');
    $status = $hasImage ? '✅' : '❌';
    
    echo "$status {$product->name}\n";
    if ($hasImage) {
        echo "   📷 {$product->image}\n";
    }
}

echo "\n=== Available motherboard images in folder ===\n";
$imageDir = 'public/images/products';
if (is_dir($imageDir)) {
    $files = scandir($imageDir);
    $moboImages = array_filter($files, function($file) {
        return preg_match('/(mobo|motherboard|board|b650|b760|z790|x670)/i', $file);
    });
    
    if (empty($moboImages)) {
        echo "❌ No motherboard images found\n";
    } else {
        foreach ($moboImages as $img) {
            echo "  - $img\n";
        }
    }
} else {
    echo "❌ Image directory not found\n";
}
