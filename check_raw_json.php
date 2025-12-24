<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

$product = Product::first();

echo "=== Raw Data Check ===\n";
echo "Full raw JSON:\n";
$raw = $product->getAttributes()['specifications'];
echo $raw . "\n\n";

echo "Decoded manually:\n";
$decoded = json_decode($raw, true);
echo "Last error: " . json_last_error_msg() . "\n";
echo "Decoded type: " . gettype($decoded) . "\n";
echo "Count: " . count($decoded) . "\n";
if (is_array($decoded)) {
    echo "First 3 keys: " . implode(', ', array_slice(array_keys($decoded), 0, 3)) . "\n";
}
