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
            'is_admin' => true,
            'password' => Hash::make('admin123'),
        ]);

        $customer = User::factory()->create([
            'name' => 'Jonathan Customer',
            'email' => 'customer@sebataspc.com',
            'role' => 'customer',
            'is_admin' => false,
            'password' => Hash::make('customer123'),
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

        // Call product seeders
        $this->call([
            CpuProductsSeeder::class,
            GpuProductsSeeder::class,
            MotherboardProductsSeeder::class,
            RamProductsSeeder::class,
            StorageProductsSeeder::class,
            PsuProductsSeeder::class,
            CasingProductsSeeder::class,
            CpuCoolerProductsSeeder::class,
        ]);

        // Get all products for PC builds and orders
        $products = Product::all()->keyBy('slug');

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
