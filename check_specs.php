<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$products = App\Models\Product::with('category')->take(5)->get();

foreach ($products as $product) {
    echo "Product: {$product->name}\n";
    echo "Category: {$product->category->name}\n";
    echo "Snapshot: " . json_encode($product->snapshot, JSON_PRETTY_PRINT) . "\n";
    echo "---\n\n";
}
