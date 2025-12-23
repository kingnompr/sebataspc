<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

$product = Product::find(8);

if ($product) {
    $product->image = 'images/products/AMD Ryzen 5 5600-prosesor.jpg';
    $product->save();
    
    echo "✅ Updated: {$product->name}\n";
    echo "   Image: {$product->image}\n";
} else {
    echo "❌ Product not found!\n";
}

// Final verification
$missing = Product::whereNull('image')->orWhere('image', '')->count();

echo "\n=== FINAL CHECK ===\n";
if ($missing == 0) {
    echo "✅✅✅ SEMUA PRODUK SUDAH MEMILIKI GAMBAR! ✅✅✅\n";
    
    $total = Product::count();
    echo "\nTotal produk: {$total}\n";
    echo "Semua {$total} produk sudah memiliki gambar!\n";
} else {
    echo "⚠️  Masih ada {$missing} produk tanpa gambar\n";
}
