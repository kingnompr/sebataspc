<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class CpuProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Get CPU category (should already exist from main seeder)
        $cpuCategory = Category::where('slug', 'cpu')->first();
        
        if (!$cpuCategory) {
            $cpuCategory = Category::create([
                'name' => 'CPU',
                'slug' => 'cpu',
                'description' => 'Processor untuk PC',
                'icon' => 'memory',
            ]);
        }

        $cpuProducts = [
            // OFFICE / DAILY USE
            [
                'name' => 'Intel Core i3-10105',
                'slug' => 'intel-core-i3-10105',
                'description' => '4 Core / 8 Thread | iGPU: Intel UHD Graphics | Stabil, murah, tanpa VGA | Cocok untuk kerja ringan, browsing, admin, kasir, dan multitasking ringan',
                'price' => 1400000,
                'stock' => 25,
                'category_id' => $cpuCategory->id,
                'is_featured' => false,
                'rating' => 4.3,
                'specifications' => json_encode([
                    'cores' => '4 Core / 8 Thread',
                    'igpu' => 'Intel UHD Graphics',
                    'socket' => 'LGA1200',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'Intel Core i3-12100',
                'slug' => 'intel-core-i3-12100',
                'description' => '4 Core / 8 Thread (Gen 12) | iGPU: UHD 730 | Performa single-core sangat baik | Cocok untuk kerja ringan hingga menengah',
                'price' => 1800000,
                'stock' => 30,
                'category_id' => $cpuCategory->id,
                'is_featured' => true,
                'rating' => 4.5,
                'specifications' => json_encode([
                    'cores' => '4 Core / 8 Thread',
                    'igpu' => 'Intel UHD 730',
                    'socket' => 'LGA1700',
                    'use_case' => 'Office',
                    'tier' => 'Best Performance',
                ]),
            ],
            [
                'name' => 'AMD Ryzen 3 3200G',
                'slug' => 'amd-ryzen-3-3200g',
                'description' => '4 Core / 4 Thread | iGPU: Vega 8 | iGPU kuat untuk office & multimedia | Hemat budget tanpa VGA',
                'price' => 1500000,
                'stock' => 20,
                'category_id' => $cpuCategory->id,
                'is_featured' => false,
                'rating' => 4.2,
                'specifications' => json_encode([
                    'cores' => '4 Core / 4 Thread',
                    'igpu' => 'Radeon Vega 8',
                    'socket' => 'AM4',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'AMD Ryzen 5 5600G',
                'slug' => 'amd-ryzen-5-5600g',
                'description' => '6 Core / 12 Thread | iGPU: Vega 7 | Office berat + editing ringan | APU terkuat untuk non-gaming',
                'price' => 2500000,
                'stock' => 28,
                'category_id' => $cpuCategory->id,
                'is_featured' => true,
                'rating' => 4.7,
                'specifications' => json_encode([
                    'cores' => '6 Core / 12 Thread',
                    'igpu' => 'Radeon Vega 7',
                    'socket' => 'AM4',
                    'use_case' => 'Office',
                    'tier' => 'Best Performance',
                ]),
            ],

            // GAMING ENTRY – MID
            [
                'name' => 'Intel Core i5-10400F',
                'slug' => 'intel-core-i5-10400f',
                'description' => '6 Core / 12 Thread | Tanpa iGPU | Gaming value terbaik | Wajib pakai VGA | Cocok untuk gaming 1080p',
                'price' => 1900000,
                'stock' => 35,
                'category_id' => $cpuCategory->id,
                'is_featured' => true,
                'rating' => 4.6,
                'specifications' => json_encode([
                    'cores' => '6 Core / 12 Thread',
                    'igpu' => 'None (F Series)',
                    'socket' => 'LGA1200',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'Intel Core i5-12400F',
                'slug' => 'intel-core-i5-12400f',
                'description' => '6 Core / 12 Thread | Tanpa iGPU | Performa gaming modern & stabil | Generasi terbaru LGA1700',
                'price' => 2700000,
                'stock' => 40,
                'category_id' => $cpuCategory->id,
                'is_featured' => true,
                'rating' => 4.8,
                'specifications' => json_encode([
                    'cores' => '6 Core / 12 Thread',
                    'igpu' => 'None (F Series)',
                    'socket' => 'LGA1700',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                ]),
            ],
            [
                'name' => 'AMD Ryzen 5 3600',
                'slug' => 'amd-ryzen-5-3600',
                'description' => '6 Core / 12 Thread | Tanpa iGPU | Balanced gaming + multitasking | Legendary value CPU',
                'price' => 2000000,
                'stock' => 32,
                'category_id' => $cpuCategory->id,
                'is_featured' => false,
                'rating' => 4.7,
                'specifications' => json_encode([
                    'cores' => '6 Core / 12 Thread',
                    'igpu' => 'None',
                    'socket' => 'AM4',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'AMD Ryzen 5 5600',
                'slug' => 'amd-ryzen-5-5600',
                'description' => '6 Core / 12 Thread | Tanpa iGPU | Sangat kuat untuk gaming 1080p–1440p | Top tier gaming CPU',
                'price' => 2400000,
                'stock' => 38,
                'category_id' => $cpuCategory->id,
                'is_featured' => true,
                'rating' => 4.9,
                'specifications' => json_encode([
                    'cores' => '6 Core / 12 Thread',
                    'igpu' => 'None',
                    'socket' => 'AM4',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                ]),
            ],

            // EDITING / MULTITASKING
            [
                'name' => 'Intel Core i5-12600KF',
                'slug' => 'intel-core-i5-12600kf',
                'description' => '10 Core (6P + 4E) / 16 Thread | Tanpa iGPU | Rendering cepat & multitasking kuat | Hybrid architecture',
                'price' => 3500000,
                'stock' => 22,
                'category_id' => $cpuCategory->id,
                'is_featured' => true,
                'rating' => 4.8,
                'specifications' => json_encode([
                    'cores' => '10 Core (6P + 4E) / 16 Thread',
                    'igpu' => 'None (F Series)',
                    'socket' => 'LGA1700',
                    'use_case' => 'Editing',
                    'tier' => 'Best Performance',
                ]),
            ],
            [
                'name' => 'Intel Core i7-12700',
                'slug' => 'intel-core-i7-12700',
                'description' => '12 Core / 20 Thread | iGPU: UHD 770 | Editing profesional | Workstation grade performance',
                'price' => 4800000,
                'stock' => 18,
                'category_id' => $cpuCategory->id,
                'is_featured' => true,
                'rating' => 4.9,
                'specifications' => json_encode([
                    'cores' => '12 Core / 20 Thread',
                    'igpu' => 'Intel UHD 770',
                    'socket' => 'LGA1700',
                    'use_case' => 'Editing',
                    'tier' => 'Future Proof',
                ]),
            ],
            [
                'name' => 'AMD Ryzen 7 5700X',
                'slug' => 'amd-ryzen-7-5700x',
                'description' => '8 Core / 16 Thread | Tanpa iGPU | Editing + gaming seimbang | Sweet spot for content creators',
                'price' => 3600000,
                'stock' => 24,
                'category_id' => $cpuCategory->id,
                'is_featured' => true,
                'rating' => 4.8,
                'specifications' => json_encode([
                    'cores' => '8 Core / 16 Thread',
                    'igpu' => 'None',
                    'socket' => 'AM4',
                    'use_case' => 'Editing',
                    'tier' => 'Best Performance',
                ]),
            ],

            // HIGH-END / FUTURE PROOF
            [
                'name' => 'Intel Core i7-13700K',
                'slug' => 'intel-core-i7-13700k',
                'description' => '16 Core / 24 Thread | iGPU: UHD 770 | Performa ekstrem & future proof | Flagship Intel Gen 13',
                'price' => 6500000,
                'stock' => 12,
                'category_id' => $cpuCategory->id,
                'is_featured' => true,
                'rating' => 5.0,
                'specifications' => json_encode([
                    'cores' => '16 Core / 24 Thread',
                    'igpu' => 'Intel UHD 770',
                    'socket' => 'LGA1700',
                    'use_case' => 'Gaming',
                    'tier' => 'Future Proof',
                ]),
            ],
            [
                'name' => 'AMD Ryzen 9 5900X',
                'slug' => 'amd-ryzen-9-5900x',
                'description' => '12 Core / 24 Thread | Tanpa iGPU | Workstation & editing berat | Extreme multitasking beast',
                'price' => 5500000,
                'stock' => 15,
                'category_id' => $cpuCategory->id,
                'is_featured' => true,
                'rating' => 4.9,
                'specifications' => json_encode([
                    'cores' => '12 Core / 24 Thread',
                    'igpu' => 'None',
                    'socket' => 'AM4',
                    'use_case' => 'Editing',
                    'tier' => 'Future Proof',
                ]),
            ],
        ];

        foreach ($cpuProducts as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }

        $this->command->info('✅ CPU products seeded successfully!');
        $this->command->info('Total: ' . count($cpuProducts) . ' processors added');
    }
}
