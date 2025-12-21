<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

echo "=== UPDATE STORAGE IMAGES ===\n\n";

// Mapping nama storage dengan file gambar
$storageImages = [
    'ADATA XPG SX8200 Pro 1TB' => 'ADATA XPG SX8200 Pro 1TB-storage.jpg',
    'Crucial MX500 1TB' => 'Crucial MX500 1TB-storage.jpg',
    'Kingston A400 480GB' => 'Kingston A400 480GB-storage.jpg',
    'Kingston NV2 1TB NVMe' => 'Kingston NV2 1TB NVMe-storage.jpg',
    'Kingston NV2 500GB NVMe' => 'Kingston NV2 500GB NVMe-storage.jpg',
    'Samsung 980 PRO 1TB' => 'Samsung 980 PRO 1TB-storage.jpg',
    'Seagate Barracuda 1TB 7200rpm' => 'Seagate Barracuda 1TB 7200rpm-storage.jpg',
    'WD Black SN770 1TB' => 'WD Black SN770 1TB-storage.jpg',
    'WD Blue 2TB 5400rpm' => 'WD Blue 2TB 5400rpm-storage.png',
];

$updated = 0;
$notFound = 0;

foreach ($storageImages as $storageName => $imageFile) {
    // Cari product berdasarkan nama (category_id 5 = Storage)
    $product = Product::where('category_id', 5)
                      ->where('name', 'LIKE', '%' . $storageName . '%')
                      ->first();
    
    if ($product) {
        $imagePath = 'images/products/' . $imageFile;
        $fullPath = public_path($imagePath);
        
        if (file_exists($fullPath)) {
            $product->image = $imagePath;
            $product->save();
            
            echo "✅ Updated: {$product->name}\n";
            echo "   Image: {$imagePath}\n\n";
            $updated++;
        } else {
            echo "❌ Image not found: {$imageFile}\n";
            echo "   For product: {$storageName}\n\n";
        }
    } else {
        echo "⚠️  Product not found: {$storageName}\n\n";
        $notFound++;
    }
}

echo "\n=== SUMMARY ===\n";
echo "Updated: {$updated} storage devices\n";
echo "Not found: {$notFound} products\n";

// Tampilkan storage yang belum punya gambar
echo "\n=== STORAGE WITHOUT IMAGES ===\n";
$storageWithoutImages = Product::where('category_id', 5)
    ->where(function($q) {
        $q->whereNull('image')->orWhere('image', '');
    })
    ->get();

if ($storageWithoutImages->count() > 0) {
    foreach ($storageWithoutImages as $storage) {
        echo "- {$storage->name}\n";
    }
} else {
    echo "✅ All storage devices have images!\n";
}

echo "\nDone!\n";
