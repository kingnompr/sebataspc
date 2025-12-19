<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CATEGORY NAME CHECK ===\n\n";
$categories = App\Models\Category::all();
foreach($categories as $cat) {
    echo "Slug: {$cat->slug} => Name: {$cat->name}\n";
}

echo "\n=== GPU SEARCH TEST ===\n";
echo "Searching for category name LIKE '%VGA%'\n";
$gpuCat = App\Models\Category::where('name', 'LIKE', '%VGA%')->first();
if($gpuCat) {
    echo "Found: {$gpuCat->name}\n";
} else {
    echo "NOT FOUND! Category name is NOT 'VGA'\n";
    echo "Actual GPU category name: ";
    $actualGpu = App\Models\Category::where('slug', 'gpu')->first();
    echo $actualGpu->name . "\n";
}
