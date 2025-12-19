<?php
/**
 * Script untuk update gambar NZXT H7 Flow
 * Jalankan: php update_nzxt_image.php
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Cari produk NZXT H7 Flow
$product = App\Models\Product::find(13);

if(!$product) {
    echo "❌ Produk tidak ditemukan!\n";
    exit;
}

echo "=== UPDATE GAMBAR PRODUK ===\n\n";
echo "Produk: {$product->name}\n";
echo "Image Lama: {$product->image}\n";

// Cek file gambar yang tersedia
$imageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
$imagePath = null;

foreach($imageExtensions as $ext) {
    $checkPath = public_path("images/products/{$product->slug}.{$ext}");
    if(file_exists($checkPath)) {
        $imagePath = "images/products/{$product->slug}.{$ext}";
        echo "✅ File ditemukan: {$checkPath}\n";
        break;
    }
}

if($imagePath) {
    $product->image = $imagePath;
    $product->save();
    
    echo "\n✅ SUKSES!\n";
    echo "Image Baru: {$product->image}\n";
    echo "URL: {$product->image_url}\n";
    echo "\nRefresh browser untuk melihat perubahan!\n";
} else {
    echo "\n❌ File gambar tidak ditemukan!\n";
    echo "Pastikan file sudah di-copy ke:\n";
    echo public_path("images/products/{$product->slug}.jpg") . "\n";
    echo "\nFormat yang dicari:\n";
    foreach($imageExtensions as $ext) {
        echo "- {$product->slug}.{$ext}\n";
    }
}
