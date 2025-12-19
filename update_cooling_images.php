<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Cari kategori Cooling
$coolingCategory = App\Models\Category::where('name', 'LIKE', '%Cooling%')->first();

if (!$coolingCategory) {
    echo " Kategori Cooling tidak ditemukan\n";
    exit;
}

// Get all cooling products
$products = App\Models\Product::where('category_id', $coolingCategory->id)->get();

echo "=== PRODUK COOLING ===\n";
echo "Total: {$products->count()} products\n\n";

$imageMap = [
    'Intel Stock Cooler' => 'images/products/intel-stock-cooler.png',
    'AMD Wraith Stealth' => 'images/products/intel-stock-cooler.png', // using same as placeholder
    'DeepCool GAMMAXX 400' => 'images/products/deepcool-gammaxx.jpg',
    'Cooler Master Hyper 212' => 'images/products/cooler-master.jpg',
    'DeepCool AK400' => 'images/products/deepcool-gammaxx.jpg',
    'DeepCool LS520' => 'images/products/deepcool-ls520.jpg',
    'NZXT Kraken X53' => 'images/products/deepcool-castle.jpg', // using deepcool as placeholder
    'DeepCool CASTLE 280EX' => 'images/products/deepcool-castle.jpg',
];

foreach($products as $p) {
    echo "ID: {$p->id} | {$p->name}\n";
    echo "  Current: " . ($p->image ?: 'NULL') . "\n";
    
    // Find matching image
    $updated = false;
    foreach($imageMap as $keyword => $imagePath) {
        if (stripos($p->name, $keyword) !== false) {
            $p->image = $imagePath;
            $p->save();
            echo "   Updated: {$imagePath}\n";
            $updated = true;
            break;
        }
    }
    
    if (!$updated) {
        echo "   No image match found\n";
    }
    echo "\n";
}
