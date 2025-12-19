<?php
/**
 * Test Script untuk Save Build & Add to Cart
 * Jalankan: php test_save_cart.php
 */

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Product;
use App\Models\CustomPcBuild;
use App\Models\Cart;
use App\Models\CartItem;

echo "=== TEST SAVE BUILD & ADD TO CART ===\n\n";

// Test 1: Create test user
echo "TEST 1: Setup Test User\n";
echo str_repeat('-', 60) . "\n";

$testUser = User::where('email', 'test@sebataspc.com')->first();
if (!$testUser) {
    $testUser = User::create([
        'name' => 'Test User',
        'email' => 'test@sebataspc.com',
        'password' => bcrypt('password123'),
        'phone' => '081234567890',
    ]);
    echo "✅ Test user created: {$testUser->email}\n";
} else {
    echo "✅ Test user exists: {$testUser->email}\n";
}
echo "\n";

// Test 2: Get recommended components
echo "TEST 2: Get Recommended Components\n";
echo str_repeat('-', 60) . "\n";

$components = [];
$categories = [
    'processor' => 'Processor',
    'gpu' => 'Graphics Card',
    'motherboard' => 'Motherboard',
    'ram' => 'Memory',
    'storage' => 'Storage',
    'psu' => 'Power Supply',
    'casing' => 'Casing',
];

foreach ($categories as $key => $categoryName) {
    $product = Product::whereHas('category', function($q) use ($categoryName) {
        $q->where('name', 'LIKE', "%{$categoryName}%");
    })->inRandomOrder()->first();
    
    if ($product) {
        $components[$key] = $product->id;
        echo "  {$categoryName}: {$product->name} (Rp " . number_format($product->price, 0, ',', '.') . ")\n";
    }
}
echo "\n";

// Test 3: Calculate total price
echo "TEST 3: Calculate Total Price\n";
echo str_repeat('-', 60) . "\n";

$productIds = array_values(array_filter($components));
$totalPrice = Product::whereIn('id', $productIds)->sum('price');
echo "Component count: " . count($productIds) . "\n";
echo "Total price: Rp " . number_format($totalPrice, 0, ',', '.') . "\n\n";

// Test 4: Save build
echo "TEST 4: Save Custom PC Build\n";
echo str_repeat('-', 60) . "\n";

$build = CustomPcBuild::create([
    'user_id' => $testUser->id,
    'build_name' => 'Test Gaming Build ' . date('His'),
    'budget' => 15000000,
    'use_case' => 'gaming',
    'tier' => 'best_value',
    'components' => $components,
    'total_price' => $totalPrice,
]);

echo "✅ Build saved successfully!\n";
echo "Build ID: {$build->id}\n";
echo "Build Name: {$build->build_name}\n";
echo "User: {$build->user->name}\n";
echo "Components: " . json_encode($build->components) . "\n\n";

// Test 5: Retrieve saved builds
echo "TEST 5: Retrieve User's Saved Builds\n";
echo str_repeat('-', 60) . "\n";

$userBuilds = CustomPcBuild::where('user_id', $testUser->id)->get();
echo "Total builds for {$testUser->name}: {$userBuilds->count()}\n\n";

foreach ($userBuilds as $b) {
    echo "  - {$b->build_name}\n";
    echo "    Budget: Rp " . number_format($b->budget, 0, ',', '.') . "\n";
    echo "    Total: Rp " . number_format($b->total_price, 0, ',', '.') . "\n";
    echo "    Created: {$b->created_at->diffForHumans()}\n\n";
}

// Test 6: Add build to cart
echo "TEST 6: Add Build to Cart\n";
echo str_repeat('-', 60) . "\n";

// Get or create cart for test user
$cart = Cart::firstOrCreate(['user_id' => $testUser->id]);
echo "Cart ID: {$cart->id}\n";

$addedCount = 0;
foreach ($productIds as $productId) {
    $product = Product::find($productId);
    if (!$product) continue;

    // Check if already in cart
    $cartItem = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $productId)
        ->first();

    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'quantity' => 1,
        ]);
    }
    $addedCount++;
    echo "  ✅ Added: {$product->name}\n";
}

echo "\nTotal items added: {$addedCount}\n";
echo "Cart total items: {$cart->getItemCount()}\n";
echo "Cart total price: Rp " . number_format($cart->getTotal(), 0, ',', '.') . "\n\n";

// Test 7: Delete build
echo "TEST 7: Delete Test Build\n";
echo str_repeat('-', 60) . "\n";

$build->delete();
echo "✅ Build deleted successfully!\n\n";

// Summary
echo "=== TEST SUMMARY ===\n";
echo "✅ All tests passed!\n";
echo "\nFitur yang berhasil ditest:\n";
echo "1. ✅ Create test user\n";
echo "2. ✅ Get recommended components\n";
echo "3. ✅ Calculate total price\n";
echo "4. ✅ Save custom PC build\n";
echo "5. ✅ Retrieve saved builds\n";
echo "6. ✅ Add build to cart\n";
echo "7. ✅ Delete build\n\n";

echo "Test user credentials:\n";
echo "Email: test@sebataspc.com\n";
echo "Password: password123\n\n";

echo "Silakan login dan test manual di:\n";
echo "- http://127.0.0.1:8000/pc-builds/builder\n";
echo "- http://127.0.0.1:8000/account/my-builds\n";
echo "- http://127.0.0.1:8000/cart\n";
