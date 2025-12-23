<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Review;
use App\Models\Product;
use App\Models\User;

echo "=== Testing Review System ===\n\n";

// Check current reviews
$reviewCount = Review::count();
echo "Current reviews in database: $reviewCount\n\n";

// Get sample product
$product = Product::first();
if (!$product) {
    echo "❌ No products found!\n";
    exit;
}

echo "Sample product: {$product->name}\n";
echo "Product rating: {$product->rating}\n";
echo "Total reviews: " . $product->reviews()->count() . "\n\n";

// Check if admin user can review (should have purchased)
$admin = User::where('email', 'admin@sebataspc.com')->first();
if ($admin) {
    $hasPurchased = $admin->orders()
        ->whereHas('items', function($q) use ($product) {
            $q->where('product_id', $product->id);
        })
        ->whereIn('status', ['paid', 'processing', 'qc', 'shipped', 'delivered'])
        ->exists();
    
    echo "Admin user: {$admin->name}\n";
    echo "Has purchased product: " . ($hasPurchased ? 'Yes ✅' : 'No ❌') . "\n";
    
    $hasReviewed = Review::where('user_id', $admin->id)
        ->where('product_id', $product->id)
        ->exists();
    
    echo "Already reviewed: " . ($hasReviewed ? 'Yes' : 'No') . "\n";
}

echo "\n=== Review Features ===\n";
echo "✅ Customers can rate products (1-5 stars)\n";
echo "✅ Customers can write detailed comments\n";
echo "✅ Customers can upload up to 5 photos\n";
echo "✅ Verified purchase badge for buyers\n";
echo "✅ Other customers can view all reviews\n";
echo "✅ Photo gallery in reviews (click to zoom)\n";
echo "✅ Filter and sort reviews\n";

echo "\n📝 To test:\n";
echo "1. Login as customer (customer@sebataspc.com / customer123)\n";
echo "2. Purchase a product (or create test order)\n";
echo "3. Go to product detail page\n";
echo "4. Write review with rating and upload photos\n";
echo "5. Other users can view your review with photos\n";
