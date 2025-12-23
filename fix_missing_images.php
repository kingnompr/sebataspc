<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== FIXING MISSING IMAGES ===\n\n";

$updates = [
    'AMD Ryzen 5 5600' => 'images/products/AMD Ryzen 5 5600-prosesor.jpg',
    'Corsair Vengeance LPX 8GB DDR4-3200' => 'images/products/corsair-3200-memory.jpg',
    'Kingston FURY Impact 8GB DDR4-3200' => 'images/products/kingston-3200-memory.jpg',
    'G.Skill Ripjaws V 16GB (2x8GB) DDR4-3200' => 'images/products/g.skill-3200-memory.jpg',
    'TeamGroup T-Force Vulcan Z 16GB DDR4-3200' => 'images/products/teamgroup-3200-memory.jpg',
    'Corsair Vengeance LPX 32GB (2x16GB) DDR4-3600' => 'images/products/corsair-3600-16gb-memory.jpg',
    'Kingston FURY Beast 32GB (2x16GB) DDR5-5200' => 'images/products/kingston-5200-memory.jpg',
    'Corsair Dominator Platinum RGB 32GB DDR5-5600' => 'images/products/corsair-5600-memory.jpg',
];

$updated = 0;
$notFound = 0;

foreach ($updates as $name => $image) {
    $product = Product::where('name', 'LIKE', "%{$name}%")->first();
    
    if ($product) {
        $product->update(['image' => $image]);
        echo "✅ Updated: {$name}\n";
        echo "   Image: {$image}\n\n";
        $updated++;
    } else {
        echo "❌ Not found: {$name}\n\n";
        $notFound++;
    }
}

echo "\n=== SUMMARY ===\n";
echo "✅ Updated: {$updated} products\n";
echo "❌ Not found: {$notFound} products\n";

// Verify
echo "\n=== VERIFICATION ===\n";
$stillMissing = Product::whereNull('image')->orWhere('image', '')->count();
echo "Produk masih tanpa gambar: {$stillMissing}\n";

if ($stillMissing == 0) {
    echo "✅ SEMUA PRODUK SUDAH MEMILIKI GAMBAR!\n";
}
