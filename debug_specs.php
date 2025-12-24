<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== Checking Product Specifications Data ===\n\n";

$products = Product::take(5)->get();

if ($products->isEmpty()) {
    echo "❌ No products found in database\n";
    exit;
}

foreach ($products as $product) {
    echo "Product: {$product->name}\n";
    echo "ID: {$product->id}\n";
    
    // Check raw attribute
    $rawSpecs = $product->getAttributes()['specifications'] ?? null;
    echo "Raw specifications (from DB): ";
    if ($rawSpecs === null) {
        echo "NULL\n";
    } elseif (is_string($rawSpecs)) {
        echo "STRING: " . substr($rawSpecs, 0, 100) . "...\n";
    } else {
        echo "TYPE: " . gettype($rawSpecs) . "\n";
    }
    
    // Check accessor result
    $accessorSpecs = $product->specifications;
    echo "Accessor result: ";
    echo "TYPE: " . gettype($accessorSpecs) . ", ";
    if (is_array($accessorSpecs)) {
        echo "COUNT: " . count($accessorSpecs);
        if (!empty($accessorSpecs)) {
            echo ", Keys: " . implode(', ', array_keys($accessorSpecs));
        }
    } else {
        echo "VALUE: " . $accessorSpecs;
    }
    echo "\n";
    
    echo "---\n\n";
}
