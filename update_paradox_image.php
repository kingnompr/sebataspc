<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$product = App\Models\Product::where('name', 'LIKE', '%Paradox%')->first();

echo "=== UPDATE GAMBAR PARADOX GAMING ===\n\n";
echo "Produk: {$product->name}\n";
echo "Slug: {$product->slug}\n\n";

// Update dengan nama file yang ada
$product->image = 'images/products/paradox-gaming-cortex.jpg';
$product->save();

echo " BERHASIL DIUPDATE!\n\n";
echo "Image path: {$product->image}\n";
echo "Full URL: " . asset($product->image) . "\n\n";
echo "Refresh browser di halaman:\n";
echo "- http://127.0.0.1:8000/products (Katalog)\n";
echo "- http://127.0.0.1:8000/pc-builds/builder (Smart PC Builder)\n";
