<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class CasingProductsSeeder extends Seeder
{
    public function run(): void
    {
        $casingCategory = Category::where('slug', 'case')->first();
        
        if (!$casingCategory) {
            $this->command->error('❌ Casing category not found! Please run categories seeder first.');
            return;
        }

        $casings = [
            // 🟢 Budget / Office / Daily Use
            [
                'name' => 'Armageddon Casing MX5 mATX',
                'slug' => 'armageddon-mx5-matx',
                'description' => 'Casing simple dan rapi untuk build standar. Panel acrylic dengan cooling fan basic untuk office & daily use.',
                'price' => 300000,
                'stock' => 40,
                'category_id' => $casingCategory->id,
                'image' => 'products/casing-armageddon-mx5.jpg',
                'rating' => 4.2,
                'specifications' => [
                    'form_factor' => 'Micro ATX, Mini ITX',
                    'motherboard_support' => 'mATX, Mini-ITX',
                    'panel_type' => 'Acrylic Side Panel',
                    'front_panel' => 'Solid Front',
                    'airflow_type' => 'Basic',
                    'rgb_lighting' => 'No',
                    'max_gpu_length' => '310mm',
                    'max_cpu_cooler_height' => '155mm',
                    'max_psu_length' => '160mm',
                    'drive_bays_35' => '2x 3.5" HDD',
                    'drive_bays_25' => '2x 2.5" SSD',
                    'fan_support_front' => '2x 120mm (included)',
                    'fan_support_rear' => '1x 120mm',
                    'fan_included' => '2x 120mm Front',
                    'cable_management' => 'Basic',
                    'io_ports' => 'USB 3.0, USB 2.0, Audio',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                    'dimensions' => '410 x 200 x 415mm'
                ]
            ],
            [
                'name' => 'Vortex Casing VX5 ATX',
                'slug' => 'vortex-vx5-atx',
                'description' => 'Front mesh airflow untuk sirkulasi udara lebih baik. Cocok untuk build entry-level dengan budget terbatas.',
                'price' => 350000,
                'stock' => 35,
                'category_id' => $casingCategory->id,
                'image' => 'products/casing-vortex-vx5.jpg',
                'rating' => 4.3,
                'specifications' => [
                    'form_factor' => 'ATX, Micro ATX, Mini ITX',
                    'motherboard_support' => 'ATX, mATX, Mini-ITX',
                    'panel_type' => 'Acrylic Side Panel',
                    'front_panel' => 'Mesh Front Panel',
                    'airflow_type' => 'Mesh Front',
                    'rgb_lighting' => 'No',
                    'max_gpu_length' => '320mm',
                    'max_cpu_cooler_height' => '160mm',
                    'max_psu_length' => '180mm',
                    'drive_bays_35' => '2x 3.5" HDD',
                    'drive_bays_25' => '3x 2.5" SSD',
                    'fan_support_front' => '3x 120mm',
                    'fan_support_rear' => '1x 120mm',
                    'fan_included' => '1x 120mm Rear',
                    'cable_management' => 'Basic',
                    'io_ports' => 'USB 3.0, USB 2.0, Audio',
                    'use_case' => 'Office, Gaming',
                    'tier' => 'Best Value',
                    'dimensions' => '440 x 210 x 450mm'
                ]
            ],

            // 🔵 Gaming Entry / Mid – Good Airflow
            [
                'name' => 'Cube Gaming Hexa ATX Mesh',
                'slug' => 'cube-gaming-hexa-atx',
                'description' => 'Mesh front panel dengan fan ready untuk cooling lebih baik. Cocok untuk gaming entry hingga mid-range.',
                'price' => 550000,
                'stock' => 30,
                'category_id' => $casingCategory->id,
                'image' => 'products/casing-cube-hexa.jpg',
                'rating' => 4.5,
                'specifications' => [
                    'form_factor' => 'ATX, Micro ATX, Mini ITX',
                    'motherboard_support' => 'ATX, mATX, Mini-ITX',
                    'panel_type' => 'Tempered Glass Side Panel',
                    'front_panel' => 'Full Mesh Front',
                    'airflow_type' => 'High Airflow Mesh',
                    'rgb_lighting' => 'No',
                    'max_gpu_length' => '350mm',
                    'max_cpu_cooler_height' => '165mm',
                    'max_psu_length' => '200mm',
                    'drive_bays_35' => '2x 3.5" HDD',
                    'drive_bays_25' => '4x 2.5" SSD',
                    'fan_support_front' => '3x 120mm or 2x 140mm',
                    'fan_support_top' => '2x 120mm',
                    'fan_support_rear' => '1x 120mm (included)',
                    'fan_included' => '1x 120mm Rear',
                    'cable_management' => 'Good',
                    'io_ports' => 'USB 3.0 x2, USB 2.0, Audio',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                    'dimensions' => '460 x 210 x 450mm'
                ]
            ],
            [
                'name' => 'Tecware Forge M ARGB ATX',
                'slug' => 'tecware-forge-m-argb',
                'description' => 'ARGB lighting dengan mesh airflow untuk gaming build. Tempered glass showcase untuk tampilan menarik.',
                'price' => 750000,
                'stock' => 25,
                'category_id' => $casingCategory->id,
                'image' => 'products/casing-tecware-forge.jpg',
                'rating' => 4.6,
                'specifications' => [
                    'form_factor' => 'ATX, Micro ATX, Mini ITX',
                    'motherboard_support' => 'ATX, mATX, Mini-ITX',
                    'panel_type' => 'Tempered Glass Side Panel',
                    'front_panel' => 'Mesh with ARGB Strip',
                    'airflow_type' => 'Mesh Front Airflow',
                    'rgb_lighting' => 'ARGB Front Strip',
                    'max_gpu_length' => '360mm',
                    'max_cpu_cooler_height' => '165mm',
                    'max_psu_length' => '200mm',
                    'drive_bays_35' => '2x 3.5" HDD',
                    'drive_bays_25' => '4x 2.5" SSD',
                    'fan_support_front' => '3x 120mm (ARGB included)',
                    'fan_support_top' => '2x 120mm',
                    'fan_support_rear' => '1x 120mm (included)',
                    'fan_included' => '4x 120mm ARGB (3F + 1R)',
                    'cable_management' => 'Good',
                    'io_ports' => 'USB 3.0 x2, USB 2.0, Audio, ARGB Button',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                    'dimensions' => '465 x 210 x 455mm'
                ]
            ],

            // 🔷 Mid Range – ARGB & Premium Look
            [
                'name' => 'NZXT H510 ATX Tempered Glass',
                'slug' => 'nzxt-h510-atx',
                'description' => 'Premium design dengan tempered glass dan cable routing excellent. Clean aesthetic untuk gaming build.',
                'price' => 1400000,
                'stock' => 20,
                'category_id' => $casingCategory->id,
                'image' => 'products/casing-nzxt-h510.jpg',
                'rating' => 4.7,
                'specifications' => [
                    'form_factor' => 'ATX, Micro ATX, Mini ITX',
                    'motherboard_support' => 'ATX, mATX, Mini-ITX',
                    'panel_type' => 'Tempered Glass Side Panel',
                    'front_panel' => 'Clean Front with Internal Airflow',
                    'airflow_type' => 'Optimized Negative Pressure',
                    'rgb_lighting' => 'No (RGB Ready)',
                    'max_gpu_length' => '381mm',
                    'max_cpu_cooler_height' => '165mm',
                    'max_psu_length' => '220mm',
                    'drive_bays_35' => '2x 3.5" HDD (with removable cage)',
                    'drive_bays_25' => '3x 2.5" SSD',
                    'fan_support_front' => '2x 120mm or 2x 140mm',
                    'fan_support_top' => '1x 120mm or 1x 140mm',
                    'fan_support_rear' => '1x 120mm (included)',
                    'fan_included' => '2x 120mm (1F + 1R)',
                    'cable_management' => 'Excellent (Cable Bar)',
                    'io_ports' => 'USB 3.1 Gen 2 Type-C, USB 3.1 Gen 1, Audio',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                    'dimensions' => '435 x 210 x 460mm'
                ]
            ],
            [
                'name' => 'Cooler Master MasterBox MB510L',
                'slug' => 'coolermaster-mb510l-atx',
                'description' => 'Mesh front panel dengan clean design untuk airflow optimal. Cable management yang baik untuk build rapi.',
                'price' => 1100000,
                'stock' => 22,
                'category_id' => $casingCategory->id,
                'image' => 'products/casing-cm-mb510l.jpg',
                'rating' => 4.6,
                'specifications' => [
                    'form_factor' => 'ATX, Micro ATX, Mini ITX',
                    'motherboard_support' => 'ATX, mATX, Mini-ITX',
                    'panel_type' => 'Tempered Glass Side Panel',
                    'front_panel' => 'Full Mesh Front',
                    'airflow_type' => 'High Airflow Mesh',
                    'rgb_lighting' => 'RGB Front Strip',
                    'max_gpu_length' => '410mm',
                    'max_cpu_cooler_height' => '167mm',
                    'max_psu_length' => '180mm',
                    'drive_bays_35' => '2x 3.5" HDD',
                    'drive_bays_25' => '2x 2.5" SSD',
                    'fan_support_front' => '3x 120mm or 2x 140mm',
                    'fan_support_top' => '2x 120mm or 2x 140mm',
                    'fan_support_rear' => '1x 120mm (included)',
                    'fan_included' => '2x 120mm RGB Front',
                    'cable_management' => 'Good',
                    'io_ports' => 'USB 3.2 Gen 1 x2, Audio',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                    'dimensions' => '497 x 217 x 474mm'
                ]
            ],

            // 💎 High-End & Premium Case
            [
                'name' => 'Lian Li LANCOOL 215 ATX',
                'slug' => 'lianli-lancool-215-atx',
                'description' => 'High airflow dengan excellent build quality. Cocok untuk enthusiast build dengan cooling maksimal.',
                'price' => 2000000,
                'stock' => 15,
                'category_id' => $casingCategory->id,
                'image' => 'products/casing-lianli-215.jpg',
                'rating' => 4.8,
                'specifications' => [
                    'form_factor' => 'ATX, Micro ATX, Mini ITX',
                    'motherboard_support' => 'E-ATX (up to 280mm), ATX, mATX, Mini-ITX',
                    'panel_type' => 'Tempered Glass Side Panel',
                    'front_panel' => 'Full Mesh Front',
                    'airflow_type' => 'Extreme High Airflow',
                    'rgb_lighting' => 'No (Fan RGB Ready)',
                    'max_gpu_length' => '384mm',
                    'max_cpu_cooler_height' => '176mm',
                    'max_psu_length' => '200mm',
                    'drive_bays_35' => '2x 3.5" HDD',
                    'drive_bays_25' => '4x 2.5" SSD',
                    'fan_support_front' => '3x 120mm or 2x 140mm (2x 200mm included)',
                    'fan_support_top' => '3x 120mm or 2x 140mm',
                    'fan_support_rear' => '1x 120mm (included)',
                    'fan_included' => '2x 200mm Front + 1x 120mm Rear',
                    'cable_management' => 'Excellent',
                    'io_ports' => 'USB 3.1 Gen 2 Type-C, USB 3.0 x2, Audio',
                    'use_case' => 'Gaming, Editing',
                    'tier' => 'Future Proof',
                    'dimensions' => '478 x 229 x 494mm'
                ]
            ],
            [
                'name' => 'Phanteks Eclipse P400A D-RGB',
                'slug' => 'phanteks-p400a-drgb',
                'description' => 'Premium mesh front dengan tempered glass. D-RGB lighting dan airflow tinggi untuk high-end gaming.',
                'price' => 2200000,
                'stock' => 12,
                'category_id' => $casingCategory->id,
                'image' => 'products/casing-phanteks-p400a.jpg',
                'rating' => 4.9,
                'specifications' => [
                    'form_factor' => 'ATX, Micro ATX, Mini ITX',
                    'motherboard_support' => 'ATX, mATX, Mini-ITX',
                    'panel_type' => 'Tempered Glass Side Panel',
                    'front_panel' => 'Ultra-Fine Mesh Front',
                    'airflow_type' => 'Premium High Airflow',
                    'rgb_lighting' => 'D-RGB (3x 120mm fans)',
                    'max_gpu_length' => '420mm (with front fan), 380mm (with radiator)',
                    'max_cpu_cooler_height' => '160mm',
                    'max_psu_length' => '220mm',
                    'drive_bays_35' => '2x 3.5" HDD',
                    'drive_bays_25' => '3x 2.5" SSD',
                    'fan_support_front' => '3x 120mm or 2x 140mm (3x 120mm D-RGB included)',
                    'fan_support_top' => '3x 120mm or 2x 140mm',
                    'fan_support_rear' => '1x 120mm (D-RGB included)',
                    'fan_included' => '3x 120mm D-RGB Front + 1x 120mm D-RGB Rear',
                    'cable_management' => 'Excellent (Cable Cover)',
                    'io_ports' => 'USB 3.1 Gen 2 Type-C, USB 3.0 x2, Audio, RGB Button',
                    'radiator_support' => 'Front: 360mm, Top: 360mm, Rear: 120mm',
                    'use_case' => 'Gaming, Editing',
                    'tier' => 'Future Proof',
                    'dimensions' => '465 x 210 x 470mm'
                ]
            ],
        ];

        foreach ($casings as $casingData) {
            Product::updateOrCreate(
                ['slug' => $casingData['slug']],
                $casingData
            );
        }

        $this->command->info('✅ Casing products seeded successfully!');
        $this->command->info('Total: ' . count($casings) . ' cases added');
        
        $budgetCount = collect($casings)->filter(fn($c) => $c['price'] <= 500000)->count();
        $midCount = collect($casings)->filter(fn($c) => $c['price'] > 500000 && $c['price'] <= 1500000)->count();
        $premiumCount = collect($casings)->filter(fn($c) => $c['price'] > 1500000)->count();
        $this->command->info("📌 Budget: {$budgetCount} | Mid-Range: {$midCount} | Premium: {$premiumCount}");
        
        $meshCount = collect($casings)->filter(fn($c) => str_contains($c['specifications']['front_panel'], 'Mesh'))->count();
        $rgbCount = collect($casings)->filter(fn($c) => $c['specifications']['rgb_lighting'] !== 'No')->count();
        $this->command->info("📌 Mesh Front: {$meshCount} | With RGB: {$rgbCount}");
    }
}
