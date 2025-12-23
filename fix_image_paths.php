<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;

echo "=== Fixing incorrect image paths ===\n\n";

$products = Product::whereNotNull('image')->get();
$fixed = 0;

foreach ($products as $product) {
    $path = $product->image;
    
    // If path doesn't start with "images/", fix it
    if ($path && !str_starts_with($path, 'images/')) {
        $newPath = 'images/' . $path;
        
        // Check if file exists with new path
        if (file_exists(public_path($newPath))) {
            echo "✅ Fixed: {$product->name}\n";
            echo "   Old: $path\n";
            echo "   New: $newPath\n\n";
            
            $product->update(['image' => $newPath]);
            $fixed++;
        }
    }
}

echo "=== Summary ===\n";
echo "Fixed: $fixed products\n";
