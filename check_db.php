<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$productCount = App\Models\Product::count();
$categoryCount = App\Models\Category::count();

echo "=== CEK DATABASE ===\n\n";
echo "Total Categories: $categoryCount\n";
echo "Total Products: $productCount\n\n";

if ($productCount == 0) {
    echo " DATA PRODUK KOSONG!\n";
    echo "Perlu menjalankan ulang semua seeder produk.\n";
} else {
    echo " Data produk masih ada.\n";
}
