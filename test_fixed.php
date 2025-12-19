<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST SMART PC BUILDER (FIXED) ===\n\n";
echo "Scenario: Gaming | Budget: Rp 15,000,000 | Tier: Best Performance\n\n";

$allocation = [
    'processor' => 20,
    'gpu' => 40,
    'motherboard' => 10,
    'ram' => 12,
    'storage' => 10,
    'psu' => 5,
    'casing' => 3,
];

$budget = 15000000;
$tolerance = 0.15;

$componentMapping = [
    'processor' => 'Processor',
    'gpu' => 'Graphics Card',
    'motherboard' => 'Motherboard',
    'ram' => 'Memory',
    'storage' => 'Storage',
    'psu' => 'Power Supply',
    'casing' => 'Casing'
];

$totalPrice = 0;

foreach($allocation as $component => $percentage) {
    $allocatedBudget = ($budget * $percentage) / 100;
    $minPrice = $allocatedBudget * (1 - $tolerance);
    $maxPrice = $allocatedBudget * (1 + $tolerance);
    
    $product = App\Models\Product::whereHas('category', function($q) use ($componentMapping, $component) {
        $q->where('name', 'LIKE', '%' . $componentMapping[$component] . '%');
    })
    ->whereBetween('price', [$minPrice, $maxPrice])
    ->orderBy('rating', 'desc')
    ->first();
    
    echo str_pad(ucfirst($component) . ':', 15);
    echo "Budget: Rp " . number_format($allocatedBudget, 0, ',', '.') . " => ";
    
    if($product) {
        echo $product->name . " (Rp " . number_format($product->price, 0, ',', '.') . ") \n";
        $totalPrice += $product->price;
    } else {
        echo "NOT FOUND \n";
    }
}

echo "\n" . str_repeat('=', 60) . "\n";
echo "TOTAL BUILD PRICE: Rp " . number_format($totalPrice, 0, ',', '.') . "\n";
echo "BUDGET: Rp " . number_format($budget, 0, ',', '.') . "\n";
echo "DIFFERENCE: Rp " . number_format($budget - $totalPrice, 0, ',', '.') . "\n";
