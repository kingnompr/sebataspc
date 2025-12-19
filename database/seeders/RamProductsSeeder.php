<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class RamProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Get RAM category
        $ramCategory = Category::where('slug', 'ram')->first();
        
        if (!$ramCategory) {
            $ramCategory = Category::create([
                'name' => 'RAM',
                'slug' => 'ram',
                'description' => 'Memory RAM untuk PC',
                'icon' => 'memory_alt',
            ]);
        }

        $ramProducts = [
            // OFFICE / DAILY USE - 8GB DDR4
            [
                'name' => 'Corsair Vengeance LPX 8GB DDR4-3200',
                'slug' => 'corsair-vengeance-lpx-8gb-ddr4-3200',
                'description' => 'Capacity: 8GB | Speed: DDR4-3200 | Cukup untuk office & multitasking ringan | Cocok untuk kerja ringan, multitasking biasa, sekolah & kerja kantor',
                'price' => 450000,
                'stock' => 45,
                'category_id' => $ramCategory->id,
                'is_featured' => false,
                'rating' => 4.3,
                'specifications' => json_encode([
                    'capacity' => '8GB',
                    'type' => 'DDR4',
                    'speed' => '3200MHz',
                    'channels' => 'Single',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'Kingston FURY Impact 8GB DDR4-3200',
                'slug' => 'kingston-fury-impact-8gb-ddr4-3200',
                'description' => 'Capacity: 8GB | Speed: DDR4-3200 | Value terbaik untuk notebook / desktop | Reliable untuk daily use',
                'price' => 430000,
                'stock' => 50,
                'category_id' => $ramCategory->id,
                'is_featured' => true,
                'rating' => 4.5,
                'specifications' => json_encode([
                    'capacity' => '8GB',
                    'type' => 'DDR4',
                    'speed' => '3200MHz',
                    'channels' => 'Single',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                ]),
            ],

            // GAMING ENTRY / MID - 16GB DDR4
            [
                'name' => 'G.Skill Ripjaws V 16GB (2x8GB) DDR4-3200',
                'slug' => 'gskill-ripjaws-v-16gb-2x8gb-ddr4-3200',
                'description' => 'Capacity: 16GB (2x8GB) | Speed: DDR4-3200 | Dual-channel, performa maksimal gaming 1080p | Gaming entry & aplikasi umum',
                'price' => 1250000,
                'stock' => 35,
                'category_id' => $ramCategory->id,
                'is_featured' => true,
                'rating' => 4.7,
                'specifications' => json_encode([
                    'capacity' => '16GB',
                    'type' => 'DDR4',
                    'speed' => '3200MHz',
                    'channels' => 'Dual (2x8GB)',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                ]),
            ],
            [
                'name' => 'Crucial Ballistix 16GB (2x8GB) DDR4-3200',
                'slug' => 'crucial-ballistix-16gb-2x8gb-ddr4-3200',
                'description' => 'Capacity: 16GB (2x8GB) | Speed: DDR4-3200 | Stabil, cocok untuk gaming & daily multitasking | Reliable performance',
                'price' => 1200000,
                'stock' => 40,
                'category_id' => $ramCategory->id,
                'is_featured' => false,
                'rating' => 4.6,
                'specifications' => json_encode([
                    'capacity' => '16GB',
                    'type' => 'DDR4',
                    'speed' => '3200MHz',
                    'channels' => 'Dual (2x8GB)',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'TeamGroup T-Force Vulcan Z 16GB DDR4-3200',
                'slug' => 'teamgroup-tforce-vulcan-z-16gb-ddr4-3200',
                'description' => 'Capacity: 16GB (2x8GB) | Speed: DDR4-3200 | Value terbaik dengan latensi rendah | Budget gaming champion',
                'price' => 1150000,
                'stock' => 38,
                'category_id' => $ramCategory->id,
                'is_featured' => true,
                'rating' => 4.5,
                'specifications' => json_encode([
                    'capacity' => '16GB',
                    'type' => 'DDR4',
                    'speed' => '3200MHz',
                    'channels' => 'Dual (2x8GB)',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                ]),
            ],

            // EDITING / MULTITASKING BERAT - 32GB DDR4
            [
                'name' => 'Corsair Vengeance LPX 32GB (2x16GB) DDR4-3600',
                'slug' => 'corsair-vengeance-lpx-32gb-2x16gb-ddr4-3600',
                'description' => 'Capacity: 32GB (2x16GB) | Speed: DDR4-3600 | Kapasitas besar + kecepatan tinggi | Video editing ringan–sedang, desain grafis, virtual machine',
                'price' => 2800000,
                'stock' => 25,
                'category_id' => $ramCategory->id,
                'is_featured' => true,
                'rating' => 4.8,
                'specifications' => json_encode([
                    'capacity' => '32GB',
                    'type' => 'DDR4',
                    'speed' => '3600MHz',
                    'channels' => 'Dual (2x16GB)',
                    'use_case' => 'Editing',
                    'tier' => 'Best Performance',
                ]),
            ],
            [
                'name' => 'G.Skill Trident Z RGB 32GB (2x16GB) DDR4-3600',
                'slug' => 'gskill-trident-z-rgb-32gb-2x16gb-ddr4-3600',
                'description' => 'Capacity: 32GB (2x16GB) | Speed: DDR4-3600 | Performa & estetika RGB | Premium performance with style',
                'price' => 3100000,
                'stock' => 20,
                'category_id' => $ramCategory->id,
                'is_featured' => true,
                'rating' => 4.9,
                'specifications' => json_encode([
                    'capacity' => '32GB',
                    'type' => 'DDR4',
                    'speed' => '3600MHz',
                    'channels' => 'Dual (2x16GB)',
                    'rgb' => true,
                    'use_case' => 'Editing',
                    'tier' => 'Best Performance',
                ]),
            ],

            // FUTURE PROOF / HIGH-END - DDR5
            [
                'name' => 'Kingston FURY Beast 32GB (2x16GB) DDR5-5200',
                'slug' => 'kingston-fury-beast-32gb-2x16gb-ddr5-5200',
                'description' => 'Capacity: 32GB (2x16GB) | Speed: DDR5-5200 | DDR5 untuk platform terbaru | Editing berat, 3D rendering, content creation profesional',
                'price' => 4000000,
                'stock' => 15,
                'category_id' => $ramCategory->id,
                'is_featured' => true,
                'rating' => 4.9,
                'specifications' => json_encode([
                    'capacity' => '32GB',
                    'type' => 'DDR5',
                    'speed' => '5200MHz',
                    'channels' => 'Dual (2x16GB)',
                    'use_case' => 'Editing',
                    'tier' => 'Future Proof',
                ]),
            ],
            [
                'name' => 'Corsair Dominator Platinum RGB 32GB DDR5-5600',
                'slug' => 'corsair-dominator-platinum-rgb-32gb-ddr5-5600',
                'description' => 'Capacity: 32GB (2x16GB) | Speed: DDR5-5600 | Performa top dan estetika | Ultimate performance & RGB lighting',
                'price' => 4500000,
                'stock' => 12,
                'category_id' => $ramCategory->id,
                'is_featured' => true,
                'rating' => 5.0,
                'specifications' => json_encode([
                    'capacity' => '32GB',
                    'type' => 'DDR5',
                    'speed' => '5600MHz',
                    'channels' => 'Dual (2x16GB)',
                    'rgb' => true,
                    'use_case' => 'Editing',
                    'tier' => 'Future Proof',
                ]),
            ],
        ];

        foreach ($ramProducts as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }

        $this->command->info('✅ RAM products seeded successfully!');
        $this->command->info('Total: ' . count($ramProducts) . ' RAM modules added');
        $this->command->info('📌 DDR4: 7 products | DDR5: 2 products');
        $this->command->info('📌 8GB: 2 | 16GB: 3 | 32GB: 4');
    }
}
