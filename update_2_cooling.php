<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== UPDATE 2 GAMBAR COOLING ===\n\n";

// Update Deepcool Gammaxx 400 V2
$gammaxx = Product::where('name', 'LIKE', '%Gammaxx 400%')->first();
if ($gammaxx) {
    $gammaxx->image = 'images/products/deepcool-gammaxx.jpg';
    $gammaxx->save();
    echo "✅ {$gammaxx->name}\n";
    echo "   📷 {$gammaxx->image}\n\n";
}

// Update Cooler Master Hyper 212
$hyper212 = Product::where('name', 'LIKE', '%Hyper 212%')->first();
if ($hyper212) {
    $hyper212->image = 'images/products/cooler-master.jpg';
    $hyper212->save();
    echo "✅ {$hyper212->name}\n";
    echo "   📷 {$hyper212->image}\n\n";
}

echo "✅ Done!\n";
