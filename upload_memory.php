<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== UPLOAD MEMORY IMAGES ===\n\n";

// Try different possible slugs for memory category
$category = Category::where('slug', 'memory')
    ->orWhere('slug', 'ram')
    ->orWhere('name', 'LIKE', '%Memory%')
    ->orWhere('name', 'LIKE', '%RAM%')
    ->first();

if (!$category) {
    echo "❌ Memory category not found\n";
    echo "Available categories:\n";
    $cats = Category::all(['name', 'slug']);
    foreach ($cats as $cat) {
        echo "  - {$cat->name} (slug: {$cat->slug})\n";
    }
    exit;
}

$allMemory = Product::where('category_id', $category->id)->get();

echo "Found " . $allMemory->count() . " memory products\n\n";

// Update by brand/keyword
$brandImages = [
    'Corsair' => [
        'DDR5-6000' => 'images/products/corsair-6000-memory.jpg',
        'DDR5-5600' => 'images/products/corsair-5600-memory.jpg',
        'DDR4-3600' => 'images/products/corsair-3600-16gb-memory.jpg',
        'DDR4-3200' => 'images/products/corsair-3200-memory.jpg',
    ],
    'G.Skill' => [
        'DDR5' => 'images/products/g.skill-5600-memory.png',
        'DDR4-3600' => 'images/products/g.skill-3600-memory.png',
        'DDR4-3200' => 'images/products/g.skill-3200-memory.jpg',
    ],
    'Kingston' => [
        'DDR5' => 'images/products/kingston-5200-memory.jpg',
        'DDR4' => 'images/products/kingston-3200-memory.jpg',
    ],
    'Crucial' => [
        '' => 'images/products/crucial-3200-memory.jpg',
    ],
    'Team' => [
        'T-Force' => 'images/products/teamgroup-3200-memory.jpg',
        'Elite' => 'images/products/teamelite-2666-memory.jpg',
    ],
];

$updated = 0;

foreach ($allMemory as $product) {
    foreach ($brandImages as $brand => $patterns) {
        if (stripos($product->name, $brand) !== false) {
            foreach ($patterns as $pattern => $image) {
                if ($pattern === '' || stripos($product->name, $pattern) !== false) {
                    $product->image = $image;
                    $product->save();
                    echo "✅ {$product->name}\n   📷 $image\n";
                    $updated++;
                    break 2;
                }
            }
        }
    }
}

echo "\n=== SUMMARY ===\n";
echo "Updated: $updated / {$allMemory->count()} memory products\n";
echo "✅ Done!\n";
