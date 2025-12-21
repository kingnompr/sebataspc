<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== UPDATE PRODUCT IMAGES ===\n\n";

// Mapping nama produk ke file gambar yang ada
$imageMap = [
    // Graphics Cards
    'GTX 1650' => 'images/products/GTX-1650-card.png',
    'GTX 1660' => 'images/products/gtx-1660-card.jpg',
    'RTX 3060' => 'images/products/rtx-3060-card.png',
    'RTX 3070' => 'images/products/rtx-3070-card.png',
    'RTX 4060' => 'images/products/rtx-4060-card.png',
    'RTX 4070' => 'images/products/RTX4070-TWIN-EDGE-card.jpg',
    'RX 6500' => 'images/products/RX-6500-card.jpg',
    'RX 6600' => 'images/products/rx-6600-card.png',
    'RX 6700' => 'images/products/RX-6700-card.jpg',
    'RX 6800' => 'images/products/rx-6800-card.jpg',
    
    // Memory
    'Corsair Vengeance 32GB DDR5-6000' => 'images/products/corsair-6000-memory.jpg',
    'Corsair Vengeance DDR5 5600MHz' => 'images/products/corsair-5600-memory.jpg',
    'Corsair Vengeance RGB 16GB DDR4-3600' => 'images/products/corsair-3600-16gb-memory.jpg',
    'Corsair Vengeance LPX 16GB DDR4-3200' => 'images/products/corsair-3200-memory.jpg',
    'G.Skill Ripjaws S5' => 'images/products/g.skill-5600-memory.png',
    'G.Skill Ripjaws V 16GB DDR4-3600' => 'images/products/g.skill-3600-memory.png',
    'G.Skill Aegis 16GB DDR4-3200' => 'images/products/g.skill-3200-memory.jpg',
    'Kingston Fury Beast DDR5 5200MHz' => 'images/products/kingston-5200-memory.jpg',
    'Kingston Fury Beast 16GB DDR4-3200' => 'images/products/kingston-3200-memory.jpg',
    'Team Elite DDR4-2666' => 'images/products/teamelite-2666-memory.jpg',
    'Team T-Force Delta RGB 16GB DDR4-3200' => 'images/products/teamgroup-3200-memory.jpg',
    
    // Cooling
    'DeepCool AK400' => 'images/products/deepcool-gammaxx.jpg',
    'DeepCool LS520' => 'images/products/deepcool-ls520.jpg',
    'DeepCool Castle 360EX' => 'images/products/deepcool-castle.jpg',
    'Noctua NH-D15' => 'images/products/noctua-nh.jpg',
    'Scythe Mugen 5' => 'images/products/scythe-mugen.jpg',
    'Corsair iCUE H150i' => 'images/products/corsair-icue.jpg',
    'AMD Wraith Stealth' => 'images/products/amd-wraith-stealth.jpg',
    'Intel Stock Cooler' => 'images/products/intel-stock-cooler.png',
    'Cooler Master MasterLiquid' => 'images/products/cooler-master.jpg',
    
    // Casing
    'NZXT H510 Elite' => 'images/products/nzxt-h510.jpg',
    'NZXT H7 Flow' => 'images/products/nzxt-h7-flow.jpg',
    'Lian Li Lancool 205' => 'images/products/lianli-lancool-205.jpg',
    'Lian Li Lancool 216' => 'images/products/lianli-lancool.jpg',
    'Phanteks Eclipse P400A' => 'images/products/phanteks-eclipse.jpg',
    'Armageddon' => 'images/products/armaggeddon.jpg',
    'Cube Gaming Draco' => 'images/products/cube-gaming.jpg',
    'Paradox Gaming Cortex' => 'images/products/paradox-gaming-cortex.jpg',
    'Vortex' => 'images/products/vortex-casing.jpg',
    'Tecware Forge M' => 'images/products/techware-forge.jpg',
];

$updated = 0;
$notFound = [];

foreach ($imageMap as $searchTerm => $imagePath) {
    // Cari produk yang namanya mengandung searchTerm
    $products = Product::where('name', 'LIKE', "%{$searchTerm}%")->get();
    
    if ($products->count() > 0) {
        foreach ($products as $product) {
            $product->image = $imagePath;
            $product->save();
            echo "✅ Updated: {$product->name}\n";
            $updated++;
        }
    } else {
        $notFound[] = $searchTerm;
    }
}

echo "\n=== SUMMARY ===\n";
echo "Updated: $updated products\n";

if (count($notFound) > 0) {
    echo "\nNot found in database:\n";
    foreach ($notFound as $term) {
        echo "  - $term\n";
    }
}

echo "\n✅ Done!\n";
