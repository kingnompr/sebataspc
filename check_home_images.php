<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== Checking Home Page Products ===\n\n";

$featuredProducts = Product::with('category')
    ->where('is_featured', 1)
    ->where('stock', '>', 0)
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->take(6)
    ->get();

echo "Featured Products: " . $featuredProducts->count() . "\n\n";

foreach ($featuredProducts as $product) {
    echo "Product: {$product->name}\n";
    echo "Image: {$product->image}\n";
    echo "Stock: {$product->stock}\n";
    echo "Is Featured: {$product->is_featured}\n";
    echo "\n";
}

echo "---\n";
echo "Checking ALL products with images:\n";
$allWithImages = Product::whereNotNull('image')->where('image', '!=', '')->get();
echo "Total products with images: " . $allWithImages->count() . "\n";

if ($allWithImages->count() > 0) {
    echo "Sample: " . $allWithImages->first()->image . "\n";
}
