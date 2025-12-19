<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$gpuCategory = App\Models\Category::where('slug', 'gpu')->first();

if ($gpuCategory) {
    $count = App\Models\Product::where('category_id', $gpuCategory->id)->count();
    echo "GPU products in database: $count\n\n";
    
    $gpus = App\Models\Product::where('category_id', $gpuCategory->id)->get();
    foreach ($gpus as $gpu) {
        echo "- {$gpu->name} (Rp " . number_format($gpu->price, 0, ',', '.') . ")\n";
    }
} else {
    echo "❌ GPU category not found\n";
}
