<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== Simulating Home Page Logic ===\n\n";

// Simulate the home page route logic
$featuredProduct = Product::with('category')
    ->where('is_featured', 1)
    ->where('stock', '>', 0)
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->first();

$featuredProducts = collect();

// CPUs (3 items)
$cpus = Product::with('category')
    ->where('category_id', 1)
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->where('stock', '>', 0)
    ->inRandomOrder()
    ->take(3)
    ->get();
$featuredProducts = $featuredProducts->merge($cpus);

// GPUs (3 items)
$gpus = Product::with('category')
    ->where('category_id', 2)
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->where('stock', '>', 0)
    ->inRandomOrder()
    ->take(3)
    ->get();
$featuredProducts = $featuredProducts->merge($gpus);

// Storage (3 items)
$storage = Product::with('category')
    ->where('category_id', 5)
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->where('stock', '>', 0)
    ->inRandomOrder()
    ->take(3)
    ->get();
$featuredProducts = $featuredProducts->merge($storage);

echo "Featured Product (hero): " . ($featuredProduct ? $featuredProduct->name : "NONE") . "\n";
echo "Total products for grid: " . $featuredProducts->count() . "\n\n";

foreach ($featuredProducts as $i => $product) {
    $image = $product->image;
    $isAbsolute = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));
    $imageUrl = $image ? ($isAbsolute ? $image : 'asset(' . $image . ')') : 'DEFAULT_FALLBACK';
    
    echo ($i + 1) . ". {$product->name}\n";
    echo "   Raw image: $image\n";
    echo "   Is absolute: " . ($isAbsolute ? "YES" : "NO") . "\n";
    echo "   URL to use: $imageUrl\n";
    echo "   Stock: {$product->stock}\n\n";
}
