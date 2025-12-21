<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== UPLOAD CASING IMAGES ===\n\n";

// Find casing category
$category = Category::where('slug', 'casing')
    ->orWhere('slug', 'case')
    ->orWhere('name', 'LIKE', '%Casing%')
    ->orWhere('name', 'LIKE', '%Case%')
    ->first();

if (!$category) {
    echo "❌ Casing category not found\n";
    echo "\nAvailable categories:\n";
    Category::all()->each(function($cat) {
        echo "  - {$cat->name} (slug: {$cat->slug})\n";
    });
    exit;
}

$products = Product::where('category_id', $category->id)->get();
echo "Found {$products->count()} casing products\n\n";

// Mapping casing images
$casingImages = [
    'NZXT H510' => 'images/products/nzxt-h510.jpg',
    'NZXT H7' => 'images/products/nzxt-h7-flow.jpg',
    'Lian Li LANCOOL 205' => 'images/products/lianli-lancool-205.jpg',
    'Lian Li LANCOOL 215' => 'images/products/lianli-lancool.jpg',
    'Lian Li Lancool 216' => 'images/products/lianli-lancool.jpg',
    'Phanteks Eclipse' => 'images/products/phanteks-eclipse.jpg',
    'Cube Gaming' => 'images/products/cube-gaming.jpg',
    'Armageddon' => 'images/products/armaggeddon.jpg',
    'Paradox Gaming' => 'images/products/paradox-gaming-cortex.jpg',
    'Tecware Forge' => 'images/products/techware-forge.jpg',
    'Vortex' => 'images/products/vortex-casing.jpg',
    'Cooler Master MasterBox' => 'images/products/cube-gaming.jpg', // fallback
];

$updated = 0;

foreach ($products as $product) {
    $imageFound = false;
    
    foreach ($casingImages as $keyword => $imagePath) {
        if (stripos($product->name, $keyword) !== false) {
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
echo "Updated: {$updated} / {$products->count()} casing products\n";
echo "✅ Done!\n";
