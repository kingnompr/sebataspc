<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FULL BUILD TEST - ALL BUDGET SCENARIOS ===\n\n";

$budgetScenarios = [
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
    echo "" . str_repeat('', 68) . "\n";
    echo " GAMING BUILD - {$scenario['name']} Budget (Best Performance Tier)" . str_repeat(' ', 68 - 55 - strlen($scenario['name'])) . "\n";
    echo "" . str_repeat('', 68) . "\n";
    
    $totalPrice = 0;
    $foundCount = 0;
    
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
        
        $label = str_pad(ucfirst($component), 12);
        
        if($product) {
            $price = str_pad('Rp ' . number_format($product->price, 0, ',', '.'), 15);
            echo "  {$label}  {$price}  " . substr($product->name, 0, 35) . str_repeat(' ', max(0, 35 - strlen(substr($product->name, 0, 35)))) . " \n";
            $totalPrice += $product->price;
            $foundCount++;
        } else {
            echo "  {$label}  " . str_repeat(' ', 15) . "  NOT FOUND" . str_repeat(' ', 24) . " \n";
        }
    }
    
    echo "" . str_repeat('', 68) . "\n";
    echo " TOTAL BUILD COST: Rp " . number_format($totalPrice, 0, ',', '.') . str_repeat(' ', 68 - 23 - strlen(number_format($totalPrice, 0, ',', '.'))) . "\n";
    echo " BUDGET REMAINING: Rp " . number_format($scenario['budget'] - $totalPrice, 0, ',', '.') . str_repeat(' ', 68 - 23 - strlen(number_format($scenario['budget'] - $totalPrice, 0, ',', '.'))) . "\n";
    echo " COMPONENTS FOUND: {$foundCount}/7" . str_repeat(' ', 55) . "\n";
    echo "" . str_repeat('', 68) . "\n\n";
}

echo "Total Products in Database: " . App\Models\Product::count() . "\n";
