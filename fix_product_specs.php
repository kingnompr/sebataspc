<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== FIXING PRODUCT SPECIFICATIONS ===\n\n";

$products = Product::all();
$fixed = 0;

foreach ($products as $product) {
    $needsUpdate = false;
    $specs = [];
    
    // If specifications field has JSON string, parse it
    if ($product->specifications) {
        if (is_string($product->specifications)) {
            $decoded = json_decode($product->specifications, true);
            if ($decoded && is_array($decoded)) {
                $specs = $decoded;
                $needsUpdate = true;
            }
        } elseif (is_array($product->specifications)) {
            $specs = $product->specifications;
        }
    }
    
    // Add dedicated column data to specs
    $updates = [];
    if ($product->socket) {
        $specs['socket'] = $product->socket;
        $needsUpdate = true;
    }
    if ($product->chipset) {
        $specs['chipset'] = $product->chipset;
        $needsUpdate = true;
    }
    if ($product->memory_type) {
        $specs['memory_type'] = $product->memory_type;
        $needsUpdate = true;
    }
    if ($product->interface) {
        $specs['interface'] = $product->interface;
        $needsUpdate = true;
    }
    if ($product->capacity_gb) {
        $specs['capacity'] = $product->capacity_gb . ' GB';
        $needsUpdate = true;
    }
    if ($product->form_factor) {
        $specs['form_factor'] = $product->form_factor;
        $needsUpdate = true;
    }
    
    if ($needsUpdate && !empty($specs)) {
        $product->specifications = $specs;
        $product->save();
        $fixed++;
        echo "✓ Fixed: {$product->name}\n";
        echo "  Specs: " . json_encode($specs) . "\n\n";
    }
}

echo "\n=== SUMMARY ===\n";
echo "Total products: " . $products->count() . "\n";
echo "Fixed: $fixed\n";
echo "\nDone!\n";
