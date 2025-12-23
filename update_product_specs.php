<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "=== Updating Product Specifications ===\n\n";

$categories = Category::all();

foreach ($categories as $category) {
    echo "📁 Category: {$category->name}\n";
    $products = Product::where('category_id', $category->id)->get();
    
    foreach ($products as $product) {
        $specs = [];
        
        // Based on category, create appropriate specifications
        switch ($category->slug) {
            case 'cpu':
                $specs = [
                    'cores' => $product->name, // Will be replaced with actual data
                    'socket' => 'LGA1700', // Default, should be actual
                    'base_clock' => 'N/A',
                    'boost_clock' => 'N/A',
                    'cache' => 'N/A',
                    'tdp' => 'N/A',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance'
                ];
                break;
                
            case 'gpu':
                $specs = [
                    'gpu_model' => $product->name,
                    'vram' => 'N/A',
                    'memory_type' => 'GDDR6',
                    'base_clock' => 'N/A',
                    'boost_clock' => 'N/A',
                    'cuda_cores' => 'N/A',
                    'tdp' => 'N/A',
                    'power_connector' => 'N/A',
                    'resolution_target' => '1080p',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance'
                ];
                break;
                
            case 'motherboard':
                $specs = [
                    'socket' => 'LGA1700',
                    'chipset' => 'N/A',
                    'form_factor' => 'ATX',
                    'memory_slots' => '4',
                    'max_memory' => '128GB',
                    'pcie_slots' => 'N/A',
                    'm2_slots' => '2',
                    'sata_ports' => '4',
                    'usb_ports' => 'N/A',
                    'networking' => 'Gigabit LAN',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance'
                ];
                break;
                
            case 'ram':
                // Check if product has existing proper specs
                $existingSpecs = $product->specifications;
                if (is_array($existingSpecs) && isset($existingSpecs['capacity'])) {
                    continue 2; // Skip this product, already has good specs
                }
                
                $specs = [
                    'capacity' => '16GB',
                    'type' => 'DDR4',
                    'speed' => '3200MHz',
                    'channels' => 'Dual (2x8GB)',
                    'latency' => 'CL16',
                    'voltage' => '1.35V',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance'
                ];
                break;
                
            case 'storage':
                $specs = [
                    'capacity' => '1TB',
                    'interface' => 'NVMe PCIe 4.0',
                    'form_factor' => 'M.2 2280',
                    'read_speed' => 'N/A',
                    'write_speed' => 'N/A',
                    'nand_type' => 'TLC',
                    'controller' => 'N/A',
                    'dram_cache' => 'Yes',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Performance'
                ];
                break;
                
            case 'psu':
                $specs = [
                    'wattage' => '650W',
                    'efficiency' => '80+ Bronze',
                    'modular' => 'Semi-Modular',
                    'pfc' => 'Active PFC',
                    'fan_size' => '120mm',
                    'warranty' => '3 Years',
                    'protections' => 'OVP, OCP, OPP, SCP',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value'
                ];
                break;
                
            case 'case':
                $specs = [
                    'form_factor' => 'ATX Mid Tower',
                    'material' => 'Steel + Tempered Glass',
                    'motherboard_support' => 'ATX, Micro-ATX, Mini-ITX',
                    'expansion_slots' => '7',
                    'drive_bays_25' => '2',
                    'drive_bays_35' => '2',
                    'max_gpu_length' => '360mm',
                    'max_cpu_cooler_height' => '160mm',
                    'front_io' => 'USB 3.0, Audio',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value'
                ];
                break;
                
            case 'cooling':
                $specs = [
                    'cooler_type' => 'Air Cooler',
                    'fan_size' => '120mm',
                    'tdp_rating' => '150W',
                    'socket_support' => 'LGA1700, AM4, AM5',
                    'height' => 'N/A',
                    'noise_level' => 'N/A',
                    'rgb' => 'No',
                    'use_case' => 'Gaming',
                    'tier' => 'Best Value'
                ];
                break;
                
            default:
                continue 2; // Skip unknown categories
        }
        
        // Only update if specifications is empty or not properly structured
        $existingSpecs = $product->specifications;
        if (empty($existingSpecs) || !is_array($existingSpecs) || count($existingSpecs) < 3) {
            $product->update(['specifications' => $specs]); // Don't json_encode, model will handle it
            echo "  ✅ Updated: {$product->name}\n";
        } else {
            echo "  ⏭️  Skipped: {$product->name} (already has specs)\n";
        }
    }
    
    echo "\n";
}

echo "=== Done! ===\n";
