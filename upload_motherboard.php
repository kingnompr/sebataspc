<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== UPLOAD MOTHERBOARD IMAGES ===\n\n";

$category = Category::where('slug', 'motherboard')
    ->orWhere('name', 'LIKE', '%Motherboard%')
    ->first();

if (!$category) {
    echo "❌ Motherboard category not found\n";
    exit;
}

$products = Product::where('category_id', $category->id)->get();
echo "Found {$products->count()} motherboard products\n\n";

// Mapping exact motherboard images
$motherboardImages = [
    'ASRock B450 Pro4' => 'images/products/ASRock-B450-Pro4-board.png',
    'ASRock B760 Steel Legend' => 'images/products/ASRock-B760-Steel-Legend-board.png',
    'ASUS PRIME B660M-A D4' => 'images/products/ASUS-PRIME-B660M-A-D4-board.png',
    'ASUS TUF Gaming B550-Plus' => 'images/products/ASUS-TUF-Gaming-B550-Plus-board.png',
    'ASUS TUF Gaming B560M-Plus' => 'images/products/ASUS-TUF-Gaming-B560M-Plus-board.png',
    'Gigabyte B450M DS3H' => 'images/products/Gigabyte-B450M-DS3H-board.png',
    'Gigabyte B760M Aorus Elite AX' => 'images/products/Gigabyte-B760M-Aorus-Elite-AX-board.png',
    'MSI B550M Pro-VDH' => 'images/products/MSI-B550M-Pro-VDH-board.png',
    'MSI B560M Pro-VDH' => 'images/products/MSI-B560M-Pro-VDH-board.jpg',
    'MSI MAG B650 Tomahawk WiFi' => 'images/products/MSI-MAG-B650-Tomahawk-WiFi-board.png',
    'MSI PRO B660M-A DDR4' => 'images/products/MSI-PRO-B660M-A-DDR4-board.png',
];

$updated = 0;

foreach ($products as $product) {
    $imageFound = false;
    
    foreach ($motherboardImages as $keyword => $imagePath) {
        if (stripos($product->name, $keyword) !== false || $product->name === $keyword) {
            $product->image = $imagePath;
            $product->save();
            
            echo "✅ {$product->name}\n";
            echo "   📷 {$imagePath}\n";
            
            $imageFound = true;
            $updated++;
            break;
        }
    }
    
    if (!$imageFound) {
        echo "⚠️  {$product->name} - No matching image\n";
    }
}

echo "\n=== SUMMARY ===\n";
echo "Updated: {$updated} / {$products->count()} motherboard products\n";
echo "✅ Done!\n";
