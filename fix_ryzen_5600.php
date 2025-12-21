<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

echo "=== UPDATE AMD RYZEN 5 5600 IMAGE ===\n\n";

$product = Product::where('name', 'AMD Ryzen 5 5600')->first();

if ($product) {
    $imagePath = 'images/products/AMD Ryzen 5 5600-prosesor.jpg';
    $fullPath = public_path($imagePath);
    
    if (file_exists($fullPath)) {
        $product->image = $imagePath;
        $product->save();
        
        echo "✅ Updated: {$product->name}\n";
        echo "   Image: {$imagePath}\n";
    } else {
        echo "❌ Image not found: {$imagePath}\n";
    }
} else {
    echo "❌ Product not found: AMD Ryzen 5 5600\n";
}

echo "\nDone!\n";
