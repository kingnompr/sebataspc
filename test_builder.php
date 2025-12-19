<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST SMART PC BUILDER ===\n\n";
echo "Scenario: Gaming | Budget: Rp 15,000,000 | Tier: Best Performance\n\n";

// Budget allocation untuk Gaming Best Performance
$allocation = [
    'processor' => 20,  // Rp 3jt
    'gpu' => 40,        // Rp 6jt
    'motherboard' => 10, // Rp 1.5jt
    'ram' => 12,        // Rp 1.8jt
    'storage' => 10,    // Rp 1.5jt
    'psu' => 5,         // Rp 750k
    'casing' => 3,      // Rp 450k
];

$budget = 15000000;
$tolerance = 0.15;

foreach($allocation as $component => $percentage) {
    $allocatedBudget = ($budget * $percentage) / 100;
    $minPrice = $allocatedBudget * (1 - $tolerance);
    $maxPrice = $allocatedBudget * (1 + $tolerance);
    
    $categoryMap = [
        'processor' => 'Processor',
        'gpu' => 'VGA',
        'motherboard' => 'Motherboard',
        'ram' => 'RAM',
        'storage' => 'Storage',
        'psu' => 'PSU',
        'casing' => 'Casing'
    ];
    
    $product = App\Models\Product::whereHas('category', function($q) use ($categoryMap, $component) {
        $q->where('name', 'LIKE', '%' . $categoryMap[$component] . '%');
    })
    ->whereBetween('price', [$minPrice, $maxPrice])
    ->orderBy('rating', 'desc')
    ->first();
    
    echo str_pad(ucfirst($component) . ':', 15);
    echo "Budget: Rp " . number_format($allocatedBudget, 0, ',', '.') . " ";
    echo "(Rp " . number_format($minPrice, 0, ',', '.') . " - Rp " . number_format($maxPrice, 0, ',', '.') . ")";
    echo " => ";
    
    if($product) {
        echo $product->name . " (Rp " . number_format($product->price, 0, ',', '.') . ")\n";
    } else {
        echo "NOT FOUND\n";
    }
}
