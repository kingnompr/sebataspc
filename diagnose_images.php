<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

echo "=== Image Storage Diagnosis ===\n\n";

echo "1. Checking Storage Symlink:\n";
if (file_exists(public_path('storage'))) {
    echo "   ✓ Storage symlink EXISTS at public/storage\n";
    echo "   Real path: " . realpath(public_path('storage')) . "\n";
} else {
    echo "   ✗ Storage symlink MISSING at public/storage\n";
}

echo "\n2. Checking Storage Directory:\n";
$storagePath = storage_path('app/public');
if (is_dir($storagePath)) {
    echo "   ✓ Storage directory EXISTS: $storagePath\n";
} else {
    echo "   ✗ Storage directory MISSING: $storagePath\n";
}

echo "\n3. Checking Products with Images:\n";
$productsWithImages = Product::whereNotNull('image')->take(5)->get();
echo "   Found " . $productsWithImages->count() . " products with images\n\n";

foreach ($productsWithImages as $product) {
    echo "   Product: {$product->name}\n";
    echo "   DB Image Path: {$product->image}\n";
    
    // Extract path from storage/path/to/image
    $imagePath = str_replace('storage/', '', $product->image);
    $fullPath = storage_path('app/public/' . $imagePath);
    
    echo "   Full Path: $fullPath\n";
    echo "   File Exists: " . (file_exists($fullPath) ? "YES" : "NO") . "\n";
    
    // Check if accessible via public
    $publicPath = public_path($product->image);
    echo "   Public Path: $publicPath\n";
    echo "   Accessible via public: " . (file_exists($publicPath) ? "YES" : "NO") . "\n";
    
    echo "\n";
}

echo "4. Configuration Check:\n";
echo "   APP_URL: " . config('app.url') . "\n";
echo "   Storage URL: " . config('filesystems.disks.public.url') . "\n";

