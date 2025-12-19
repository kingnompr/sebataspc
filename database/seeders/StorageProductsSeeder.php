<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class StorageProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Get Storage category
        $storageCategory = Category::where('slug', 'storage')->first();
        
        if (!$storageCategory) {
            $storageCategory = Category::create([
                'name' => 'Storage',
                'slug' => 'storage',
                'description' => 'Storage SSD & HDD untuk PC',
                'icon' => 'hard_drive',
            ]);
        }

        $storageProducts = [
            // NVMe SSD - Paling Cepat
            [
                'name' => 'Kingston NV2 500GB NVMe',
                'slug' => 'kingston-nv2-500gb-nvme',
                'description' => 'Capacity: 500GB | Type: NVMe Gen3 | Value terbaik, kecepatan baca-tulis baik | Cocok untuk gaming & sistem cepat',
                'price' => 450000,
                'stock' => 50,
                'category_id' => $storageCategory->id,
                'is_featured' => true,
                'rating' => 4.5,
                'specifications' => json_encode([
                    'capacity' => '500GB',
                    'type' => 'NVMe SSD',
                    'interface' => 'M.2 NVMe',
                    'generation' => 'Gen3',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'ADATA XPG SX8200 Pro 1TB',
                'slug' => 'adata-xpg-sx8200-pro-1tb',
                'description' => 'Capacity: 1TB | Type: NVMe Gen3 | NVMe kelas gaming & editing ringan | High performance for daily use',
                'price' => 1150000,
                'stock' => 35,
                'category_id' => $storageCategory->id,
                'is_featured' => true,
                'rating' => 4.7,
                'specifications' => json_encode([
                    'capacity' => '1TB',
                    'type' => 'NVMe SSD',
                    'interface' => 'M.2 NVMe',
                    'generation' => 'Gen3',
                    'use_case' => 'Editing',
                    'tier' => 'Best Performance',
                ]),
            ],
            [
                'name' => 'WD Black SN770 1TB',
                'slug' => 'wd-black-sn770-1tb',
                'description' => 'Capacity: 1TB | Type: NVMe Gen4 | Performa NVMe tinggi, cocok gaming & kerja berat | Premium gaming SSD',
                'price' => 1300000,
                'stock' => 30,
                'category_id' => $storageCategory->id,
                'is_featured' => true,
                'rating' => 4.8,
                'specifications' => json_encode([
                    'capacity' => '1TB',
                    'type' => 'NVMe SSD',
                    'interface' => 'M.2 NVMe',
                    'generation' => 'Gen4',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                ]),
            ],
            [
                'name' => 'Samsung 980 PRO 1TB',
                'slug' => 'samsung-980-pro-1tb',
                'description' => 'Capacity: 1TB | Type: NVMe Gen4 | Top-tier NVMe untuk heavy workload | Professional grade performance',
                'price' => 2000000,
                'stock' => 20,
                'category_id' => $storageCategory->id,
                'is_featured' => true,
                'rating' => 5.0,
                'specifications' => json_encode([
                    'capacity' => '1TB',
                    'type' => 'NVMe SSD',
                    'interface' => 'M.2 NVMe',
                    'generation' => 'Gen4',
                    'use_case' => 'Editing',
                    'tier' => 'Future Proof',
                ]),
            ],

            // SATA SSD - Budget & Kompatibel Luas
            [
                'name' => 'Kingston A400 480GB',
                'slug' => 'kingston-a400-480gb',
                'description' => 'Capacity: 480GB | Type: SATA SSD | Cepat dibanding HDD, pas untuk budget tight | Budget friendly upgrade',
                'price' => 480000,
                'stock' => 45,
                'category_id' => $storageCategory->id,
                'is_featured' => false,
                'rating' => 4.3,
                'specifications' => json_encode([
                    'capacity' => '480GB',
                    'type' => 'SATA SSD',
                    'interface' => 'SATA III',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'Crucial MX500 1TB',
                'slug' => 'crucial-mx500-1tb',
                'description' => 'Capacity: 1TB | Type: SATA SSD | Stabil & tahan lama | Reliable SATA SSD with excellent endurance',
                'price' => 1000000,
                'stock' => 40,
                'category_id' => $storageCategory->id,
                'is_featured' => true,
                'rating' => 4.6,
                'specifications' => json_encode([
                    'capacity' => '1TB',
                    'type' => 'SATA SSD',
                    'interface' => 'SATA III',
                    'use_case' => 'Office',
                    'tier' => 'Best Performance',
                ]),
            ],

            // HDD - Penyimpanan Kapasitas Besar
            [
                'name' => 'Seagate Barracuda 1TB 7200rpm',
                'slug' => 'seagate-barracuda-1tb-7200rpm',
                'description' => 'Capacity: 1TB | Type: HDD | Speed: 7200rpm | Good for data storage, film, game library | Budget storage solution',
                'price' => 550000,
                'stock' => 35,
                'category_id' => $storageCategory->id,
                'is_featured' => false,
                'rating' => 4.4,
                'specifications' => json_encode([
                    'capacity' => '1TB',
                    'type' => 'HDD',
                    'rpm' => '7200',
                    'interface' => 'SATA III',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                ]),
            ],
            [
                'name' => 'WD Blue 2TB 5400rpm',
                'slug' => 'wd-blue-2tb-5400rpm',
                'description' => 'Capacity: 2TB | Type: HDD | Speed: 5400rpm | Large capacity for documents and media | Economical mass storage',
                'price' => 850000,
                'stock' => 30,
                'category_id' => $storageCategory->id,
                'is_featured' => false,
                'rating' => 4.5,
                'specifications' => json_encode([
                    'capacity' => '2TB',
                    'type' => 'HDD',
                    'rpm' => '5400',
                    'interface' => 'SATA III',
                    'use_case' => 'Office',
                    'tier' => 'Best Value',
                ]),
            ],
        ];

        foreach ($storageProducts as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }

        $this->command->info('✅ Storage products seeded successfully!');
        $this->command->info('Total: ' . count($storageProducts) . ' storage devices added');
        $this->command->info('📌 NVMe SSD: 4 products | SATA SSD: 2 products | HDD: 2 products');
    }
}
