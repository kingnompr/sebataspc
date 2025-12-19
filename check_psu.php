<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$psuCategory = App\Models\Category::where('slug', 'psu')->first();

if ($psuCategory) {
    $count = App\Models\Product::where('category_id', $psuCategory->id)->count();
    echo "PSU products in database: $count\n\n";
    
    $psus = App\Models\Product::where('category_id', $psuCategory->id)->get();
    foreach ($psus as $psu) {
        echo "- {$psu->name} (Rp " . number_format($psu->price, 0, ',', '.') . ")\n";
    }
} else {
    echo "❌ PSU category not found\n";
}
