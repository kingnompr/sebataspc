<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class PsuProductsSeeder extends Seeder
{
    public function run(): void
    {
        $psuCategory = Category::where('slug', 'psu')->first();
        
        if (!$psuCategory) {
            $this->command->error('❌ PSU category not found! Please run categories seeder first.');
            return;
        }

        $psus = [
            // 🔹 PSU Entry – Gaming & Office Ringan
            [
                'name' => 'Corsair CV550 550W 80+ Bronze',
                'slug' => 'corsair-cv550-550w-bronze',
                'description' => 'PSU stabil untuk build ringan tanpa GPU besar. Cukup untuk build 300-400W dengan proteksi lengkap.',
                'price' => 800000,
                'stock' => 30,
                'category_id' => $psuCategory->id,
                'image' => 'products/psu-corsair-cv550.jpg',
                'rating' => 4.4,
                'specifications' => [
                    'wattage' => '550W',
                    'efficiency' => '80+ Bronze',
                    'modular' => 'Non-Modular',
                    'fan_size' => '120mm',
                    'pfc' => 'Active PFC',
                    'protections' => 'OVP, UVP, OPP, SCP, OTP',
                    'connector_24pin' => '1x 24-pin ATX',
                    'connector_cpu' => '1x 4+4-pin EPS12V',
                    'connector_pcie' => '2x 6+2-pin PCIe',
                    'connector_sata' => '6x SATA',
                    'connector_molex' => '3x Molex',
                    'recommended_for' => 'Entry Gaming, Office',
                    'estimated_system_power' => '300-400W',
                    'use_case' => 'Gaming, Office',
                    'tier' => 'Best Value',
                    'warranty' => '3 Years'
                ]
            ],
            [
                'name' => 'Cooler Master MWE 550 Bronze V2',
                'slug' => 'coolermaster-mwe550-bronze',
                'description' => 'Value terbaik untuk build entry-level dengan efisiensi 80+ Bronze. Hemat budget tanpa korbankan kualitas.',
                'price' => 750000,
                'stock' => 35,
                'category_id' => $psuCategory->id,
                'image' => 'products/psu-cm-mwe550.jpg',
                'rating' => 4.3,
                'specifications' => [
                    'wattage' => '550W',
                    'efficiency' => '80+ Bronze',
                    'modular' => 'Non-Modular',
                    'fan_size' => '120mm HDB Fan',
                    'pfc' => 'Active PFC',
                    'protections' => 'OVP, OPP, SCP, OTP',
                    'connector_24pin' => '1x 24-pin ATX',
                    'connector_cpu' => '1x 4+4-pin EPS12V',
                    'connector_pcie' => '2x 6+2-pin PCIe',
                    'connector_sata' => '6x SATA',
                    'connector_molex' => '3x Molex',
                    'recommended_for' => 'Entry Gaming, Budget Build',
                    'estimated_system_power' => '300-400W',
                    'use_case' => 'Gaming, Office',
                    'tier' => 'Best Value',
                    'warranty' => '5 Years'
                ]
            ],

            // 🔷 PSU Mid Range – Gaming 1080p / Build Standard
            [
                'name' => 'Seasonic S12III 650W 80+ Bronze',
                'slug' => 'seasonic-s12iii-650w-bronze',
                'description' => 'Brand tepercaya dengan proteksi lengkap untuk gaming 1080p. Cocok untuk GTX 1650 - RTX 3060.',
                'price' => 1250000,
                'stock' => 25,
                'category_id' => $psuCategory->id,
                'image' => 'products/psu-seasonic-s12iii.jpg',
                'rating' => 4.6,
                'specifications' => [
                    'wattage' => '650W',
                    'efficiency' => '80+ Bronze',
                    'modular' => 'Non-Modular',
                    'fan_size' => '120mm Silent Fan',
                    'pfc' => 'Active PFC',
                    'protections' => 'OVP, UVP, OPP, SCP, OTP, SIP',
                    'connector_24pin' => '1x 24-pin ATX',
                    'connector_cpu' => '1x 4+4-pin EPS12V',
                    'connector_pcie' => '2x 6+2-pin PCIe',
                    'connector_sata' => '6x SATA',
                    'connector_molex' => '3x Molex',
                    'recommended_for' => 'Mid-Range Gaming (GTX 1650 - RTX 3060)',
                    'estimated_system_power' => '400-500W',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                    'warranty' => '5 Years'
                ]
            ],
            [
                'name' => 'Corsair TX650M 650W 80+ Gold Semi-Modular',
                'slug' => 'corsair-tx650m-650w-gold',
                'description' => 'Efisiensi tinggi dengan kabel modular untuk manajemen kabel lebih rapi. Ideal untuk mid-tier gaming.',
                'price' => 1900000,
                'stock' => 20,
                'category_id' => $psuCategory->id,
                'image' => 'products/psu-corsair-tx650m.jpg',
                'rating' => 4.7,
                'specifications' => [
                    'wattage' => '650W',
                    'efficiency' => '80+ Gold',
                    'modular' => 'Semi-Modular',
                    'fan_size' => '120mm Rifle Bearing Fan',
                    'pfc' => 'Active PFC',
                    'protections' => 'OVP, UVP, OPP, SCP, OTP',
                    'connector_24pin' => '1x 24-pin ATX',
                    'connector_cpu' => '1x 4+4-pin EPS12V',
                    'connector_pcie' => '2x 6+2-pin PCIe',
                    'connector_sata' => '6x SATA',
                    'connector_molex' => '4x Molex',
                    'recommended_for' => 'Gaming 1080p (RX 6600 - RTX 3060)',
                    'estimated_system_power' => '400-500W',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance',
                    'warranty' => '7 Years'
                ]
            ],

            // 🔥 PSU High-End – Gaming Kuat / Editing Berat
            [
                'name' => 'EVGA SuperNOVA 750 G5 750W 80+ Gold',
                'slug' => 'evga-supernova-750g5-gold',
                'description' => 'Power headroom bagus untuk GPU high-end dan CPU powerful. Stabil untuk RTX 3070/RX 6800 XT.',
                'price' => 2500000,
                'stock' => 18,
                'category_id' => $psuCategory->id,
                'image' => 'products/psu-evga-750g5.jpg',
                'rating' => 4.8,
                'specifications' => [
                    'wattage' => '750W',
                    'efficiency' => '80+ Gold',
                    'modular' => 'Full-Modular',
                    'fan_size' => '135mm Fluid Dynamic Bearing',
                    'pfc' => 'Active PFC',
                    'protections' => 'OVP, UVP, OPP, SCP, OTP, OCP',
                    'connector_24pin' => '1x 24-pin ATX',
                    'connector_cpu' => '2x 4+4-pin EPS12V',
                    'connector_pcie' => '4x 6+2-pin PCIe',
                    'connector_sata' => '9x SATA',
                    'connector_molex' => '3x Molex',
                    'recommended_for' => 'High-End Gaming (RTX 3070, RX 6800 XT)',
                    'estimated_system_power' => '500-600W',
                    'use_case' => 'Gaming, Editing',
                    'tier' => 'Future Proof',
                    'warranty' => '10 Years'
                ]
            ],
            [
                'name' => 'Seasonic Focus GX-850 850W 80+ Gold',
                'slug' => 'seasonic-focus-gx850-gold',
                'description' => 'PSU semi-modular premium untuk enthusiast build. Headroom besar untuk upgrade dan multi-GPU.',
                'price' => 3000000,
                'stock' => 15,
                'category_id' => $psuCategory->id,
                'image' => 'products/psu-seasonic-focus-gx850.jpg',
                'rating' => 4.9,
                'specifications' => [
                    'wattage' => '850W',
                    'efficiency' => '80+ Gold',
                    'modular' => 'Full-Modular',
                    'fan_size' => '135mm Fluid Dynamic Bearing',
                    'pfc' => 'Active PFC',
                    'protections' => 'OVP, UVP, OPP, SCP, OTP, OCP',
                    'connector_24pin' => '1x 24-pin ATX',
                    'connector_cpu' => '2x 4+4-pin EPS12V',
                    'connector_pcie' => '4x 6+2-pin PCIe',
                    'connector_sata' => '8x SATA',
                    'connector_molex' => '4x Molex',
                    'recommended_for' => 'High-End Gaming, Workstation (Multi-GPU Support)',
                    'estimated_system_power' => '600-700W',
                    'use_case' => 'Gaming, Editing',
                    'tier' => 'Future Proof',
                    'warranty' => '10 Years'
                ]
            ],
        ];

        foreach ($psus as $psuData) {
            Product::updateOrCreate(
                ['slug' => $psuData['slug']],
                $psuData
            );
        }

        $this->command->info('✅ PSU products seeded successfully!');
        $this->command->info('Total: ' . count($psus) . ' power supplies added');
        
        $entryCount = collect($psus)->filter(fn($psu) => $psu['price'] <= 1000000)->count();
        $midCount = collect($psus)->filter(fn($psu) => $psu['price'] > 1000000 && $psu['price'] <= 2000000)->count();
        $highCount = collect($psus)->filter(fn($psu) => $psu['price'] > 2000000)->count();
        $this->command->info("📌 Entry-Level: {$entryCount} | Mid-Range: {$midCount} | High-End: {$highCount}");
        
        $bronzeCount = collect($psus)->filter(fn($psu) => str_contains($psu['specifications']['efficiency'], 'Bronze'))->count();
        $goldCount = collect($psus)->filter(fn($psu) => str_contains($psu['specifications']['efficiency'], 'Gold'))->count();
        $this->command->info("📌 80+ Bronze: {$bronzeCount} | 80+ Gold: {$goldCount}");
    }
}
