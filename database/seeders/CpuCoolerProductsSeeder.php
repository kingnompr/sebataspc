<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class CpuCoolerProductsSeeder extends Seeder
{
    public function run(): void
    {
        $coolingCategory = Category::where('slug', 'cooling')->first();
        
        if (!$coolingCategory) {
            $this->command->error('❌ Cooling category not found! Please run categories seeder first.');
            return;
        }

        $coolers = [
            // 🧊 Stock Cooler (Bawaan CPU) - untuk reference saja
            [
                'name' => 'Intel Stock Cooler (Box CPU)',
                'slug' => 'intel-stock-cooler',
                'description' => 'Stock cooler bawaan CPU Intel untuk non-K series. Cukup untuk daily use dan gaming ringan tanpa overclock.',
                'price' => 150000,
                'stock' => 50,
                'category_id' => $coolingCategory->id,
                'image' => 'products/cooler-intel-stock.jpg',
                'rating' => 3.8,
                'specifications' => [
                    'cooler_type' => 'Air Cooler',
                    'height' => '60mm',
                    'fan_size' => '92mm',
                    'noise_level' => '35 dBA',
                    'tdp_rating' => '65W',
                    'socket_support' => 'LGA1700, LGA1200, LGA1151',
                    'rgb_lighting' => 'No',
                    'material' => 'Aluminum',
                    'recommended_for' => 'Office, Daily Use (non-overclocked CPUs)',
                    'use_case' => 'Office',
                    'tier' => 'Best Value'
                ]
            ],
            [
                'name' => 'AMD Wraith Stealth Cooler (Box CPU)',
                'slug' => 'amd-wraith-stealth',
                'description' => 'AMD stock cooler untuk Ryzen series. Efisien untuk penggunaan normal dan gaming ringan.',
                'price' => 180000,
                'stock' => 45,
                'category_id' => $coolingCategory->id,
                'image' => 'products/cooler-amd-wraith.jpg',
                'rating' => 4.0,
                'specifications' => [
                    'cooler_type' => 'Air Cooler',
                    'height' => '54mm',
                    'fan_size' => '92mm',
                    'noise_level' => '38 dBA',
                    'tdp_rating' => '65W',
                    'socket_support' => 'AM4, AM5',
                    'rgb_lighting' => 'No',
                    'material' => 'Aluminum',
                    'recommended_for' => 'Office, Daily Use (Ryzen 3/5 non-X)',
                    'use_case' => 'Office',
                    'tier' => 'Best Value'
                ]
            ],

            // 🌀 Air Cooler – Budget / Value
            [
                'name' => 'Deepcool Gammaxx 400 V2',
                'slug' => 'deepcool-gammaxx400-v2',
                'description' => 'Air cooler budget dengan performa baik untuk gaming harian. Value terbaik di kelasnya untuk CPU mainstream.',
                'price' => 450000,
                'stock' => 35,
                'category_id' => $coolingCategory->id,
                'image' => 'products/cooler-gammaxx400.jpg',
                'rating' => 4.4,
                'specifications' => [
                    'cooler_type' => 'Tower Air Cooler',
                    'height' => '155mm',
                    'fan_size' => '120mm PWM',
                    'noise_level' => '17.8 - 27.8 dBA',
                    'tdp_rating' => '180W',
                    'socket_support' => 'LGA1700, LGA1200, LGA1151, AM4, AM5',
                    'rgb_lighting' => 'No',
                    'heatpipes' => '4x 6mm Direct Contact',
                    'material' => 'Copper + Aluminum',
                    'recommended_for' => 'Gaming 1080p, Daily Use',
                    'use_case' => 'Gaming, Office',
                    'tier' => 'Best Value'
                ]
            ],
            [
                'name' => 'Cooler Master Hyper 212 Black Edition',
                'slug' => 'coolermaster-hyper212-black',
                'description' => 'Legendary air cooler dengan performa terbukti. Value terbaik untuk cooling aftermarket dengan harga terjangkau.',
                'price' => 550000,
                'stock' => 40,
                'category_id' => $coolingCategory->id,
                'image' => 'products/cooler-hyper212.jpg',
                'rating' => 4.6,
                'specifications' => [
                    'cooler_type' => 'Tower Air Cooler',
                    'height' => '158.8mm',
                    'fan_size' => '120mm PWM',
                    'noise_level' => '9 - 36 dBA',
                    'tdp_rating' => '180W',
                    'socket_support' => 'LGA1700, LGA1200, LGA1151, AM4, AM5',
                    'rgb_lighting' => 'No',
                    'heatpipes' => '4x 6mm Direct Contact',
                    'material' => 'Nickel-Plated Copper + Aluminum',
                    'recommended_for' => 'Gaming, Light Overclocking',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value'
                ]
            ],

            // ❄️ Air Cooler – Mid Range
            [
                'name' => 'Scythe Mugen 5 Rev. B',
                'slug' => 'scythe-mugen5-revb',
                'description' => 'Cooling kuat dengan noise rendah untuk gaming berat dan multitasking. Suhu stabil untuk session panjang.',
                'price' => 950000,
                'stock' => 25,
                'category_id' => $coolingCategory->id,
                'image' => 'products/cooler-mugen5.jpg',
                'rating' => 4.7,
                'specifications' => [
                    'cooler_type' => 'Tower Air Cooler',
                    'height' => '154.5mm',
                    'fan_size' => '120mm PWM',
                    'noise_level' => '4 - 24.9 dBA',
                    'tdp_rating' => '200W',
                    'socket_support' => 'LGA1700, LGA1200, LGA1151, AM4, AM5',
                    'rgb_lighting' => 'No',
                    'heatpipes' => '6x 6mm',
                    'material' => 'Nickel-Plated Copper + Aluminum',
                    'recommended_for' => 'Heavy Gaming, Multitasking, Moderate OC',
                    'use_case' => 'Gaming, Editing',
                    'tier' => 'Best Performance'
                ]
            ],
            [
                'name' => 'Noctua NH-U12S Redux',
                'slug' => 'noctua-nhu12s-redux',
                'description' => 'Kualitas premium air cooler dari Noctua. Cooling excellent dengan noise minimal untuk build high-end.',
                'price' => 1200000,
                'stock' => 20,
                'category_id' => $coolingCategory->id,
                'image' => 'products/cooler-noctua-u12s.jpg',
                'rating' => 4.8,
                'specifications' => [
                    'cooler_type' => 'Tower Air Cooler',
                    'height' => '158mm',
                    'fan_size' => '120mm PWM',
                    'noise_level' => '12.6 - 22.4 dBA',
                    'tdp_rating' => '165W',
                    'socket_support' => 'LGA1700, LGA1200, LGA1151, AM4, AM5',
                    'rgb_lighting' => 'No',
                    'heatpipes' => '5x 6mm',
                    'material' => 'Nickel-Plated Copper + Aluminum',
                    'fan_included' => 'Noctua NF-P12 redux-1700 PWM',
                    'recommended_for' => 'Premium Build, Silent Operation',
                    'use_case' => 'Gaming, Editing',
                    'tier' => 'Best Performance',
                    'warranty' => '6 Years'
                ]
            ],

            // 💧 Liquid AIO (All-in-One) – High Performance
            [
                'name' => 'Deepcool Castle 240EX',
                'slug' => 'deepcool-castle-240ex',
                'description' => 'AIO 240mm dengan harga kompetitif dan performa dingin. Cocok untuk CPU high-end dan moderate overclocking.',
                'price' => 1700000,
                'stock' => 18,
                'category_id' => $coolingCategory->id,
                'image' => 'products/cooler-deepcool-240ex.jpg',
                'rating' => 4.6,
                'specifications' => [
                    'cooler_type' => 'Liquid AIO',
                    'radiator_size' => '240mm (277 x 120 x 27mm)',
                    'fan_size' => '2x 120mm PWM',
                    'noise_level' => '17.8 - 32.9 dBA',
                    'pump_speed' => '2550 RPM ±10%',
                    'tdp_rating' => '250W',
                    'socket_support' => 'LGA1700, LGA1200, LGA1151, AM4, AM5',
                    'rgb_lighting' => 'ARGB Pump Head',
                    'tubing_length' => '410mm',
                    'material' => 'Copper Waterblock + Aluminum Radiator',
                    'recommended_for' => 'High-End Gaming, Overclocking',
                    'use_case' => 'Gaming, Editing',
                    'tier' => 'Future Proof',
                    'warranty' => '3 Years'
                ]
            ],
            [
                'name' => 'Corsair iCUE H100i RGB Pro XT 240mm',
                'slug' => 'corsair-h100i-rgb-xt',
                'description' => 'Premium AIO dengan RGB dan cooling maksimal. Estetika top-tier dengan performa dingin untuk enthusiast build.',
                'price' => 1900000,
                'stock' => 15,
                'category_id' => $coolingCategory->id,
                'image' => 'products/cooler-corsair-h100i.jpg',
                'rating' => 4.8,
                'specifications' => [
                    'cooler_type' => 'Liquid AIO',
                    'radiator_size' => '240mm (277 x 120 x 27mm)',
                    'fan_size' => '2x 120mm ML PWM',
                    'noise_level' => '10 - 36 dBA',
                    'pump_speed' => '2400 RPM',
                    'tdp_rating' => '250W',
                    'socket_support' => 'LGA1700, LGA1200, LGA1151, AM4, AM5',
                    'rgb_lighting' => 'RGB Pump Head + RGB Fans',
                    'tubing_length' => '400mm',
                    'material' => 'Copper Waterblock + Aluminum Radiator',
                    'software_control' => 'Corsair iCUE',
                    'recommended_for' => 'Premium Gaming, Heavy Overclocking',
                    'use_case' => 'Gaming, Editing',
                    'tier' => 'Future Proof',
                    'warranty' => '5 Years'
                ]
            ],
        ];

        foreach ($coolers as $coolerData) {
            Product::updateOrCreate(
                ['slug' => $coolerData['slug']],
                $coolerData
            );
        }

        $this->command->info('✅ CPU Cooler products seeded successfully!');
        $this->command->info('Total: ' . count($coolers) . ' coolers added');
        
        $stockCount = collect($coolers)->filter(fn($c) => str_contains($c['slug'], 'stock') || str_contains($c['slug'], 'wraith'))->count();
        $airCount = collect($coolers)->filter(fn($c) => $c['specifications']['cooler_type'] === 'Tower Air Cooler')->count();
        $aioCount = collect($coolers)->filter(fn($c) => $c['specifications']['cooler_type'] === 'Liquid AIO')->count();
        $this->command->info("📌 Stock Coolers: {$stockCount} | Air Coolers: {$airCount} | Liquid AIO: {$aioCount}");
        
        $budgetCount = collect($coolers)->filter(fn($c) => $c['price'] <= 600000)->count();
        $midCount = collect($coolers)->filter(fn($c) => $c['price'] > 600000 && $c['price'] <= 1300000)->count();
        $premiumCount = collect($coolers)->filter(fn($c) => $c['price'] > 1300000)->count();
        $this->command->info("📌 Budget: {$budgetCount} | Mid-Range: {$midCount} | Premium: {$premiumCount}");
    }
}
