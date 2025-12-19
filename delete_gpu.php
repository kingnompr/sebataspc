<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$gpuCategory = App\Models\Category::where('slug', 'gpu')->first();

if ($gpuCategory) {
    $count = DB::table('products')->where('category_id', $gpuCategory->id)->delete();
    echo "✅ Deleted $count GPU products\n";
} else {
    echo "❌ GPU category not found\n";
}
