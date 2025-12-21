<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

echo "=== STORAGE PRODUCTS IN DATABASE ===\n\n";

$products = Product::where('category_id', 5)->get(['id', 'name', 'image']);

foreach($products as $p) {
    $hasImage = $p->image ? '✅' : '❌';
    echo "{$hasImage} [{$p->id}] {$p->name}\n";
}

echo "\nTotal: " . $products->count() . " products\n";
