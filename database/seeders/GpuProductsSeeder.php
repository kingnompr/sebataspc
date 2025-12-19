<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class GpuProductsSeeder extends Seeder
{
    public function run(): void
    {
        $gpuCategory = Category::where('slug', 'gpu')->first();
        
        if (!$gpuCategory) {
            $this->command->error('❌ GPU category not found! Please run categories seeder first.');
            return;
        }

        $gpus = [
            // 🎮 Entry-Level / Budget Gaming (1080p Esports)
            [
                'name' => 'NVIDIA GeForce GTX 1650 4GB GDDR6',
                'slug' => 'nvidia-gtx-1650-4gb',
                'description' => 'Entry-level gaming untuk esports & 1080p ringan. Stabil di game kompetitif seperti Valorant, CS:GO, dan Dota 2.',
                'price' => 2000000,
                'stock' => 25,
                'category_id' => $gpuCategory->id,
                'image' => 'products/gpu-gtx1650.jpg',
                'rating' => 4.3,
                'specifications' => [
                    'gpu_model' => 'GTX 1650',
                    'brand' => 'NVIDIA',
                    'vram' => '4GB',
                    'memory_type' => 'GDDR6',
                    'base_clock' => '1485 MHz',
                    'boost_clock' => '1665 MHz',
                    'cuda_cores' => '896',
                    'memory_bus' => '128-bit',
                    'tdp' => '75W',
                    'power_connector' => 'None (powered by PCIe slot)',
                    'outputs' => 'HDMI 2.0b, DisplayPort 1.4',
                    'resolution_target' => '1080p',
                    'recommended_psu' => '300W',
                    'features' => 'Turing Architecture, NVIDIA Encoder',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                    'gaming_performance' => '1080p Esports 60+ FPS'
                ]
            ],
            [
                'name' => 'AMD Radeon RX 6500 XT 4GB GDDR6',
                'slug' => 'amd-rx6500xt-4gb',
                'description' => 'Value terbaik di entry segment AMD. Performa kompetitif untuk 1080p gaming dengan efisiensi daya tinggi.',
                'price' => 2100000,
                'stock' => 20,
                'category_id' => $gpuCategory->id,
                'image' => 'products/gpu-rx6500xt.jpg',
                'rating' => 4.2,
                'specifications' => [
                    'gpu_model' => 'RX 6500 XT',
                    'brand' => 'AMD',
                    'vram' => '4GB',
                    'memory_type' => 'GDDR6',
                    'game_clock' => '2610 MHz',
                    'boost_clock' => '2815 MHz',
                    'stream_processors' => '1024',
                    'memory_bus' => '64-bit',
                    'tdp' => '107W',
                    'power_connector' => '6-pin PCIe',
                    'outputs' => 'HDMI 2.1, DisplayPort 1.4a',
                    'resolution_target' => '1080p',
                    'recommended_psu' => '400W',
                    'features' => 'RDNA 2, AMD FidelityFX Super Resolution (FSR)',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                    'gaming_performance' => '1080p Medium-High 60+ FPS'
                ]
            ],

            // 🔷 Mid-Tier Gaming (1080p High Settings)
            [
                'name' => 'NVIDIA GeForce GTX 1660 Super 6GB GDDR6',
                'slug' => 'nvidia-gtx1660super-6gb',
                'description' => '1080p high FPS kuat untuk gaming modern. Sweet spot untuk competitive gaming dan AAA titles.',
                'price' => 3000000,
                'stock' => 30,
                'category_id' => $gpuCategory->id,
                'image' => 'products/gpu-gtx1660super.jpg',
                'rating' => 4.6,
                'specifications' => [
                    'gpu_model' => 'GTX 1660 Super',
                    'brand' => 'NVIDIA',
                    'vram' => '6GB',
                    'memory_type' => 'GDDR6',
                    'base_clock' => '1530 MHz',
                    'boost_clock' => '1785 MHz',
                    'cuda_cores' => '1408',
                    'memory_bus' => '192-bit',
                    'tdp' => '125W',
                    'power_connector' => '8-pin PCIe',
                    'outputs' => 'HDMI 2.0b, DisplayPort 1.4',
                    'resolution_target' => '1080p',
                    'recommended_psu' => '450W',
                    'features' => 'Turing Architecture, NVIDIA Encoder (NVENC)',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                    'gaming_performance' => '1080p High 100+ FPS'
                ]
            ],
            [
                'name' => 'AMD Radeon RX 6600 8GB GDDR6',
                'slug' => 'amd-rx6600-8gb',
                'description' => 'Performa gaming kuat & efisien untuk 1080p ultra settings. Dilengkapi dengan 8GB VRAM untuk texture quality tinggi.',
                'price' => 3500000,
                'stock' => 25,
                'category_id' => $gpuCategory->id,
                'image' => 'products/gpu-rx6600.jpg',
                'rating' => 4.7,
                'specifications' => [
                    'gpu_model' => 'RX 6600',
                    'brand' => 'AMD',
                    'vram' => '8GB',
                    'memory_type' => 'GDDR6',
                    'game_clock' => '2044 MHz',
                    'boost_clock' => '2491 MHz',
                    'stream_processors' => '1792',
                    'memory_bus' => '128-bit',
                    'tdp' => '132W',
                    'power_connector' => '8-pin PCIe',
                    'outputs' => 'HDMI 2.1, DisplayPort 1.4a',
                    'resolution_target' => '1080p',
                    'recommended_psu' => '500W',
                    'features' => 'RDNA 2, Ray Accelerators, AMD FSR 2.0',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                    'gaming_performance' => '1080p Ultra 100+ FPS'
                ]
            ],

            // 🔥 Upper Mid / 1440p Gaming
            [
                'name' => 'NVIDIA GeForce RTX 3060 12GB GDDR6',
                'slug' => 'nvidia-rtx3060-12gb',
                'description' => 'DLSS + Ray Tracing Entry untuk 1440p gaming. Cocok untuk streaming dengan NVIDIA Broadcast.',
                'price' => 4500000,
                'stock' => 20,
                'category_id' => $gpuCategory->id,
                'image' => 'products/gpu-rtx3060.jpg',
                'rating' => 4.7,
                'specifications' => [
                    'gpu_model' => 'RTX 3060',
                    'brand' => 'NVIDIA',
                    'vram' => '12GB',
                    'memory_type' => 'GDDR6',
                    'base_clock' => '1320 MHz',
                    'boost_clock' => '1777 MHz',
                    'cuda_cores' => '3584',
                    'rt_cores' => '28 (2nd Gen)',
                    'tensor_cores' => '112 (3rd Gen)',
                    'memory_bus' => '192-bit',
                    'tdp' => '170W',
                    'power_connector' => '8-pin PCIe',
                    'outputs' => 'HDMI 2.1, DisplayPort 1.4a',
                    'resolution_target' => '1440p',
                    'recommended_psu' => '550W',
                    'features' => 'Ampere Architecture, Ray Tracing, DLSS 2.0, NVIDIA Broadcast',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                    'gaming_performance' => '1440p High 60+ FPS with RT'
                ]
            ],
            [
                'name' => 'AMD Radeon RX 6700 XT 12GB GDDR6',
                'slug' => 'amd-rx6700xt-12gb',
                'description' => '1440p gaming mantap dengan 12GB VRAM. Performa tinggi untuk AAA games dan content creation.',
                'price' => 6000000,
                'stock' => 15,
                'category_id' => $gpuCategory->id,
                'image' => 'products/gpu-rx6700xt.jpg',
                'rating' => 4.8,
                'specifications' => [
                    'gpu_model' => 'RX 6700 XT',
                    'brand' => 'AMD',
                    'vram' => '12GB',
                    'memory_type' => 'GDDR6',
                    'game_clock' => '2424 MHz',
                    'boost_clock' => '2581 MHz',
                    'stream_processors' => '2560',
                    'memory_bus' => '192-bit',
                    'tdp' => '230W',
                    'power_connector' => '8-pin + 6-pin PCIe',
                    'outputs' => 'HDMI 2.1, DisplayPort 1.4a',
                    'resolution_target' => '1440p',
                    'recommended_psu' => '650W',
                    'features' => 'RDNA 2, Ray Accelerators, AMD FSR 2.0, Infinity Cache 96MB',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                    'gaming_performance' => '1440p Ultra 100+ FPS'
                ]
            ],

            // 💎 High-End / Future-Proof (1440p Ultra & 4K)
            [
                'name' => 'NVIDIA GeForce RTX 3070 8GB GDDR6',
                'slug' => 'nvidia-rtx3070-8gb',
                'description' => '1440p ultra / 4K ringan dengan Ray Tracing penuh. Performa setara RTX 2080 Ti generasi sebelumnya.',
                'price' => 8000000,
                'stock' => 12,
                'category_id' => $gpuCategory->id,
                'image' => 'products/gpu-rtx3070.jpg',
                'rating' => 4.9,
                'specifications' => [
                    'gpu_model' => 'RTX 3070',
                    'brand' => 'NVIDIA',
                    'vram' => '8GB',
                    'memory_type' => 'GDDR6',
                    'base_clock' => '1500 MHz',
                    'boost_clock' => '1725 MHz',
                    'cuda_cores' => '5888',
                    'rt_cores' => '46 (2nd Gen)',
                    'tensor_cores' => '184 (3rd Gen)',
                    'memory_bus' => '256-bit',
                    'tdp' => '220W',
                    'power_connector' => '8-pin + 8-pin PCIe',
                    'outputs' => 'HDMI 2.1, DisplayPort 1.4a',
                    'resolution_target' => '1440p/4K',
                    'recommended_psu' => '650W',
                    'features' => 'Ampere Architecture, Ray Tracing, DLSS 2.0, NVIDIA Reflex',
                    'use_case' => 'Gaming, Editing',
                    'tier' => 'Future Proof',
                    'gaming_performance' => '1440p Ultra 120+ FPS, 4K Medium 60+ FPS'
                ]
            ],
            [
                'name' => 'AMD Radeon RX 6800 XT 16GB GDDR6',
                'slug' => 'amd-rx6800xt-16gb',
                'description' => '4K performance & VRAM besar untuk gaming dan rendering. Dilengkapi Infinity Cache 128MB untuk bandwidth tinggi.',
                'price' => 9500000,
                'stock' => 10,
                'category_id' => $gpuCategory->id,
                'image' => 'products/gpu-rx6800xt.jpg',
                'rating' => 4.9,
                'specifications' => [
                    'gpu_model' => 'RX 6800 XT',
                    'brand' => 'AMD',
                    'vram' => '16GB',
                    'memory_type' => 'GDDR6',
                    'game_clock' => '2015 MHz',
                    'boost_clock' => '2250 MHz',
                    'stream_processors' => '4608',
                    'memory_bus' => '256-bit',
                    'tdp' => '300W',
                    'power_connector' => '8-pin + 8-pin PCIe',
                    'outputs' => 'HDMI 2.1, DisplayPort 1.4a',
                    'resolution_target' => '4K',
                    'recommended_psu' => '750W',
                    'features' => 'RDNA 2, Ray Accelerators, AMD FSR 2.0, Infinity Cache 128MB, Smart Access Memory',
                    'use_case' => 'Gaming, Editing',
                    'tier' => 'Future Proof',
                    'gaming_performance' => '4K High 80+ FPS, 1440p Ultra 144+ FPS'
                ]
            ],
        ];

        foreach ($gpus as $gpuData) {
            Product::updateOrCreate(
                ['slug' => $gpuData['slug']],
                $gpuData
            );
        }

        $this->command->info('✅ GPU products seeded successfully!');
        $this->command->info('Total: ' . count($gpus) . ' graphics cards added');
        
        $nvidiaCount = collect($gpus)->filter(fn($gpu) => $gpu['specifications']['brand'] === 'NVIDIA')->count();
        $amdCount = collect($gpus)->filter(fn($gpu) => $gpu['specifications']['brand'] === 'AMD')->count();
        $this->command->info("📌 NVIDIA: {$nvidiaCount} products | AMD: {$amdCount} products");
        
        $entryCount = collect($gpus)->filter(fn($gpu) => $gpu['price'] <= 2500000)->count();
        $midCount = collect($gpus)->filter(fn($gpu) => $gpu['price'] > 2500000 && $gpu['price'] <= 5000000)->count();
        $highCount = collect($gpus)->filter(fn($gpu) => $gpu['price'] > 5000000)->count();
        $this->command->info("📌 Entry-Level: {$entryCount} | Mid-Tier: {$midCount} | High-End: {$highCount}");
    }
}
