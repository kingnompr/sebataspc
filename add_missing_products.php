<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== Adding Missing Products (16 more to reach 85) ===\n\n";

// Get categories
$cpuCategory = Category::where('slug', 'cpu')->first();
$gpuCategory = Category::where('slug', 'gpu')->first();
$ramCategory = Category::where('slug', 'ram')->first();
$storageCategory = Category::where('slug', 'storage')->first();
$casingCategory = Category::where('slug', 'case')->first();
$psuCategory = Category::where('slug', 'psu')->first();
$coolingCategory = Category::where('slug', 'cooling')->first();
$motherboardCategory = Category::where('slug', 'motherboard')->first();

// Products to add (based on unused images)
$newProducts = [
    // CPU yang belum ada
    [
        'name' => 'AMD Ryzen 5 7600X',
        'slug' => 'amd-ryzen-5-7600x',
        'description' => '6-core Zen 4 processor ideal for high-refresh gaming',
        'price' => 3499000,
        'stock' => 15,
        'category_id' => $cpuCategory->id,
        'image' => 'images/products/AMD Ryzen 5 7600X-prosesor.jpg',
        'rating' => 4.8,
    ],
    [
        'name' => 'Intel Core i5-13600K',
        'slug' => 'intel-core-i5-13600k',
        'description' => '14-core hybrid CPU balancing creator and gamer workloads',
        'price' => 4799000,
        'stock' => 18,
        'category_id' => $cpuCategory->id,
        'image' => 'images/products/Intel Core i5-13600K-prosesor.jpg',
        'rating' => 4.9,
    ],
    
    // GPU yang mungkin belum ada
    [
        'name' => 'NVIDIA GeForce RTX 4060 8GB',
        'slug' => 'nvidia-rtx-4060-8gb',
        'description' => 'Efficient 1080p gaming GPU with DLSS 3',
        'price' => 5299000,
        'stock' => 20,
        'category_id' => $gpuCategory->id,
        'image' => 'images/products/rtx-4060-card.png',
        'rating' => 4.6,
    ],
    [
        'name' => 'NVIDIA GeForce RTX 4070 12GB',
        'slug' => 'nvidia-rtx-4070-12gb',
        'description' => '1440p powerhouse with DLSS 3 and ray tracing',
        'price' => 9999000,
        'stock' => 12,
        'category_id' => $gpuCategory->id,
        'image' => 'images/products/RTX4070-TWIN-EDGE-card.jpg',
        'rating' => 4.8,
    ],
    
    // Motherboards yang mungkin kurang
    [
        'name' => 'Gigabyte B760M Aorus Elite',
        'slug' => 'gigabyte-b760m-aorus',
        'description' => 'LGA1700 mATX board with PCIe 4.0',
        'price' => 2599000,
        'stock' => 15,
        'category_id' => $motherboardCategory->id,
        'image' => 'images/products/Gigabyte-B760M-Aorus-Elite-AX-board.png',
        'rating' => 4.5,
    ],
    [
        'name' => 'MSI MAG B650 Tomahawk',
        'slug' => 'msi-b650-tomahawk',
        'description' => 'Robust AM5 motherboard with PCIe 5.0',
        'price' => 4299000,
        'stock' => 14,
        'category_id' => $motherboardCategory->id,
        'image' => 'images/products/MSI-MAG-B650-Tomahawk-WiFi-board.png',
        'rating' => 4.7,
    ],
    
    // RAM tambahan
    [
        'name' => 'Corsair Vengeance RGB 16GB DDR4-3600',
        'slug' => 'corsair-rgb-16gb-3600',
        'description' => 'RGB RAM kit for gaming builds',
        'price' => 1299000,
        'stock' => 25,
        'category_id' => $ramCategory->id,
        'image' => 'images/products/corsair-3600-16gb-memory.jpg',
        'rating' => 4.6,
    ],
    [
        'name' => 'Corsair Dominator DDR5-6000 32GB',
        'slug' => 'corsair-dominator-6000',
        'description' => 'Premium DDR5 memory for enthusiasts',
        'price' => 3299000,
        'stock' => 10,
        'category_id' => $ramCategory->id,
        'image' => 'images/products/corsair-6000-memory.jpg',
        'rating' => 4.9,
    ],
    [
        'name' => 'G.Skill Trident Z5 DDR5-5600 32GB',
        'slug' => 'gskill-trident-5600',
        'description' => 'High-performance DDR5 kit',
        'price' => 2799000,
        'stock' => 18,
        'category_id' => $ramCategory->id,
        'image' => 'images/products/g.skill-5600-memory.png',
        'rating' => 4.7,
    ],
    [
        'name' => 'Team Elite DDR4-2666 8GB',
        'slug' => 'team-elite-2666',
        'description' => 'Budget RAM for office PCs',
        'price' => 399000,
        'stock' => 40,
        'category_id' => $ramCategory->id,
        'image' => 'images/products/teamelite-2666-memory.jpg',
        'rating' => 4.2,
    ],
    
    // Storage tambahan
    [
        'name' => 'Kingston NV2 1TB M.2 NVMe',
        'slug' => 'kingston-nv2-1tb-nvme',
        'description' => 'Affordable PCIe 4.0 NVMe SSD',
        'price' => 999000,
        'stock' => 30,
        'category_id' => $storageCategory->id,
        'image' => 'images/products/Kingston NV2 1TB NVMe-storage.jpg',
        'rating' => 4.5,
    ],
    
    // PSU tambahan
    [
        'name' => 'Cooler Master MWE Gold 650W V2',
        'slug' => 'cm-mwe-gold-650-v2',
        'description' => '80+ Gold certified 650W power supply',
        'price' => 1299000,
        'stock' => 20,
        'category_id' => $psuCategory->id,
        'image' => 'images/products/Cooler-Master-MWE-Gold-650-psu.jpg',
        'rating' => 4.6,
    ],
    [
        'name' => 'Corsair RM750x 750W 80+ Gold',
        'slug' => 'corsair-rm750x-gold',
        'description' => 'Fully modular 750W PSU',
        'price' => 1899000,
        'stock' => 15,
        'category_id' => $psuCategory->id,
        'image' => 'images/products/Corsair-RM750x-80Plus-Gold-psu.jpg',
        'rating' => 4.8,
    ],
    
    // Casing tambahan
    [
        'name' => 'NZXT H7 Flow RGB',
        'slug' => 'nzxt-h7-flow-rgb',
        'description' => 'Premium mid-tower with excellent airflow',
        'price' => 2299000,
        'stock' => 12,
        'category_id' => $casingCategory->id,
        'image' => 'images/products/nzxt-h7-flow.jpg',
        'rating' => 4.7,
    ],
    [
        'name' => 'Lian Li Lancool II Mesh RGB',
        'slug' => 'lianli-lancool-ii',
        'description' => 'High-airflow mesh case with RGB',
        'price' => 1799000,
        'stock' => 15,
        'category_id' => $casingCategory->id,
        'image' => 'images/products/lianli-lancool.jpg',
        'rating' => 4.8,
    ],
    
    // CPU Coolers tambahan
    [
        'name' => 'DeepCool LS520 WH 240mm AIO',
        'slug' => 'deepcool-ls520-wh',
        'description' => 'White ARGB liquid cooler',
        'price' => 1499000,
        'stock' => 18,
        'category_id' => $coolingCategory->id,
        'image' => 'images/products/deepcool-ls520.jpg',
        'rating' => 4.6,
    ],
    [
        'name' => 'Noctua NH-D15 Chromax Black',
        'slug' => 'noctua-nhd15-black',
        'description' => 'Premium dual-tower air cooler',
        'price' => 1899000,
        'stock' => 10,
        'category_id' => $coolingCategory->id,
        'image' => 'images/products/noctua-nh.jpg',
        'rating' => 4.9,
    ],
];

$added = 0;

foreach ($newProducts as $product) {
    // Check if product already exists
    $exists = Product::where('slug', $product['slug'])->exists();
    
    if (!$exists) {
        $product['specifications'] = json_encode([]);
        Product::create($product);
        echo "✅ Added: {$product['name']}\n";
        $added++;
    } else {
        echo "⏭️  Skipped (exists): {$product['name']}\n";
    }
}

echo "\n=== Summary ===\n";
echo "✅ Added: $added new products\n";
echo "📊 Total products now: " . Product::count() . "\n";

echo "\nDone!\n";
