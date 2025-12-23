<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;

echo "=== Updating products with missing images ===\n\n";

// Mapping produk yang tidak punya gambar yang sesuai dengan gambar generic
$updates = [
    'Deepcool Gammaxx 400 V2' => 'images/products/cooler-master.jpg',
    'Cooler Master Hyper 212 Black Edition' => 'images/products/cooler-master.jpg',
    'Noctua NH-U12S Redux' => 'images/products/noctua-nh.jpg',
    'Armageddon Casing MX5 mATX' => 'images/products/vortex-casing.jpg',
    'Vortex Casing VX5 ATX' => 'images/products/vortex-casing.jpg',
    'Cube Gaming Hexa ATX Mesh' => 'images/products/cube-gaming.jpg',
    'Tecware Forge M ARGB ATX' => 'images/products/vortex-casing.jpg',
    'Cooler Master MasterBox MB510L' => 'images/products/cooler-master-mb.jpg',
    'Lian Li LANCOOL 215 ATX' => 'images/products/lianli-lancool.jpg',
    'Phanteks Eclipse P400A D-RGB' => 'images/products/phanteks-eclipse.jpg',
];

$fixed = 0;

foreach ($updates as $productName => $imagePath) {
    $product = Product::where('name', 'LIKE', "%{$productName}%")->first();
    
    if ($product) {
        // Check if the image file exists
        if (file_exists(public_path($imagePath))) {
            $product->update(['image' => $imagePath]);
            echo "✅ Updated: {$product->name}\n";
            echo "   Image: $imagePath\n\n";
            $fixed++;
        } else {
            echo "⚠️  Image not found for: {$product->name} ($imagePath)\n\n";
        }
    } else {
        echo "❌ Product not found: $productName\n\n";
    }
}

echo "=== Summary ===\n";
echo "Fixed: $fixed products\n";
