<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== Updating Product Images with External URLs ===\n\n";

$products = Product::with('category')->get();
$updated = 0;
$counter = 1;

// Category to image URL mapping (using real high-quality placeholder service)
$categoryImages = [
    'cpu' => [
        'https://images.unsplash.com/photo-1591290621153-70d4f2a8d900?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1555092918-411bd432c66f?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=500&fit=crop',
    ],
    'gpu' => [
        'https://images.unsplash.com/photo-1587829191301-dc798b83add3?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1595502707802-27426f4a0cd2?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=500&h=500&fit=crop',
    ],
    'ram' => [
        'https://images.unsplash.com/photo-1596708323512-38e9b2e01d7a?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1619983081563-430f63602796?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=500&h=500&fit=crop',
    ],
    'storage' => [
        'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1550355291-bbee04a92027?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=500&h=500&fit=crop',
    ],
    'motherboard' => [
        'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1518770660439-4636190af475?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1595689137fbb-e2332d6c57b4?w=500&h=500&fit=crop',
    ],
    'psu' => [
        'https://images.unsplash.com/photo-1609034227505-5876f6aa4e90?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1573141375857-aec81e688ce0?w=500&h=500&fit=crop',
    ],
    'cooling' => [
        'https://images.unsplash.com/photo-1559163499-1b13586892e1?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1606755962773-d36714e00c12?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=500&h=500&fit=crop',
    ],
    'casing' => [
        'https://images.unsplash.com/photo-1614008375890-cb53b6c5f8d5?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1550355291-bbee04a92027?w=500&h=500&fit=crop',
        'https://images.unsplash.com/photo-1626252b90c4-87d5e7c88e5a?w=500&h=500&fit=crop',
    ],
];

// Default images for categories without specific mapping
$defaultImages = [
    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=500&fit=crop',
    'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=500&h=500&fit=crop',
    'https://images.unsplash.com/photo-1518770660439-4636190af475?w=500&h=500&fit=crop',
];

foreach ($products as $product) {
    $category = strtolower($product->category->slug ?? 'default');
    
    // Get images for this category or use defaults
    if (isset($categoryImages[$category])) {
        $images = $categoryImages[$category];
    } else {
        $images = $defaultImages;
    }
    
    // Rotate through images for variety
    $imageUrl = $images[($counter - 1) % count($images)];
    
    $product->image = $imageUrl;
    $product->save();
    $updated++;
    $counter++;
    
    echo "✓ Updated: {$product->name}\n";
    echo "  URL: $imageUrl\n";
}

echo "\n=== Summary ===\n";
echo "Total products updated: $updated\n";
echo "All images now use external URLs (Unsplash)\n";
echo "\nDone! Images should now display in your hosted version.\n";
