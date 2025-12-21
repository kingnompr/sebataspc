<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

echo "=== UPDATE PROCESSOR IMAGES ===\n\n";

// Mapping nama processor dengan file gambar
$processorImages = [
    'AMD Ryzen 3 3200G' => 'AMD Ryzen 3 3200G-prosesor.png',
    'AMD Ryzen 5 3600' => 'AMD Ryzen 5 3600-prosesor.jpg',
    'AMD Ryzen 5 5600' => 'AMD Ryzen 5 5600-prosesor.jpg',
    'AMD Ryzen 5 5600G' => 'AMD Ryzen 5 5600G-prosesor.jpg',
    'AMD Ryzen 5 7600X' => 'AMD Ryzen 5 7600X-prosesor.jpg',
    'AMD Ryzen 7 5700X' => 'AMD Ryzen 7 5700X-prosesor.png',
    'AMD Ryzen 9 5900X' => 'AMD Ryzen 9 5900X-prosesor.jpg',
    'Intel Core i3-10105' => 'Intel Core i3-10105-prosesor.png',
    'Intel Core i3-12100' => 'Intel Core i3-12100-prosesor.jpg',
    'Intel Core i5-10400F' => 'Intel Core i5-10400F-prosesor.jpg',
    'Intel Core i5-12400F' => 'Intel Core i5-12400F-prosesor.jpg',
    'Intel Core i5-12600KF' => 'Intel Core i5-12600KF-prosesor.jpg',
    'Intel Core i5-13600K' => 'Intel Core i5-13600K-prosesor.jpg',
    'Intel Core i7-12700' => 'Intel Core i7-12700-prosesor.jpg',
    'Intel Core i7-13700K' => 'Intel Core i7-13700K-prosesor.jpg',
];

$updated = 0;
$notFound = 0;

foreach ($processorImages as $processorName => $imageFile) {
    // Cari product berdasarkan nama
    $product = Product::where('category_id', 1) // 1 = Processor
                      ->where('name', 'LIKE', '%' . $processorName . '%')
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
            echo "   For product: {$processorName}\n\n";
        }
    } else {
        echo "⚠️  Product not found: {$processorName}\n\n";
        $notFound++;
    }
}

echo "\n=== SUMMARY ===\n";
echo "Updated: {$updated} processors\n";
echo "Not found: {$notFound} processors\n";

// Tampilkan processor yang belum punya gambar
echo "\n=== PROCESSORS WITHOUT IMAGES ===\n";
$processorsWithoutImages = Product::where('category_id', 1)
    ->whereNull('image')
    ->orWhere('image', '')
    ->get();

if ($processorsWithoutImages->count() > 0) {
    foreach ($processorsWithoutImages as $processor) {
        echo "- {$processor->name}\n";
    }
} else {
    echo "✅ All processors have images!\n";
}

echo "\nDone!\n";
