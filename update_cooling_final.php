<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$updates = [
    77 => 'images/products/amd-wraith-stealth.jpg',  // AMD Wraith Stealth
    80 => 'images/products/scythe-mugen.jpg',        // Scythe Mugen 5
    81 => 'images/products/noctua-nh.jpg',           // Noctua NH-U12S
    82 => 'images/products/deepcool-castle.jpg',     // Deepcool Castle 240EX
    83 => 'images/products/corsair-icue.jpg',        // Corsair iCUE H100i
];

echo "=== UPDATE GAMBAR COOLING ===\n\n";

foreach($updates as $id => $imagePath) {
    $product = App\Models\Product::find($id);
    if ($product) {
        $product->image = $imagePath;
        $product->save();
        echo " ID {$id}: {$product->name}\n";
        echo "   Updated to: {$imagePath}\n\n";
    }
}

echo "Total updated: " . count($updates) . " products\n";
