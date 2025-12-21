<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== UPDATE MEMORY PRODUCT IMAGES ===\n\n";

// Mapping spesifik untuk memory berdasarkan nama yang ada
$updates = [
    // Corsair
    ['search' => 'Corsair Vengeance 32GB', 'image' => 'images/products/corsair-6000-memory.jpg'],
    ['search' => 'Corsair Vengeance 16GB DDR5', 'image' => 'images/products/corsair-5600-memory.jpg'],
    ['search' => 'Corsair Vengeance RGB Pro 16GB DDR4-3600', 'image' => 'images/products/corsair-3600-16gb-memory.jpg'],
    ['search' => 'Corsair Vengeance LPX 16GB DDR4-3200', 'image' => 'images/products/corsair-3200-memory.jpg'],
    ['search' => 'Corsair Vengeance RGB Pro 32GB DDR4-3600', 'image' => 'images/products/corsair-3600-memory.jpg'],
    
    // G.Skill  
    ['search' => 'G.Skill Ripjaws S5 16GB DDR5', 'image' => 'images/products/g.skill-5600-memory.png'],
    ['search' => 'G.Skill Ripjaws V 16GB DDR4-3600', 'image' => 'images/products/g.skill-3600-memory.png'],
    ['search' => 'G.Skill Aegis 16GB DDR4-3200', 'image' => 'images/products/g.skill-3200-memory.jpg'],
    ['search' => 'G.Skill Trident Z', 'image' => 'images/products/g.skill-3600-memory.png'],
    
    // Kingston
    ['search' => 'Kingston Fury Beast 32GB DDR5', 'image' => 'images/products/kingston-5200-memory.jpg'],
    ['search' => 'Kingston Fury Beast 16GB DDR4', 'image' => 'images/products/kingston-3200-memory.jpg'],
    
    // Crucial
    ['search' => 'Crucial Ballistix', 'image' => 'images/products/crucial-3200-memory.jpg'],
    
    // Team
    ['search' => 'Team T-Force Delta RGB', 'image' => 'images/products/teamgroup-3200-memory.jpg'],
    ['search' => 'Team Elite Plus DDR4', 'image' => 'images/products/teamelite-2666-memory.jpg'],
];

$updated = 0;

foreach ($updates as $update) {
    $products = Product::where('name', 'LIKE', "%{$update['search']}%")->get();
    
    foreach ($products as $product) {
        $product->image = $update['image'];
        $product->save();
        echo "✅ {$product->name}\n";
        $updated++;
    }
}

echo "\n=== SUMMARY ===\n";
echo "Total updated: $updated memory products\n";
echo "\n✅ All memory images synced!\n";
