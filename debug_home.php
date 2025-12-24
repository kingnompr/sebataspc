<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== HOME PAGE DEBUG ===\n\n";

// Check if products table exists and has data
$totalProducts = Product::count();
echo "Total products in DB: $totalProducts\n";

if ($totalProducts == 0) {
    echo "❌ PROBLEM: No products in database!\n";
    echo "This means the database was likely reset on deployment.\n";
    exit;
}

// Check products with images
$withImages = Product::whereNotNull('image')->where('image', '!=', '')->count();
echo "Products with images: $withImages\n";

if ($withImages == 0) {
    echo "❌ PROBLEM: No products have images!\n";
    echo "The image update didn't persist.\n";
    exit;
}

// Check featured products
$featured = Product::where('is_featured', 1)->count();
echo "Featured products: $featured\n";

// Check categories
$categories = Product::with('category')->get()->pluck('category')->unique();
echo "Total categories with products: " . $categories->count() . "\n";

echo "\n=== Sample Products ===\n";
$samples = Product::with('category')->take(5)->get();
foreach ($samples as $p) {
    echo "\n{$p->name}\n";
    $catName = $p->category ? $p->category->name : 'N/A';
    $img = $p->image ? substr($p->image, 0, 60) : 'NONE';
    echo "  Category: $catName\n";
    echo "  Image: $img...\n";
    echo "  Stock: {$p->stock}\n";
    echo "  Featured: {$p->is_featured}\n";
}

echo "\n=== Home Page Products ===\n";

$featuredProducts = collect();

$cpus = Product::with('category')
    ->where('category_id', 1)
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->where('stock', '>', 0)
    ->inRandomOrder()
    ->take(3)
    ->get();
$featuredProducts = $featuredProducts->merge($cpus);

$gpus = Product::with('category')
    ->where('category_id', 2)
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->where('stock', '>', 0)
    ->inRandomOrder()
    ->take(3)
    ->get();
$featuredProducts = $featuredProducts->merge($gpus);

$storage = Product::with('category')
    ->where('category_id', 5)
    ->whereNotNull('image')
    ->where('image', '!=', '')
    ->where('stock', '>', 0)
    ->inRandomOrder()
    ->take(3)
    ->get();
$featuredProducts = $featuredProducts->merge($storage);

echo "Products loaded for home: " . $featuredProducts->count() . "\n";

if ($featuredProducts->count() == 0) {
    echo "❌ NO PRODUCTS TO DISPLAY!\n";
    echo "Checking why...\n";
    
    echo "\nProducts with category_id=1: " . Product::where('category_id', 1)->count() . "\n";
    echo "Products with category_id=2: " . Product::where('category_id', 2)->count() . "\n";
    echo "Products with category_id=5: " . Product::where('category_id', 5)->count() . "\n";
    
    echo "\nProducts with images: " . Product::whereNotNull('image')->where('image', '!=', '')->count() . "\n";
    echo "Products with stock > 0: " . Product::where('stock', '>', 0)->count() . "\n";
} else {
    echo "\n✓ All looks good!\n";
    foreach ($featuredProducts as $p) {
        echo "  - {$p->name}\n";
    }
}
