<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PcBuild;
use App\Models\PcBuildComponent;
use App\Models\Product;
use App\Models\SavedPcBuild;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@sebataspc.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $customer = User::factory()->create([
            'name' => 'Jonathan Customer',
            'email' => 'customer@sebataspc.com',
            'role' => 'customer',
            'password' => Hash::make('password'),
        ]);

        $categoriesData = [
            ['name' => 'Processor', 'slug' => 'cpu', 'description' => 'CPU and APU selections for every workload.', 'icon' => 'cpu'],
            ['name' => 'Graphics Card', 'slug' => 'gpu', 'description' => 'Latest NVIDIA and AMD GPUs.', 'icon' => 'gpu'],
            ['name' => 'Motherboard', 'slug' => 'motherboard', 'description' => 'Feature-rich ATX, mATX, and ITX boards.', 'icon' => 'motherboard'],
            ['name' => 'Memory', 'slug' => 'ram', 'description' => 'DDR4 and DDR5 high-performance kits.', 'icon' => 'ram'],
            ['name' => 'Storage', 'slug' => 'storage', 'description' => 'NVMe SSD and SATA storage solutions.', 'icon' => 'storage'],
            ['name' => 'Power Supply', 'slug' => 'psu', 'description' => 'Efficient PSUs with modular cabling.', 'icon' => 'psu'],
            ['name' => 'Casing', 'slug' => 'case', 'description' => 'Airflow-optimized mid and full towers.', 'icon' => 'case'],
            ['name' => 'Cooling', 'slug' => 'cooling', 'description' => 'AIO and air coolers for silent rigs.', 'icon' => 'cooling'],
        ];

        $categories = [];
        foreach ($categoriesData as $category) {
            $categories[$category['slug']] = Category::create($category);
        }

        $productsData = [
            [
                'category' => 'cpu',
                'name' => 'AMD Ryzen 5 7600X',
                'slug' => 'amd-ryzen-5-7600x',
                'description' => '6-core Zen 4 processor ideal for high-refresh gaming and streaming.',
                'specifications' => [
                    'cores' => '6C/12T',
                    'base_clock' => '4.7 GHz',
                    'boost_clock' => '5.3 GHz',
                    'socket' => 'AM5',
                ],
                'price' => 3499000.00,
                'stock' => 25,
                'image' => '/images/products/ryzen-5-7600x.png',
                'is_featured' => true,
                'is_recommended' => true,
                'rating' => 4.8,
            ],
            [
                'category' => 'cpu',
                'name' => 'Intel Core i5-13600K',
                'slug' => 'intel-core-i5-13600k',
                'description' => '14-core hybrid CPU that balances creator and gamer workloads.',
                'specifications' => [
                    'cores' => '14C/20T',
                    'base_clock' => '3.5 GHz',
                    'boost_clock' => '5.1 GHz',
                    'socket' => 'LGA1700',
                ],
                'price' => 4799000.00,
                'stock' => 18,
                'image' => '/images/products/intel-i5-13600k.png',
                'is_featured' => true,
                'is_recommended' => true,
                'rating' => 4.9,
            ],
            [
                'category' => 'gpu',
                'name' => 'NVIDIA GeForce RTX 4070 Twin Edge',
                'slug' => 'nvidia-rtx-4070',
                'description' => '1440p powerhouse GPU with DLSS 3 and AV1 encoding.',
                'specifications' => [
                    'vram' => '12 GB GDDR6X',
                    'boost_clock' => '2475 MHz',
                    'power_draw' => '200 W',
                ],
                'price' => 11599000.00,
                'stock' => 12,
                'image' => '/images/products/rtx-4070.png',
                'is_featured' => true,
                'is_recommended' => true,
                'rating' => 4.7,
            ],
            [
                'category' => 'gpu',
                'name' => 'MSI GeForce RTX 4060 Ventus 2X',
                'slug' => 'msi-rtx-4060-ventus',
                'description' => 'Efficient 1080p performer with DLSS frame generation.',
                'specifications' => [
                    'vram' => '8 GB GDDR6',
                    'boost_clock' => '2460 MHz',
                    'power_draw' => '115 W',
                ],
                'price' => 6899000.00,
                'stock' => 20,
                'image' => '/images/products/rtx-4060.png',
                'is_featured' => false,
                'is_recommended' => true,
                'rating' => 4.6,
            ],
            [
                'category' => 'motherboard',
                'name' => 'MSI MAG B650 Tomahawk WiFi',
                'slug' => 'msi-mag-b650-tomahawk',
                'description' => 'Robust AM5 motherboard with PCIe 5.0 storage and Wi-Fi 6E.',
                'specifications' => [
                    'form_factor' => 'ATX',
                    'chipset' => 'AMD B650',
                    'memory' => 'DDR5 6400+',
                ],
                'price' => 4299000.00,
                'stock' => 14,
                'image' => '/images/products/msi-b650-tomahawk.png',
                'is_featured' => true,
                'is_recommended' => true,
                'rating' => 4.5,
            ],
            [
                'category' => 'motherboard',
                'name' => 'Gigabyte B760M Aorus Elite AX',
                'slug' => 'gigabyte-b760m-aorus-elite',
                'description' => 'LGA1700 micro-ATX board with PCIe 4.0 and Wi-Fi 6.',
                'specifications' => [
                    'form_factor' => 'mATX',
                    'chipset' => 'Intel B760',
                    'memory' => 'DDR5 6400',
                ],
                'price' => 3199000.00,
                'stock' => 16,
                'image' => '/images/products/gigabyte-b760m.png',
                'is_featured' => false,
                    'is_recommended' => true,
                'rating' => 4.4,
            ],
            [
                'category' => 'ram',
                'name' => 'Corsair Vengeance 32GB DDR5-6000',
                'slug' => 'corsair-vengeance-32gb-ddr5',
                'description' => 'Dual-channel DDR5 memory tuned for Ryzen EXPO/XMP.',
                'specifications' => [
                    'capacity' => '32 GB (2x16 GB)',
                    'speed' => '6000 MT/s',
                    'timing' => 'CL36',
                ],
                'price' => 2299000.00,
                'stock' => 30,
                'image' => '/images/products/corsair-vengeance-ddr5.png',
                'is_featured' => true,
                'is_recommended' => true,
                'rating' => 4.9,
            ],
            [
                'category' => 'ram',
                'name' => 'G.Skill Ripjaws S5 16GB DDR5-5600',
                'slug' => 'gskill-ripjaws-16gb-ddr5',
                'description' => 'Slim low-profile kit optimized for compact builds.',
                'specifications' => [
                    'capacity' => '16 GB (2x8 GB)',
                    'speed' => '5600 MT/s',
                    'timing' => 'CL36',
                ],
                'price' => 1499000.00,
                'stock' => 35,
                'image' => '/images/products/gskill-ripjaws-s5.png',
                'is_featured' => false,
                'is_recommended' => true,
                'rating' => 4.5,
            ],
            [
                'category' => 'storage',
                'name' => 'Samsung 980 Pro 1TB NVMe',
                'slug' => 'samsung-980-pro-1tb',
                'description' => 'PCIe 4.0 NVMe SSD with 7 GB/s read speed.',
                'specifications' => [
                    'capacity' => '1 TB',
                    'interface' => 'PCIe 4.0 x4',
                    'endurance' => '600 TBW',
                ],
                'price' => 2299000.00,
                'stock' => 28,
                'image' => '/images/products/samsung-980-pro.png',
                'is_featured' => true,
                'is_recommended' => true,
                'rating' => 4.8,
            ],
            [
                'category' => 'storage',
                'name' => 'Kingston NV2 1TB NVMe',
                'slug' => 'kingston-nv2-1tb',
                'description' => 'Budget-friendly PCIe 4.0 SSD for responsive systems.',
                'specifications' => [
                    'capacity' => '1 TB',
                    'interface' => 'PCIe 4.0 x4',
                    'sequential_read' => '3500 MB/s',
                ],
                'price' => 1299000.00,
                'stock' => 40,
                'image' => '/images/products/kingston-nv2.png',
                'is_featured' => false,
                'is_recommended' => true,
                'rating' => 4.4,
            ],
            [
                'category' => 'psu',
                'name' => 'Corsair RM750x 80+ Gold',
                'slug' => 'corsair-rm750x',
                'description' => 'Fully modular 750W PSU with silent fan profile.',
                'specifications' => [
                    'wattage' => '750 W',
                    'efficiency' => '80+ Gold',
                    'modularity' => 'Fully modular',
                ],
                'price' => 2199000.00,
                'stock' => 22,
                'image' => '/images/products/corsair-rm750x.png',
                'is_featured' => true,
                'is_recommended' => true,
                'rating' => 4.7,
            ],
            [
                'category' => 'psu',
                'name' => 'Cooler Master MWE Gold 650',
                'slug' => 'cooler-master-mwe-650',
                'description' => 'Reliable 650W PSU with quiet 120mm fan.',
                'specifications' => [
                    'wattage' => '650 W',
                    'efficiency' => '80+ Gold',
                    'modularity' => 'Semi-modular',
                ],
                'price' => 1499000.00,
                'stock' => 26,
                'image' => '/images/products/cm-mwe-650.png',
                'is_featured' => false,
                'is_recommended' => true,
                'rating' => 4.5,
            ],
            [
                'category' => 'case',
                'name' => 'NZXT H7 Flow',
                'slug' => 'nzxt-h7-flow',
                'description' => 'Premium mid-tower chassis with superior airflow.',
                'specifications' => [
                    'form_factor' => 'Mid Tower',
                    'front_io' => 'USB-C + USB-A',
                    'cooling_support' => '360mm AIO front/top',
                ],
                'price' => 2299000.00,
                'stock' => 15,
                'image' => '/images/products/nzxt-h7-flow.png',
                'is_featured' => true,
                'is_recommended' => true,
                'rating' => 4.6,
            ],
            [
                'category' => 'case',
                'name' => 'Lian Li Lancool 205 Mesh',
                'slug' => 'lian-li-lancool-205',
                'description' => 'Minimalist chassis with mesh intake and tempered glass.',
                'specifications' => [
                    'form_factor' => 'Mid Tower',
                    'fans_included' => '2x 140mm',
                    'gpu_clearance' => '384 mm',
                ],
                'price' => 1499000.00,
                'stock' => 18,
                'image' => '/images/products/lancool-205.png',
                'is_featured' => false,
                'is_recommended' => true,
                'rating' => 4.4,
            ],
            [
                'category' => 'cooling',
                'name' => 'DeepCool LS520 240mm AIO',
                'slug' => 'deepcool-ls520',
                'description' => 'ARGB liquid cooler with high-performance FK120 fans.',
                'specifications' => [
                    'radiator' => '240 mm',
                    'fans' => '2x FK120',
                    'socket_support' => 'Intel & AMD',
                ],
                'price' => 1999000.00,
                'stock' => 24,
                'image' => '/images/products/deepcool-ls520.png',
                'is_featured' => true,
                'is_recommended' => true,
                'rating' => 4.5,
            ],
        ];

        $products = [];
        foreach ($productsData as $product) {
            $product['category_id'] = $categories[$product['category']]->id;
            unset($product['category']);

            $products[$product['slug']] = Product::create($product);
        }

        $pcBuilds = [
            [
                'name' => 'Balanced Gaming 1440p',
                'budget_min' => 15000000.00,
                'budget_max' => 22000000.00,
                'performance_tier' => 'Mid-High',
                'use_case' => 'Gaming',
                'description' => 'Optimized for 1440p esports and AAA titles with future-ready platform.',
                'components' => [
                    ['type' => 'CPU', 'product' => 'amd-ryzen-5-7600x'],
                    ['type' => 'GPU', 'product' => 'nvidia-rtx-4070'],
                    ['type' => 'Motherboard', 'product' => 'msi-mag-b650-tomahawk'],
                    ['type' => 'Memory', 'product' => 'corsair-vengeance-32gb-ddr5'],
                    ['type' => 'Storage', 'product' => 'samsung-980-pro-1tb'],
                    ['type' => 'PSU', 'product' => 'corsair-rm750x'],
                    ['type' => 'Case', 'product' => 'nzxt-h7-flow'],
                    ['type' => 'Cooling', 'product' => 'deepcool-ls520'],
                ],
            ],
            [
                'name' => 'Creator & Streamer Pro',
                'budget_min' => 22000000.00,
                'budget_max' => 32000000.00,
                'performance_tier' => 'High',
                'use_case' => 'Editing',
                'description' => 'Workstation-grade configuration for 4K editing, rendering, and live streaming.',
                'components' => [
                    ['type' => 'CPU', 'product' => 'intel-core-i5-13600k'],
                    ['type' => 'GPU', 'product' => 'nvidia-rtx-4070'],
                    ['type' => 'Motherboard', 'product' => 'gigabyte-b760m-aorus-elite'],
                    ['type' => 'Memory', 'product' => 'corsair-vengeance-32gb-ddr5'],
                    ['type' => 'Storage', 'product' => 'samsung-980-pro-1tb', 'quantity' => 2],
                    ['type' => 'PSU', 'product' => 'corsair-rm750x'],
                    ['type' => 'Case', 'product' => 'nzxt-h7-flow'],
                    ['type' => 'Cooling', 'product' => 'deepcool-ls520'],
                ],
            ],
            [
                'name' => 'Starter Esports Build',
                'budget_min' => 9000000.00,
                'budget_max' => 14000000.00,
                'performance_tier' => 'Mid',
                'use_case' => 'Gaming',
                'description' => 'Value-focused PC for competitive 1080p gaming and school projects.',
                'components' => [
                    ['type' => 'CPU', 'product' => 'intel-core-i5-13600k'],
                    ['type' => 'GPU', 'product' => 'msi-rtx-4060-ventus'],
                    ['type' => 'Motherboard', 'product' => 'gigabyte-b760m-aorus-elite'],
                    ['type' => 'Memory', 'product' => 'gskill-ripjaws-16gb-ddr5'],
                    ['type' => 'Storage', 'product' => 'kingston-nv2-1tb'],
                    ['type' => 'PSU', 'product' => 'cooler-master-mwe-650'],
                    ['type' => 'Case', 'product' => 'lian-li-lancool-205'],
                ],
            ],
        ];

        $buildRegistry = [];

        foreach ($pcBuilds as $buildData) {
            $components = $buildData['components'];
            unset($buildData['components']);

            /** @var PcBuild $build */
            $build = PcBuild::create($buildData);
            $buildRegistry[$build->name] = $build;

            foreach ($components as $component) {
                $product = $products[$component['product']] ?? null;

                if (! $product) {
                    continue;
                }

                PcBuildComponent::create([
                    'pc_build_id' => $build->id,
                    'component_type' => $component['type'],
                    'product_id' => $product->id,
                    'quantity' => $component['quantity'] ?? 1,
                ]);
            }
        }

        Address::create([
            'user_id' => $customer->id,
            'label' => 'Rumah',
            'recipient' => 'Jonathan Customer',
            'phone' => '0812-9999-1111',
            'line_one' => 'Jl. HR Rasuna Said Kav. 62',
            'line_two' => 'Kuningan, Setiabudi',
            'city' => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'postal_code' => '12920',
            'is_default' => true,
        ]);

        Address::create([
            'user_id' => $customer->id,
            'label' => 'Kantor',
            'recipient' => 'Jonathan Customer',
            'phone' => '0812-9999-1111',
            'line_one' => 'Jl. Jendral Sudirman No. 45',
            'line_two' => 'Menara Astra Lt. 18',
            'city' => 'Jakarta Pusat',
            'province' => 'DKI Jakarta',
            'postal_code' => '10220',
            'is_default' => false,
        ]);

        $ordersData = [
            [
                'order_number' => 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(4)),
                'status' => 'processing',
                'progress_stage' => 3,
                'subtotal' => 24_500_000,
                'shipping_fee' => 150_000,
                'discount' => 500_000,
                'total' => 24_150_000,
                'courier' => 'JNE YES',
                'estimated_delivery_at' => now()->addDays(3),
                'items' => [
                    ['product' => 'nvidia-rtx-4070', 'quantity' => 1],
                    ['product' => 'amd-ryzen-5-7600x', 'quantity' => 1],
                    ['product' => 'corsair-vengeance-32gb-ddr5', 'quantity' => 1],
                ],
            ],
            [
                'order_number' => 'ORD-'.now()->subMonths(1)->format('Ymd').'-'.Str::upper(Str::random(4)),
                'status' => 'delivered',
                'progress_stage' => 4,
                'subtotal' => 8_900_000,
                'shipping_fee' => 80_000,
                'discount' => 0,
                'total' => 8_980_000,
                'courier' => 'SiCepat Gokil',
                'estimated_delivery_at' => now()->subDays(20),
                'items' => [
                    ['product' => 'msi-rtx-4060-ventus', 'quantity' => 1],
                    ['product' => 'kingston-nv2-1tb', 'quantity' => 1],
                ],
            ],
            [
                'order_number' => 'ORD-'.now()->subMonths(3)->format('Ymd').'-'.Str::upper(Str::random(4)),
                'status' => 'delivered',
                'progress_stage' => 4,
                'subtotal' => 4_250_000,
                'shipping_fee' => 60_000,
                'discount' => 150_000,
                'total' => 4_160_000,
                'courier' => 'JNE Reg',
                'estimated_delivery_at' => now()->subMonths(3)->addDays(5),
                'items' => [
                    ['product' => 'gskill-ripjaws-16gb-ddr5', 'quantity' => 1],
                    ['product' => 'cooler-master-mwe-650', 'quantity' => 1],
                ],
            ],
        ];

        foreach ($ordersData as $orderPayload) {
            $items = $orderPayload['items'];
            unset($orderPayload['items']);

            $order = Order::create(array_merge($orderPayload, [
                'user_id' => $customer->id,
            ]));

            foreach ($items as $itemData) {
                $product = $products[$itemData['product']] ?? null;

                if (! $product) {
                    continue;
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $itemData['quantity'],
                    'snapshot' => [
                        'category' => $product->category->name ?? null,
                        'specifications' => $product->specifications,
                    ],
                ]);
            }
        }

        $savedBuildSeed = [
            ['pc_build' => 'Balanced Gaming 1440p', 'custom_name' => 'Gaming Ultra 4K', 'progress_percent' => 82],
            ['pc_build' => 'Starter Esports Build', 'custom_name' => 'Office Budget v2', 'progress_percent' => 36],
        ];

        foreach ($savedBuildSeed as $saved) {
            $build = $buildRegistry[$saved['pc_build']] ?? null;

            if (! $build) {
                continue;
            }

            SavedPcBuild::create([
                'user_id' => $customer->id,
                'pc_build_id' => $build->id,
                'custom_name' => $saved['custom_name'],
                'progress_percent' => $saved['progress_percent'],
                'last_interacted_at' => now()->subDays(rand(1, 7)),
            ]);
        }
    }
}
