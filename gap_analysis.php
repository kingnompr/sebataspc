<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== PRICE GAP ANALYSIS ===\n\n";

$budgetScenarios = [
    ['budget' => 5000000, 'name' => 'Rp 5jt'],
    ['budget' => 10000000, 'name' => 'Rp 10jt'],
    ['budget' => 15000000, 'name' => 'Rp 15jt'],
    ['budget' => 20000000, 'name' => 'Rp 20jt'],
];

$allocation = [
    'processor' => 20,
    'gpu' => 40,
    'motherboard' => 10,
    'ram' => 12,
    'storage' => 10,
    'psu' => 5,
    'casing' => 3,
];

$componentMapping = [
    'processor' => 'Processor',
    'gpu' => 'Graphics Card',
    'motherboard' => 'Motherboard',
    'ram' => 'Memory',
    'storage' => 'Storage',
    'psu' => 'Power Supply',
    'casing' => 'Casing'
];

foreach($budgetScenarios as $scenario) {
    echo "Budget: {$scenario['name']}\n";
    echo str_repeat('-', 60) . "\n";
    
    foreach($allocation as $component => $percentage) {
        $allocatedBudget = ($scenario['budget'] * $percentage) / 100;
        $minPrice = $allocatedBudget * 0.85;
        $maxPrice = $allocatedBudget * 1.15;
        
        $product = App\Models\Product::whereHas('category', function($q) use ($componentMapping, $component) {
            $q->where('name', 'LIKE', '%' . $componentMapping[$component] . '%');
        })
        ->whereBetween('price', [$minPrice, $maxPrice])
        ->orderBy('rating', 'desc')
        ->first();
        
        if(!$product) {
            echo " {$component}: MISSING in range Rp " . number_format($minPrice, 0, ',', '.') . " - " . number_format($maxPrice, 0, ',', '.') . "\n";
        }
    }
    echo "\n";
}
