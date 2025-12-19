<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class MotherboardProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Get Motherboard category
        $motherboardCategory = Category::where('slug', 'motherboard')->first();
        
        if (!$motherboardCategory) {
            $motherboardCategory = Category::create([
                'name' => 'Motherboard',
                'slug' => 'motherboard',
                'description' => 'Motherboard untuk PC',
                'icon' => 'developer_board',
            ]);
        }

        $motherboardProducts = [
            // INTEL LGA 1200 (Gen 10/11) - Gaming / Value
            [
                'name' => 'ASUS TUF Gaming B560M-Plus',
                'slug' => 'asus-tuf-gaming-b560m-plus',
                'description' => 'Form Factor: mATX | Fitur: PCIe 4.0 (dengan CPU Gen 11), 2x M.2 | Stabil, bagus untuk gaming mainstream | Socket: LGA 1200',
                'price' => 2000000,
                'stock' => 18,
                'category_id' => $motherboardCategory->id,
                'is_featured' => true,
                'rating' => 4.6,
                'specifications' => json_encode([
                    'socket' => 'LGA 1200',
                    'chipset' => 'B560',
                    'form_factor' => 'mATX',
                    'memory_type' => 'DDR4',
                    'pcie' => 'PCIe 4.0',
                    'm2_slots' => 2,
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'MSI B560M Pro-VDH',
                'slug' => 'msi-b560m-pro-vdh',
                'description' => 'Form Factor: mATX | Budget friendly, daily use | Socket: LGA 1200 | Cocok untuk office & gaming ringan',
                'price' => 1500000,
                'stock' => 22,
                'category_id' => $motherboardCategory->id,
                'is_featured' => false,
                'rating' => 4.3,
                'specifications' => json_encode([
                    'socket' => 'LGA 1200',
                    'chipset' => 'B560',
                    'form_factor' => 'mATX',
                    'memory_type' => 'DDR4',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                ]),
            ],

            // INTEL LGA 1700 (Gen 12/13) - Mid Gaming / All-Round
            [
                'name' => 'ASUS PRIME B660M-A D4',
                'slug' => 'asus-prime-b660m-a-d4',
                'description' => 'Memory: DDR4 | Value balance antara fitur & harga | Socket: LGA 1700 | Cocok untuk Gen 12/13 Intel',
                'price' => 2500000,
                'stock' => 25,
                'category_id' => $motherboardCategory->id,
                'is_featured' => true,
                'rating' => 4.7,
                'specifications' => json_encode([
                    'socket' => 'LGA 1700',
                    'chipset' => 'B660',
                    'form_factor' => 'mATX',
                    'memory_type' => 'DDR4',
                    'pcie' => 'PCIe 4.0',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'MSI PRO B660M-A DDR4',
                'slug' => 'msi-pro-b660m-a-ddr4',
                'description' => 'Memory: DDR4 | Stabil untuk kerja + gaming | Socket: LGA 1700 | Balanced performance',
                'price' => 2200000,
                'stock' => 20,
                'category_id' => $motherboardCategory->id,
                'is_featured' => false,
                'rating' => 4.5,
                'specifications' => json_encode([
                    'socket' => 'LGA 1700',
                    'chipset' => 'B660',
                    'form_factor' => 'mATX',
                    'memory_type' => 'DDR4',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                ]),
            ],

            // INTEL LGA 1700 - Future Proof / Streaming / Editing
            [
                'name' => 'ASRock B760 Steel Legend',
                'slug' => 'asrock-b760-steel-legend',
                'description' => 'Fitur: Built-in heatsink + airflow optimized | Socket: LGA 1700 | Future proof untuk Gen 13/14',
                'price' => 3000000,
                'stock' => 15,
                'category_id' => $motherboardCategory->id,
                'is_featured' => true,
                'rating' => 4.8,
                'specifications' => json_encode([
                    'socket' => 'LGA 1700',
                    'chipset' => 'B760',
                    'form_factor' => 'ATX',
                    'memory_type' => 'DDR4',
                    'pcie' => 'PCIe 4.0',
                    'use_case' => 'Editing',
                    'tier' => 'Future Proof',
                ]),
            ],

            // AMD AM4 (Ryzen 3000/5000) - Budget / Office / Gaming Ringan
            [
                'name' => 'Gigabyte B450M DS3H',
                'slug' => 'gigabyte-b450m-ds3h',
                'description' => 'Form Factor: mATX | Murah, cocok untuk daily use | Socket: AM4 | Support Ryzen 3000/5000',
                'price' => 1400000,
                'stock' => 28,
                'category_id' => $motherboardCategory->id,
                'is_featured' => false,
                'rating' => 4.2,
                'specifications' => json_encode([
                    'socket' => 'AM4',
                    'chipset' => 'B450',
                    'form_factor' => 'mATX',
                    'memory_type' => 'DDR4',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'ASRock B450 Pro4',
                'slug' => 'asrock-b450-pro4',
                'description' => 'Form Factor: ATX | Performa stabil untuk Ryzen 3/5 | Socket: AM4 | Reliable daily driver',
                'price' => 1500000,
                'stock' => 24,
                'category_id' => $motherboardCategory->id,
                'is_featured' => false,
                'rating' => 4.4,
                'specifications' => json_encode([
                    'socket' => 'AM4',
                    'chipset' => 'B450',
                    'form_factor' => 'ATX',
                    'memory_type' => 'DDR4',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                ]),
            ],

            // AMD AM4 - Gaming Mid / Editing
            [
                'name' => 'MSI B550M Pro-VDH',
                'slug' => 'msi-b550m-pro-vdh',
                'description' => 'Fitur: PCIe 4.0 (untuk GPU & SSD) | Upgrade proof untuk GPU modern | Socket: AM4',
                'price' => 2300000,
                'stock' => 20,
                'category_id' => $motherboardCategory->id,
                'is_featured' => true,
                'rating' => 4.6,
                'specifications' => json_encode([
                    'socket' => 'AM4',
                    'chipset' => 'B550',
                    'form_factor' => 'mATX',
                    'memory_type' => 'DDR4',
                    'pcie' => 'PCIe 4.0',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                ]),
            ],
            [
                'name' => 'ASUS TUF Gaming B550-Plus',
                'slug' => 'asus-tuf-gaming-b550-plus',
                'description' => 'Fitur: VRM lebih kuat, heatsink baik | Stabil untuk intensive load | Socket: AM4 | PCIe 4.0 ready',
                'price' => 2800000,
                'stock' => 16,
                'category_id' => $motherboardCategory->id,
                'is_featured' => true,
                'rating' => 4.8,
                'specifications' => json_encode([
                    'socket' => 'AM4',
                    'chipset' => 'B550',
                    'form_factor' => 'ATX',
                    'memory_type' => 'DDR4',
                    'pcie' => 'PCIe 4.0',
                    'use_case' => 'Editing',
                    'tier' => 'Best Performance',
                ]),
            ],
        ];

        foreach ($motherboardProducts as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }

        $this->command->info('✅ Motherboard products seeded successfully!');
        $this->command->info('Total: ' . count($motherboardProducts) . ' motherboards added');
    }
}
