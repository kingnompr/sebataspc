<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Cari produk NZXT H7 Flow
$product = App\Models\Product::where('name', 'LIKE', '%NZXT H7%')->first();

if($product) {
    echo "=== INFORMASI PRODUK NZXT H7 FLOW ===\n\n";
    echo "ID: {$product->id}\n";
    echo "Name: {$product->name}\n";
    echo "Slug: {$product->slug}\n";
    echo "Current Image Path: {$product->image}\n";
    echo "Current Image URL: {$product->image_url}\n";
    echo "\n=== LANGKAH UPLOAD GAMBAR ===\n\n";
    
    echo "1. RENAME FILE GAMBAR ANDA:\n";
    echo "   Dari: nzxt-h7-flow.jpg (atau apapun nama aslinya)\n";
    echo "   Menjadi: {$product->slug}.jpg\n";
    echo "   ATAU: {$product->slug}.png\n";
    echo "   ATAU: {$product->slug}.webp\n\n";
    
    echo "2. COPY FILE KE FOLDER:\n";
    echo "   Lokasi: public\\images\\products\\\n";
    echo "   Full path: " . public_path('images/products/' . $product->slug . '.jpg') . "\n\n";
    
    echo "3. UPDATE DATABASE (pilih salah satu):\n\n";
    
    echo "   OPSI A - Via Artisan Tinker:\n";
    echo "   php artisan tinker\n";
    echo "   >>> \$product = App\\Models\\Product::find({$product->id});\n";
    echo "   >>> \$product->image = 'images/products/{$product->slug}.jpg';\n";
    echo "   >>> \$product->save();\n\n";
    
    echo "   OPSI B - Via SQL:\n";
    echo "   UPDATE products SET image = 'images/products/{$product->slug}.jpg' WHERE id = {$product->id};\n\n";
    
    echo "   OPSI C - Auto-detect (jika nama file = slug):\n";
    echo "   Gambar akan otomatis terdeteksi tanpa update database!\n\n";
    
} else {
    echo "Produk NZXT H7 Flow tidak ditemukan.\n";
    echo "Mencari semua produk NZXT...\n\n";
    
    $nzxtProducts = App\Models\Product::where('name', 'LIKE', '%NZXT%')->get();
    foreach($nzxtProducts as $p) {
        echo "- {$p->name} (slug: {$p->slug})\n";
    }
}
