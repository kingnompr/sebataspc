<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$casingCategory = App\Models\Category::where('slug', 'case')->first();

if ($casingCategory) {
    $count = App\Models\Product::where('category_id', $casingCategory->id)->count();
    echo "Casing products in database: $count\n\n";
    
    $casings = App\Models\Product::where('category_id', $casingCategory->id)->orderBy('price')->get();
    foreach ($casings as $casing) {
        echo "- {$casing->name} (Rp " . number_format($casing->price, 0, ',', '.') . ")\n";
    }
} else {
    echo "❌ Casing category not found\n";
}
