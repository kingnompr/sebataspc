<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== SMART PC BUILDER TEST: Rp 10JT GAMING ===\n\n";

$allocation = [
    'processor' => 20,  // Rp 2jt
    'gpu' => 40,        // Rp 4jt
    'motherboard' => 10, // Rp 1jt
    'ram' => 12,        // Rp 1.2jt
    'storage' => 10,    // Rp 1jt
    'psu' => 5,         // Rp 500k
    'casing' => 3,      // Rp 300k
];

$budget = 10000000;
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
echo "Budget: Rp " . number_format($budget, 0, ',', '.') . "\n";
echo "Use Case: Gaming | Tier: Best Performance\n\n";

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
    
    if($product) {
        echo "{$product->name} - Rp " . number_format($product->price, 0, ',', '.') . " \n";
        $totalPrice += $product->price;
    } else {
        echo "No product in range (Rp " . number_format($minPrice, 0, ',', '.') . " - " . number_format($maxPrice, 0, ',', '.') . ") \n";
    }
}

echo "\n" . str_repeat('=', 70) . "\n";
echo "TOTAL: Rp " . number_format($totalPrice, 0, ',', '.') . " / Rp " . number_format($budget, 0, ',', '.') . "\n";
echo "Remaining: Rp " . number_format($budget - $totalPrice, 0, ',', '.') . "\n";
