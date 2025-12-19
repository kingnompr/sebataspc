<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== PRODUCT SUMMARY ===\n\n";
$categories = App\Models\Category::with('products')->get();
foreach($categories as $cat) {
    echo str_pad($cat->name . ':', 20) . $cat->products->count() . " products\n";
}
echo "\n" . str_repeat('-', 40) . "\n";
echo "TOTAL PRODUCTS: " . App\Models\Product::count() . "\n";
