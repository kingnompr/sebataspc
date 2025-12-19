<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

// Simulate request
$request = Illuminate\Http\Request::create(
    '/pc-builds/alternatives?component_type=processor&budget=3000000',
    'GET'
);

$response = $kernel->handle($request);

echo "=== TEST API ALTERNATIF PRODUK ===\n\n";
echo "Request: /pc-builds/alternatives?component_type=processor&budget=3000000\n\n";
echo "Response Status: {$response->getStatusCode()}\n\n";

$content = $response->getContent();
$data = json_decode($content, true);

if ($data) {
    echo "Component Type: {$data['component_type']}\n";
    echo "Category: {$data['category']}\n";
    echo "Budget: Rp " . number_format($data['budget'], 0, ',', '.') . "\n";
    echo "Total Products: " . count($data['products']) . "\n\n";
    
    echo "PRODUK ALTERNATIF:\n";
    echo str_repeat('-', 80) . "\n";
    
    foreach ($data['products'] as $i => $product) {
        echo ($i + 1) . ". {$product['name']}\n";
        echo "   Harga: Rp " . number_format($product['price'], 0, ',', '.') . "\n";
        echo "   Rating: " . ($product['rating'] ? $product['rating'] : 'N/A') . "\n";
        echo "   Image: " . ($product['image'] ?: 'No image') . "\n";
        echo "\n";
    }
} else {
    echo "ERROR: Invalid JSON response\n";
    echo $content . "\n";
}
