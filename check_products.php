<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== STATISTIK PRODUK SEBATAS PC ===\n\n";

$totalProducts = Product::count();
$totalCategories = Category::count();

echo "Total Produk: $totalProducts\n";
echo "Total Kategori: $totalCategories\n\n";

echo "Produk per Kategori:\n";
$categories = Category::withCount('products')->orderBy('products_count', 'desc')->get();

foreach ($categories as $cat) {
    echo "  • {$cat->name}: {$cat->products_count} produk\n";
}

echo "\n";

// Tampilkan beberapa produk sebagai sample
echo "Sample Produk (10 teratas):\n";
$products = Product::with('category')->take(10)->get();

foreach ($products as $product) {
    echo "  • {$product->name} ({$product->category->name}) - Rp " . number_format($product->price, 0, ',', '.') . "\n";
}

echo "\n";
echo "Untuk melihat semua produk, buka:\n";
echo "  - User: http://127.0.0.1:8000\n";
echo "  - Admin: http://127.0.0.1:8000/admin/products\n";
