<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

echo "=== PRODUCTS WITH IMAGES (STOCK > 0) ===\n\n";

$products = Product::with('category')
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->where('stock', '>', 0)
    ->latest()
    ->take(12)
    ->get();

if ($products->count() > 0) {
    foreach($products as $p) {
        $imagePath = public_path($p->image);
        $exists = file_exists($imagePath) ? '✅' : '❌';
        
        echo "{$exists} {$p->name}\n";
        echo "   Category: {$p->category->name}\n";
        echo "   Image: {$p->image}\n";
        echo "   File exists: " . (file_exists($imagePath) ? 'YES' : 'NO') . "\n";
        echo "   Stock: {$p->stock}\n\n";
    }
} else {
    echo "❌ No products found with images and stock > 0\n\n";
    
    // Check products without filter
    echo "=== ALL PRODUCTS (no filter) ===\n";
    $allProducts = Product::with('category')->take(5)->get();
    foreach($allProducts as $p) {
        echo "- {$p->name}\n";
        echo "  Image: " . ($p->image ?? 'NULL') . "\n";
        echo "  Stock: {$p->stock}\n\n";
    }
}

echo "\nTotal: " . $products->count() . " products\n";
