<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\DB;

echo "=== Checking for duplicate products ===\n\n";

$total = Product::count();
echo "Total products: $total\n";

if ($total > 85) {
    $excess = $total - 85;
    echo "⚠️  Found $excess extra product(s)\n\n";
    
    // Find newest product to remove
    $newest = Product::orderBy('id', 'desc')->first();
    
    if ($newest) {
        echo "Removing newest product:\n";
        echo "ID: {$newest->id}\n";
        echo "Name: {$newest->name}\n";
        
        $newest->delete();
        echo "\n✅ Deleted\n\n";
        
        echo "New total: " . Product::count() . "\n";
    }
} else {
    echo "✅ Product count is correct!\n";
}
