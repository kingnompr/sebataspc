<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\DB;

echo "=== Converting JSON Specifications to Arrays ===\n\n";

$products = Product::all();
$converted = 0;
$errors = 0;

foreach ($products as $product) {
    try {
        // Check if specifications is a JSON string
        if ($product->specifications && is_string($product->specifications)) {
            $decoded = json_decode($product->specifications, true);
            if ($decoded && is_array($decoded)) {
                // Update to array (Eloquent will auto-cast to JSON)
                $product->specifications = $decoded;
                $product->save();
                $converted++;
                echo "✓ Converted: {$product->name}\n";
            }
        } elseif ($product->specifications && is_array($product->specifications)) {
            // Already an array, but make sure it's saved properly
            $product->save();
            $converted++;
            echo "✓ Verified: {$product->name}\n";
        }
    } catch (Exception $e) {
        $errors++;
        echo "✗ Error with {$product->name}: " . $e->getMessage() . "\n";
    }
}

echo "\n=== Summary ===\n";
echo "Total products: " . $products->count() . "\n";
echo "Converted/Verified: $converted\n";
echo "Errors: $errors\n";
echo "\nDone!\n";
