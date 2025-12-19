<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Checking CPU Products ===\n\n";

$category = App\Models\Category::where('slug', 'cpu')->first();
echo "Category: {$category->name} (ID: {$category->id})\n";
echo "Products in category: " . $category->products()->count() . "\n\n";

echo "All products with CPU category:\n";
$products = App\Models\Product::where('category_id', $category->id)->get();
foreach ($products as $p) {
    echo "- {$p->name} (Rp " . number_format($p->price) . ")\n";
}

echo "\n\n=== Testing whereHas query ===\n";
$count = App\Models\Product::whereHas('category', function($q) {
    $q->where('name', 'LIKE', '%Processor%');
})->count();
echo "Products found with whereHas (Processor): {$count}\n";

echo "\n\n=== Testing specific price range ===\n";
$minPrice = 2550000;
$maxPrice = 3450000;
echo "Range: Rp " . number_format($minPrice) . " - Rp " . number_format($maxPrice) . "\n";

$productsInRange = App\Models\Product::whereHas('category', function($q) {
        $q->where('name', 'LIKE', '%Processor%');
    })
    ->whereBetween('price', [$minPrice, $maxPrice])
    ->where('stock', '>', 0)
    ->orderByDesc('rating')
    ->orderByDesc('is_featured')
    ->get();

echo "Found " . $productsInRange->count() . " products:\n";
foreach ($productsInRange as $p) {
    echo "- {$p->name} (Rp " . number_format($p->price) . ") - Rating: {$p->rating}\n";
}
