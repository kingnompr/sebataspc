<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== UPLOAD PSU IMAGES ===\n\n";

$category = Category::where('slug', 'psu')
    ->orWhere('slug', 'power-supply')
    ->orWhere('name', 'LIKE', '%Power Supply%')
    ->orWhere('name', 'LIKE', '%PSU%')
    ->first();

if (!$category) {
    echo "❌ PSU category not found\n";
    exit;
}

$products = Product::where('category_id', $category->id)->get();
echo "Found {$products->count()} PSU products\n\n";

// Mapping exact PSU images
$psuImages = [
    'Corsair RM750x 80+ Gold' => 'images/products/Corsair-RM750x-80Plus-Gold-psu.jpg',
    'Cooler Master MWE Gold 650' => 'images/products/Cooler-Master-MWE-Gold-650-psu.jpg',
    'Corsair CV550 550W 80+ Bronze' => 'images/products/Corsair-CV550-550W-80Plus-Bronze-psu.jpg',
    'Cooler Master MWE 550 Bronze V2' => 'images/products/Cooler-Master-MWE-550-Bronze-V2-psu.jpg',
    'Seasonic S12III 650W 80+ Bronze' => 'images/products/Seasonic-S12III-650W-80Plus-Bronze-psu.jpg',
    'Corsair TX650M 650W 80+ Gold Semi-Modular' => 'images/products/Corsair-TX650M-650W-80Plus-Gold-Semi-Modular-psu.jpg',
    'EVGA SuperNOVA 750 G5 750W 80+ Gold' => 'images/products/EVGA-SuperNOVA-750-G5-750W-80Plus-Gold-psu.png',
    'Seasonic Focus GX-850 850W 80+ Gold' => 'images/products/Seasonic-Focus-GX-850-850W-80Plus-Gold-psu.png',
];

$updated = 0;

foreach ($products as $product) {
    $imageFound = false;
    
    foreach ($psuImages as $keyword => $imagePath) {
        if (stripos($product->name, $keyword) !== false || $product->name === $keyword) {
            $product->image = $imagePath;
            $product->save();
            
            echo "✅ {$product->name}\n";
            echo "   📷 {$imagePath}\n";
            
            $imageFound = true;
            $updated++;
            break;
        }
    }
    
    if (!$imageFound) {
        echo "⚠️  {$product->name} - No matching image\n";
    }
}

echo "\n=== SUMMARY ===\n";
echo "Updated: {$updated} / {$products->count()} PSU products\n";
echo "✅ Done!\n";
