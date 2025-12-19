<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Gap filling products
$productsToAdd = [
    // MOTHERBOARD: ~900k-1jt (untuk budget 10jt & 20jt PSU gap)
    [
        'category_slug' => 'motherboard',
        'name' => 'MSI H410M Pro',
        'slug' => 'msi-h410m-pro',
        'description' => 'Budget motherboard untuk build entry-level. Support Intel Gen 10 dengan fitur dasar yang cukup.',
        'price' => 950000,
        'stock' => 25,
        'rating' => 4.1,
        'specifications' => [
            'socket' => 'LGA1200',
            'chipset' => 'H410',
            'form_factor' => 'Micro ATX',
            'memory_type' => 'DDR4',
            'memory_slots' => '2x DIMM',
            'max_memory' => '64GB',
            'pcie_slots' => '1x PCIe 3.0 x16',
            'm2_slots' => '1x M.2',
            'sata_ports' => '4x SATA 6Gb/s',
            'use_case' => 'Office, Gaming',
            'tier' => 'Best Value'
        ]
    ],
    
    // PSU: ~450-550k (untuk budget 10jt)
    [
        'category_slug' => 'psu',
        'name' => 'FSP HV Pro 450W 80+ Bronze',
        'slug' => 'fsp-hvpro-450w-bronze',
        'description' => 'PSU budget reliable untuk build office dan gaming ringan. Proteksi lengkap dengan efisiensi 80+ Bronze.',
        'price' => 500000,
        'stock' => 30,
        'rating' => 4.2,
        'specifications' => [
            'wattage' => '450W',
            'efficiency' => '80+ Bronze',
            'modular' => 'Non-Modular',
            'fan_size' => '120mm',
            'pfc' => 'Active PFC',
            'protections' => 'OVP, UVP, OPP, SCP',
            'connector_24pin' => '1x 24-pin ATX',
            'connector_cpu' => '1x 4+4-pin EPS12V',
            'connector_pcie' => '1x 6+2-pin PCIe',
            'connector_sata' => '4x SATA',
            'recommended_for' => 'Office, Entry Gaming',
            'use_case' => 'Office, Gaming',
            'tier' => 'Best Value',
            'warranty' => '3 Years'
        ]
    ],
    
    // PSU: ~900k-1jt (untuk budget 20jt)
    [
        'category_slug' => 'psu',
        'name' => 'Thermaltake Smart BX1 RGB 550W Bronze',
        'slug' => 'thermaltake-smart-bx1-550w',
        'description' => 'PSU dengan RGB fan untuk aesthetic build. Reliable untuk gaming mid-range dengan efisiensi 80+ Bronze.',
        'price' => 950000,
        'stock' => 25,
        'rating' => 4.4,
        'specifications' => [
            'wattage' => '550W',
            'efficiency' => '80+ Bronze',
            'modular' => 'Non-Modular',
            'fan_size' => '120mm RGB',
            'pfc' => 'Active PFC',
            'protections' => 'OVP, UVP, OPP, SCP, OTP',
            'connector_24pin' => '1x 24-pin ATX',
            'connector_cpu' => '1x 4+4-pin EPS12V',
            'connector_pcie' => '2x 6+2-pin PCIe',
            'connector_sata' => '6x SATA',
            'rgb_lighting' => 'RGB Fan',
            'recommended_for' => 'Mid-Range Gaming',
            'use_case' => 'Gaming',
            'tier' => 'Best Performance',
            'warranty' => '5 Years'
        ]
    ],
    
    // RAM: ~1.6-1.9jt (untuk budget 15jt)
    [
        'category_slug' => 'ram',
        'name' => 'Corsair Vengeance RGB Pro 16GB (2x8GB) DDR4-3600',
        'slug' => 'corsair-vengeance-rgb-16gb-3600',
        'description' => 'RGB RAM premium untuk gaming build. Performance tinggi dengan DDR4-3600 speed dan RGB lighting.',
        'price' => 1650000,
        'stock' => 20,
        'rating' => 4.7,
        'specifications' => [
            'capacity' => '16GB (2x8GB)',
            'type' => 'DDR4',
            'speed' => '3600 MHz',
            'cas_latency' => 'CL18',
            'voltage' => '1.35V',
            'channels' => 'Dual Channel',
            'rgb' => 'Yes (RGB Pro)',
            'heat_spreader' => 'Aluminum',
            'use_case' => 'Gaming, Editing',
            'tier' => 'Best Performance'
        ]
    ],
    
    // CASING: ~400-500k (untuk budget 15jt)
    [
        'category_slug' => 'case',
        'name' => 'Paradox Gaming Vortex V1 mATX',
        'slug' => 'paradox-vortex-v1-matx',
        'description' => 'Budget gaming case dengan mesh front untuk airflow. Compact mATX dengan fitur gaming essentials.',
        'price' => 450000,
        'stock' => 30,
        'rating' => 4.3,
        'specifications' => [
            'form_factor' => 'Micro ATX, Mini ITX',
            'motherboard_support' => 'mATX, Mini-ITX',
            'panel_type' => 'Acrylic Side Panel',
            'front_panel' => 'Mesh Front',
            'airflow_type' => 'Mesh Front Airflow',
            'rgb_lighting' => 'No',
            'max_gpu_length' => '320mm',
            'max_cpu_cooler_height' => '160mm',
            'max_psu_length' => '180mm',
            'drive_bays_35' => '2x 3.5" HDD',
            'drive_bays_25' => '2x 2.5" SSD',
            'fan_support_front' => '2x 120mm',
            'fan_support_rear' => '1x 120mm (included)',
            'fan_included' => '1x 120mm Rear',
            'cable_management' => 'Basic',
            'io_ports' => 'USB 3.0, USB 2.0, Audio',
            'use_case' => 'Gaming',
            'tier' => 'Best Value',
            'dimensions' => '420 x 200 x 430mm'
        ]
    ],
    
    // MOTHERBOARD: ~500k (untuk budget 5jt)
    [
        'category_slug' => 'motherboard',
        'name' => 'ASRock H410M-HDV',
        'slug' => 'asrock-h410m-hdv',
        'description' => 'Ultra budget motherboard untuk build kantor. Basic features dengan reliability yang cukup.',
        'price' => 520000,
        'stock' => 30,
        'rating' => 3.9,
        'specifications' => [
            'socket' => 'LGA1200',
            'chipset' => 'H410',
            'form_factor' => 'Micro ATX',
            'memory_type' => 'DDR4',
            'memory_slots' => '2x DIMM',
            'max_memory' => '32GB',
            'pcie_slots' => '1x PCIe 3.0 x16',
            'm2_slots' => '1x M.2',
            'sata_ports' => '4x SATA 6Gb/s',
            'use_case' => 'Office',
            'tier' => 'Best Value'
        ]
    ],
    
    // RAM: ~600k (untuk budget 5jt)
    [
        'category_slug' => 'ram',
        'name' => 'Team Elite Plus 8GB DDR4-2666',
        'slug' => 'team-elite-plus-8gb-2666',
        'description' => 'Budget RAM untuk build office. Kapasitas cukup untuk daily use dan multitasking ringan.',
        'price' => 580000,
        'stock' => 40,
        'rating' => 4.0,
        'specifications' => [
            'capacity' => '8GB (1x8GB)',
            'type' => 'DDR4',
            'speed' => '2666 MHz',
            'cas_latency' => 'CL19',
            'voltage' => '1.2V',
            'channels' => 'Single Channel',
            'rgb' => 'No',
            'use_case' => 'Office',
            'tier' => 'Best Value'
        ]
    ],
    
    // PROCESSOR: ~1jt (untuk budget 5jt)
    [
        'category_slug' => 'cpu',
        'name' => 'Intel Pentium Gold G6400',
        'slug' => 'intel-pentium-g6400',
        'description' => 'Budget processor untuk build office. Dual-core dengan iGPU untuk daily computing tanpa discrete GPU.',
        'price' => 980000,
        'stock' => 25,
        'rating' => 4.0,
        'specifications' => [
            'cores' => '2',
            'threads' => '4',
            'base_clock' => '4.0 GHz',
            'socket' => 'LGA1200',
            'tdp' => '58W',
            'igpu' => 'Intel UHD Graphics 610',
            'cache' => '4MB',
            'use_case' => 'Office',
            'tier' => 'Best Value'
        ]
    ],
];

foreach($productsToAdd as $productData) {
    $categorySlug = $productData['category_slug'];
    unset($productData['category_slug']);
    
    $category = App\Models\Category::where('slug', $categorySlug)->first();
    if(!$category) {
        echo " Category not found: $categorySlug\n";
        continue;
    }
    
    $productData['category_id'] = $category->id;
    $productData['image'] = 'products/' . $productData['slug'] . '.jpg';
    
    App\Models\Product::updateOrCreate(
        ['slug' => $productData['slug']],
        $productData
    );
    
    echo " Added: {$productData['name']} (Rp " . number_format($productData['price'], 0, ',', '.') . ")\n";
}

echo "\nTotal products added: " . count($productsToAdd) . "\n";
