<?php
/**
 * Script untuk update gambar produk dari halaman produk
 * Jalankan: php update_product_images.php
 * 
 * CARA PAKAI:
 * 1. Upload gambar ke folder public/images/products/
 * 2. Update kolom 'image' di database dengan path relatif
 * 3. Gambar akan otomatis muncul di Smart PC Builder
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== UPDATE GAMBAR PRODUK ===\n\n";
echo "Contoh cara update gambar produk:\n\n";

// Contoh 1: Update satu produk (NZXT H7 Flow)
echo "CONTOH 1: Update gambar NZXT H7 Flow\n";
echo "----------------------------------------\n";
$nzxt = Product::where('name', 'LIKE', '%NZXT H7%')->first();
if ($nzxt) {
    echo "Produk: {$nzxt->name}\n";
    echo "ID: {$nzxt->id}\n";
    echo "Image saat ini: " . ($nzxt->image ?: 'NULL') . "\n\n";
    
    echo "LANGKAH-LANGKAH:\n";
    echo "1. Simpan gambar Anda sebagai: nzxt-h7-flow.jpg\n";
    echo "2. Copy ke: public/images/products/nzxt-h7-flow.jpg\n";
    echo "3. Jalankan perintah berikut:\n\n";
    echo "   php artisan tinker\n";
    echo "   >>> \$p = Product::find({$nzxt->id});\n";
    echo "   >>> \$p->image = 'images/products/nzxt-h7-flow.jpg';\n";
    echo "   >>> \$p->save();\n\n";
    
    echo "ATAU via SQL:\n";
    echo "   UPDATE products SET image = 'images/products/nzxt-h7-flow.jpg' WHERE id = {$nzxt->id};\n\n";
}

// Contoh 2: Bulk update untuk semua produk casing
echo "\nCONTOH 2: Bulk update semua casing\n";
echo "----------------------------------------\n";
$casings = Product::whereHas('category', function($q) {
    $q->where('name', 'LIKE', '%Casing%');
})->get();

echo "Total produk Casing: {$casings->count()}\n\n";

foreach ($casings as $casing) {
    $slug = \Illuminate\Support\Str::slug($casing->name);
    echo "- {$casing->name}\n";
    echo "  Slug: {$slug}\n";
    echo "  Simpan gambar sebagai: {$slug}.jpg\n";
    echo "  Path database: images/products/{$slug}.jpg\n\n";
}

echo "\nCONTOH 3: Update dari URL eksternal\n";
echo "----------------------------------------\n";
echo "Jika gambar sudah ada di website lain atau CDN:\n\n";
echo "php artisan tinker\n";
echo ">>> \$p = Product::find(13);\n";
echo ">>> \$p->image = 'https://example.com/images/nzxt-h7-flow.jpg';\n";
echo ">>> \$p->save();\n\n";

echo "\n=== HASIL AKHIR ===\n";
echo "Setelah update image, gambar akan otomatis muncul di:\n";
echo "- Halaman produk\n";
echo "- Smart PC Builder\n";
echo "- Katalog\n";
echo "- Semua tempat yang menggunakan \$product->image_url\n\n";

echo "TIDAK PERLU ubah kode PHP/Blade!\n";
echo "Model Product sudah otomatis handle image URL.\n\n";
