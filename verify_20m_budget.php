<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;

echo "\n=== VERIFIKASI REKOMENDASI UNTUK BUDGET 20 JUTA ===\n\n";

$budget = 20_000_000;

// Budget allocation untuk Gaming - Best Value
$allocations = [
    'processor' => ['percent' => 22, 'category' => 'Processor'],
    'gpu' => ['percent' => 35, 'category' => 'Graphics Card'],
    'motherboard' => ['percent' => 12, 'category' => 'Motherboard'],
    'ram' => ['percent' => 13, 'category' => 'Memory'],
    'storage' => ['percent' => 10, 'category' => 'Storage'],
    'psu' => ['percent' => 5, 'category' => 'Power Supply'],
    'casing' => ['percent' => 3, 'category' => 'Casing'],
];

$coreComponents = ['processor', 'motherboard', 'ram', 'storage', 'psu', 'casing'];

echo "Budget: Rp " . number_format($budget, 0, ',', '.') . "\n";
echo "Tujuan: Gaming - Best Value\n\n";

$totalAllocated = 0;
$missingComponents = [];
$allRecommendations = [];

foreach ($allocations as $component => $config) {
    $percent = $config['percent'];
    $categoryName = $config['category'];
    
    $allocated = $budget * ($percent / 100);
    $totalAllocated += $allocated;
    
    // Range ±15%
    $minPrice = $allocated * 0.85;
    $maxPrice = $allocated * 1.15;
    
    echo str_pad(strtoupper($component), 15) . ": ";
    echo str_pad($percent . "%", 5) . " = ";
    echo "Rp " . str_pad(number_format($allocated, 0, ',', '.'), 12, ' ', STR_PAD_LEFT);
    echo " (Range: Rp " . number_format($minPrice, 0, ',', '.') . " - Rp " . number_format($maxPrice, 0, ',', '.') . ")\n";
    
    // Cek produk di range ±15%
    $productsInRange = Product::whereHas('category', function ($query) use ($categoryName) {
            $query->where('name', 'LIKE', "%{$categoryName}%");
        })
        ->whereBetween('price', [$minPrice, $maxPrice])
        ->where('stock', '>', 0)
        ->count();
    
    $product = Product::whereHas('category', function ($query) use ($categoryName) {
            $query->where('name', 'LIKE', "%{$categoryName}%");
        })
        ->whereBetween('price', [$minPrice, $maxPrice])
        ->where('stock', '>', 0)
        ->orderByDesc('rating')
        ->orderByDesc('is_featured')
        ->first();
    
    if ($product) {
        echo "  ✅ TERSEDIA: " . $productsInRange . " produk | Rekomendasi: " . $product->name . " (Rp " . number_format($product->price, 0, ',', '.') . ")\n";
        $allRecommendations[$component] = $product;
    } else {
        echo "  ⚠️  TIDAK ADA di range ±15%\n";
        
        // Coba range lebih lebar (±30%)
        $widerMin = $allocated * 0.7;
        $widerMax = $allocated * 1.3;
        
        $widerProduct = Product::whereHas('category', function ($query) use ($categoryName) {
                $query->where('name', 'LIKE', "%{$categoryName}%");
            })
            ->whereBetween('price', [$widerMin, $widerMax])
            ->where('stock', '>', 0)
            ->orderByDesc('rating')
            ->orderByDesc('is_featured')
            ->first();
        
        if ($widerProduct) {
            echo "  ✅ FALLBACK (±30%): " . $widerProduct->name . " (Rp " . number_format($widerProduct->price, 0, ',', '.') . ")\n";
            $allRecommendations[$component] = $widerProduct;
        } else {
            // Coba terdekat
            $closestProduct = Product::whereHas('category', function ($query) use ($categoryName) {
                    $query->where('name', 'LIKE', "%{$categoryName}%");
                })
                ->where('stock', '>', 0)
                ->orderByRaw('ABS(price - ?) ASC', [$allocated])
                ->orderByDesc('rating')
                ->first();
            
            if ($closestProduct) {
                echo "  ✅ TERDEKAT: " . $closestProduct->name . " (Rp " . number_format($closestProduct->price, 0, ',', '.') . ")\n";
                $allRecommendations[$component] = $closestProduct;
            } else {
                echo "  ❌ TIDAK ADA PRODUK SAMA SEKALI!\n";
                if (in_array($component, $coreComponents)) {
                    $missingComponents[] = $component;
                }
            }
        }
    }
    
    echo "\n";
}

echo str_repeat("-", 80) . "\n";
echo "Total Alokasi: Rp " . number_format($totalAllocated, 0, ',', '.') . " (" . ($totalAllocated / $budget * 100) . "%)\n\n";

// Check core components
echo "=== KOMPONEN INTI (WAJIB) ===\n";
foreach ($coreComponents as $core) {
    if (isset($allRecommendations[$core])) {
        echo "✅ " . strtoupper($core) . ": " . $allRecommendations[$core]->name . "\n";
    } else {
        echo "❌ " . strtoupper($core) . ": TIDAK ADA REKOMENDASI!\n";
    }
}

if (empty($missingComponents)) {
    echo "\n✅ SEMUA KOMPONEN INTI MEMILIKI REKOMENDASI!\n";
} else {
    echo "\n❌ KOMPONEN INTI YANG HILANG: " . implode(', ', $missingComponents) . "\n";
    echo "⚠️  PERLU MENAMBAH PRODUK DI KATEGORI INI!\n";
}

// Calculate total build cost
$totalBuildCost = 0;
echo "\n=== TOTAL ESTIMASI BUILD ===\n";
foreach ($allRecommendations as $component => $product) {
    $totalBuildCost += $product->price;
}
echo "Total: Rp " . number_format($totalBuildCost, 0, ',', '.') . "\n";
echo "Budget: Rp " . number_format($budget, 0, ',', '.') . "\n";
$difference = $budget - $totalBuildCost;
if ($difference >= 0) {
    echo "Sisa: Rp " . number_format($difference, 0, ',', '.') . " ✅\n";
} else {
    echo "Kelebihan: Rp " . number_format(abs($difference), 0, ',', '.') . " ⚠️\n";
}

echo "\n";
