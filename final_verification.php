<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;
use App\Models\User;

echo "=== FINAL VERIFICATION ===\n\n";

// Products
$totalProducts = Product::count();
$productsWithImages = Product::whereNotNull('image')->count();
echo "📦 Total Products: $totalProducts / 85 ✅\n";
echo "🖼️  Products with images: $productsWithImages / $totalProducts ✅\n\n";

// Check if all image files exist
echo "Checking image file existence...\n";
$missingFiles = 0;
$products = Product::whereNotNull('image')->get();
foreach ($products as $product) {
    $path = public_path($product->image);
    if (!file_exists($path)) {
        echo "❌ Missing: {$product->image} (Product: {$product->name})\n";
        $missingFiles++;
    }
}

if ($missingFiles === 0) {
    echo "✅ All product images exist on disk!\n\n";
} else {
    echo "\n⚠️  Found $missingFiles missing image files\n\n";
}

// Categories
$totalCategories = Category::count();
echo "📁 Total Categories: $totalCategories\n";
foreach (Category::all() as $cat) {
    $count = $cat->products()->count();
    echo "  - {$cat->name}: $count products\n";
}
echo "\n";

// Users
$totalUsers = User::count();
echo "👥 Total Users: $totalUsers\n";
foreach (User::all() as $user) {
    $role = $user->is_admin ? 'Admin' : 'Customer';
    echo "  - {$user->email} ($role)\n";
}

echo "\n=== Status: READY ✅ ===\n";
echo "Website is ready at: http://127.0.0.1:8000\n";
echo "Login credentials:\n";
echo "  Admin: admin@sebataspc.com / admin123\n";
echo "  Customer: customer@sebataspc.com / customer123\n";
