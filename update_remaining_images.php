<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;

echo "=== Updating Remaining Product Images ===\n\n";

// Cek produk tanpa gambar
$products = Product::whereNull('image')->get();

echo "Found " . $products->count() . " products without images\n\n";

foreach ($products as $product) {
    echo "ID {$product->id}: {$product->name}\n";
}

// Manual mapping untuk produk yang tersisa
$manualMapping = [
    // RTX 4060 dan 4070 - nama lengkapnya berbeda
    'NVIDIA GeForce RTX 4060' => 'rtx-4060-card.png',
    'NVIDIA GeForce RTX 4070' => 'RTX4070-TWIN-EDGE-card.jpg',
    
    // RAM dengan nama berbeda
    'Corsair Vengeance RGB' => 'corsair-3600-memory.jpg',
    'Corsair Vengeance DDR5' => 'corsair-6000-memory.jpg',
    'G.Skill Ripjaws' => 'g.skill-3600-memory.png',
    'Kingston Fury Beast' => 'kingston-3200-memory.jpg',
    
    // Motherboard
    'Gigabyte B760M' => 'Gigabyte-B760M-Aorus-Elite-AX-board.png',
    'MSI MAG B650' => 'MSI-MAG-B650-Tomahawk-WiFi-board.png',
    
    // Storage
    'Kingston NV2 1TB' => 'Kingston NV2 1TB NVMe-storage.jpg',
    
    // PSU
    'Cooler Master MWE Gold' => 'Cooler-Master-MWE-Gold-650-psu.jpg',
    'Corsair RM750x' => 'Corsair-RM750x-80Plus-Gold-psu.jpg',
    
    // Casing
    'Armaggeddon' => 'armaggeddon.jpg',
    'Cooler Master' => 'cooler-master.jpg',
    'Cube Gaming' => 'cube-gaming.jpg',
    'Lian Li Lancool' => 'lianli-lancool-205.jpg',
    'NZXT H7' => 'nzxt-h7-flow.jpg',
    'Paradox' => 'paradox-gaming-cortex.jpg',
    'Phanteks' => 'phanteks-eclipse.jpg',
    'Techware' => 'techware-forge.jpg',
    'Vortex' => 'vortex-casing.jpg',
    
    // CPU Coolers
    'DeepCool AK' => 'deepcool-gammaxx.jpg',
    'DeepCool LS' => 'deepcool-ls520.jpg',
    'Noctua NH' => 'noctua-nh.jpg',
];

echo "\n=== Applying Manual Mappings ===\n\n";

$updated = 0;

foreach ($manualMapping as $namePattern => $imageFile) {
    $products = Product::where('name', 'LIKE', "%$namePattern%")
                      ->whereNull('image')
                      ->get();
    
    foreach ($products as $product) {
        $product->image = "images/products/$imageFile";
        $product->save();
        echo "✅ Updated: {$product->name} -> $imageFile\n";
        $updated++;
    }
}

echo "\n=== Summary ===\n";
echo "✅ Total updated: $updated products\n";

// Final check
$remaining = Product::whereNull('image')->count();
echo "📊 Remaining without images: $remaining products\n";

$withImages = Product::whereNotNull('image')->count();
echo "✅ Total with images: $withImages / " . Product::count() . " products\n";

echo "\nDone!\n";
