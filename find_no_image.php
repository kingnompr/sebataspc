<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

$products = Product::whereNull('image')
    ->orWhere('image', '')
    ->with('category')
    ->get();

echo "=== PRODUK TANPA GAMBAR ===\n\n";

if ($products->count() > 0) {
    foreach ($products as $p) {
        echo "❌ {$p->name}\n";
        echo "   ID: {$p->id}\n";
        echo "   Category: {$p->category->name}\n";
        echo "   Slug: {$p->slug}\n\n";
    }
    echo "Total: {$products->count()}\n";
} else {
    echo "✅ SEMUA PRODUK SUDAH MEMILIKI GAMBAR!\n";
}
