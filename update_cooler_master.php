<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Cari produk Cooler Master
$products = App\Models\Product::where('name', 'LIKE', '%Cooler Master%')->get();

echo "=== PRODUK COOLER MASTER ===\n\n";

foreach($products as $p) {
    echo "ID: {$p->id}\n";
    echo "Name: {$p->name}\n";
    echo "Current Image: " . ($p->image ?: 'NULL') . "\n";
    echo "\n";
    
    // Update image
    $p->image = 'images/products/cooler-master.jpg';
    $p->save();
    echo " Updated to: {$p->image}\n";
    echo str_repeat('-', 60) . "\n\n";
}

echo "Total updated: " . $products->count() . " products\n";
