<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== RAM SEARCH DEBUG ===\n";
$ramBudget = 1800000;
$minPrice = $ramBudget * 0.85; // 1,530,000
$maxPrice = $ramBudget * 1.15; // 2,070,000

echo "Budget: Rp " . number_format($ramBudget, 0, ',', '.') . "\n";
echo "Price Range: Rp " . number_format($minPrice, 0, ',', '.') . " - Rp " . number_format($maxPrice, 0, ',', '.') . "\n\n";

$ramCat = App\Models\Category::where('name', 'LIKE', '%Memory%')->first();
echo "Memory Category: {$ramCat->name} (ID: {$ramCat->id})\n\n";

$rams = App\Models\Product::where('category_id', $ramCat->id)->get();
echo "All RAM products:\n";
foreach($rams as $ram) {
    $inRange = ($ram->price >= $minPrice && $ram->price <= $maxPrice) ? '' : '';
    echo "- {$ram->name}: Rp " . number_format($ram->price, 0, ',', '.') . " $inRange\n";
}

echo "\n=== CASING SEARCH DEBUG ===\n";
$casingBudget = 450000;
$minPrice = $casingBudget * 0.85; // 382,500
$maxPrice = $casingBudget * 1.15; // 517,500

echo "Budget: Rp " . number_format($casingBudget, 0, ',', '.') . "\n";
echo "Price Range: Rp " . number_format($minPrice, 0, ',', '.') . " - Rp " . number_format($maxPrice, 0, ',', '.') . "\n\n";

$casingCat = App\Models\Category::where('name', 'LIKE', '%Casing%')->first();
echo "Casing Category: {$casingCat->name} (ID: {$casingCat->id})\n\n";

$casings = App\Models\Product::where('category_id', $casingCat->id)->get();
echo "All Casing products:\n";
foreach($casings as $casing) {
    $inRange = ($casing->price >= $minPrice && $casing->price <= $maxPrice) ? '' : '';
    echo "- {$casing->name}: Rp " . number_format($casing->price, 0, ',', '.') . " $inRange\n";
}
