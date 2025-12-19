<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== UPDATE GAMBAR CASING ===\n\n";

// Mapping nama file ke nama produk (case-insensitive search)
$imageMapping = [
    'nzxt-h7-flow.jpg' => 'NZXT H7 Flow',
    'lianli-lancool-205.jpg' => 'Lian Li Lancool 205',
    'armaggeddon.jpg' => 'Armageddon',
    'vortex-casing.jpg' => 'Vortex',
    'cube-gaming.jpg' => 'Cube Gaming',
    'techware-forge.jpg' => 'Tecware Forge',
    'nzxt-h510.jpg' => 'NZXT H510',
    'cooler-master.jpg' => 'Cooler Master',
    'lianli-lancool.jpg' => 'LIAN LI LANCOOL 215',
    'phanteks-eclipse.jpg' => 'Phanteks Eclipse',
    'paradox-gaming-cortex.jpg' => 'Paradox Gaming',
];

$updated = 0;
$notFound = [];

foreach ($imageMapping as $fileName => $searchName) {
    $product = Product::where('name', 'LIKE', "%{$searchName}%")->first();
    
    if ($product) {
        $product->image = 'images/products/' . $fileName;
        $product->save();
        echo " {$product->name}\n";
        echo "   Image: images/products/{$fileName}\n\n";
        $updated++;
    } else {
        $notFound[] = $searchName;
        echo " Produk tidak ditemukan: {$searchName}\n\n";
    }
}

echo "\n=== SUMMARY ===\n";
echo "Updated: {$updated} products\n";
if (!empty($notFound)) {
    echo "Not found: " . implode(', ', $notFound) . "\n";
}
