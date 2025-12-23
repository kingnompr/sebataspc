<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== PRODUK TANPA GAMBAR ===\n\n";

$noImage = Product::whereNull('image')
    ->orWhere('image', '')
    ->orWhere('image', 'LIKE', '%/images/products/%')
    ->with('category')
    ->get();

if ($noImage->count() > 0) {
    foreach ($noImage as $product) {
        echo "❌ {$product->name}\n";
        echo "   Category: {$product->category->name}\n";
        echo "   Current image: " . ($product->image ?: 'NULL') . "\n\n";
    }
    echo "\n📊 Total: " . $noImage->count() . " produk tanpa gambar\n";
} else {
    echo "✅ Semua produk sudah memiliki gambar!\n";
}

echo "\n=== RINGKASAN PER KATEGORI ===\n\n";

$categories = \App\Models\Category::withCount('products')->get();
foreach ($categories as $cat) {
    $withImage = Product::where('category_id', $cat->id)
        ->whereNotNull('image')
        ->where('image', '!=', '')
        ->count();
    
    echo "{$cat->name}: {$withImage}/{$cat->products_count} produk memiliki gambar\n";
}
