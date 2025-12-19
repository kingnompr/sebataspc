# Smart PC Builder - Implementation Documentation

## 📋 Overview

Smart PC Builder adalah fitur intelligent PC configurator yang secara otomatis merekomendasikan komponen PC berdasarkan:
- **Budget Total** (Rp 5.000.000 - Rp 50.000.000)
- **Use Case** (Gaming / Office / Editing)
- **Tier Strategy** (Best Performance / Best Value / Future Proof)

## 🎯 Features

### 1. Budget Allocation Algorithm
Sistem mengalokasikan budget secara otomatis ke setiap komponen berdasarkan use case dan tier:

#### Gaming Use Case
- **Best Performance**: GPU 40%, CPU 20%, RAM 12%, Storage 10%, Motherboard 10%, PSU 5%, Casing 3%
- **Best Value**: GPU 35%, CPU 22%, RAM 15%, Storage 12%, Motherboard 8%, PSU 5%, Casing 3%
- **Future Proof**: GPU 30%, CPU 25%, RAM 15%, Storage 12%, Motherboard 10%, PSU 5%, Casing 3%

#### Office Use Case
- **Best Performance**: CPU 32%, RAM 22%, Storage 22%, Motherboard 12%, PSU 7%, Casing 5%
- **Best Value**: CPU 28%, RAM 20%, Storage 20%, Motherboard 15%, PSU 10%, Casing 7%
- **Future Proof**: CPU 30%, RAM 18%, Storage 18%, Motherboard 18%, PSU 10%, Casing 6%

#### Editing Use Case
- **Best Performance**: CPU 38%, GPU 15%, RAM 28%, Storage 10%, Motherboard 5%, PSU 3%, Casing 1%
- **Best Value**: CPU 35%, GPU 12%, RAM 25%, Storage 15%, Motherboard 7%, PSU 4%, Casing 2%
- **Future Proof**: CPU 32%, GPU 10%, RAM 25%, Storage 18%, Motherboard 8%, PSU 5%, Casing 2%

### 2. Smart Recommendation Engine
- Query produk berdasarkan kategori komponen
- Filter harga dalam range ±15% dari budget dialokasikan
- Prioritas produk dengan rating tinggi dan featured
- Menampilkan produk alternatif jika tidak ada yang match persis

### 3. Component Categories

#### Core Components (Wajib)
1. **Processor (CPU)** - Otak dari PC
2. **Motherboard** - Menghubungkan semua komponen
3. **RAM (Memory)** - Penunjang kecepatan multitasking
4. **Storage (SSD/HDD)** - Penyimpanan data
5. **Power Supply (PSU)** - Sumber daya listrik
6. **Casing** - Wadah fisik komponen

#### Optional Components (Opsional)
1. **Graphics Card (GPU)** - Wajib untuk gaming/editing
2. **CPU Cooler** - Pendingin tambahan

### 4. User Interface Features
- **Sticky Header**: Navigasi tetap accessible
- **Sticky Summary Bar**: Menampilkan total estimasi, sisa budget, dan tier
- **Real-time Budget Display**: Update otomatis saat slider budget digeser
- **Active State Indicators**: Visual feedback untuk pilihan use case dan tier
- **Product Cards**: Menampilkan gambar, nama, harga, dan rating produk
- **Budget Allocation Display**: Menunjukkan budget yang dialokasikan per komponen

## 🔧 Technical Implementation

### Route
```php
Route::get('/pc-builds/custom-builder', [PcBuildController::class, 'customBuilder'])
    ->name('pc-builds.custom-builder');
```

### Controller Methods

#### 1. `customBuilder(Request $request)`
Main method yang menangani request dan mengembalikan view dengan recommendations.

**Parameters:**
- `budget` (default: 15000000)
- `use_case` (default: 'Gaming')
- `tier` (default: 'Best Performance')
- `components` (array of selected component IDs)

**Returns:**
```php
return view('pc-builds.builder', [
    'budget' => $budget,
    'useCase' => $useCase,
    'tier' => $tier,
    'componentDetails' => $componentDetails,
    'totalPrice' => $totalPrice,
    'remainingBudget' => $remainingBudget,
]);
```

#### 2. `getBudgetAllocation(string $useCase, string $tier)`
Mengembalikan percentage allocation untuk semua komponen.

**Returns:**
```php
[
    'Gaming' => [
        'Best Performance' => [
            'processor' => 20,
            'gpu' => 40,
            'ram' => 12,
            // ...
        ]
    ]
]
```

#### 3. `getSmartRecommendations(int $budget, array $allocation)`
Query produk berdasarkan budget yang dialokasikan.

**Logic:**
```php
// Calculate allocated budget
$allocatedBudget = $budget * ($allocation[$type] / 100);

// Price range with tolerance
$minPrice = $allocatedBudget * 0.85;
$maxPrice = $allocatedBudget * 1.15;

// Query products
Product::whereHas('category', function ($query) use ($categoryName) {
    $query->where('name', 'LIKE', "%{$categoryName}%");
})
->whereBetween('price', [$minPrice, $maxPrice])
->where('stock', '>', 0)
->orderByDesc('rating')
->orderByDesc('is_featured')
->first();
```

### Component Mapping
```php
$componentMapping = [
    'processor' => 'CPU',
    'motherboard' => 'Motherboard',
    'ram' => 'RAM',
    'storage' => 'SSD',
    'psu' => 'PSU',
    'casing' => 'Casing',
    'gpu' => 'VGA',
    'cpu_cooler' => 'Cooler',
];
```

## 🎨 View Structure

### Blade Template: `resources/views/pc-builds/builder.blade.php`

**Key Sections:**
1. **Header** (Sticky) - Navigation with cart and profile
2. **Summary Bar** (Sticky) - Total price, remaining budget, tier display
3. **Main Content**:
   - Core Components Section (6 items with WAJIB badge)
   - Optional Components Section (2 items with OPSIONAL badge)
4. **Sidebar** (Sticky):
   - Budget slider (5M - 50M)
   - Use Case selector (Gaming/Office/Editing)
   - Tier selector (Best Performance/Best Value/Future Proof)
   - Apply button

### Component Card Display
```blade
@if($product)
    <!-- Show recommended product -->
    <div class="product-card">
        <img src="{{ $product->image_url }}" />
        <p>{{ $product->name }}</p>
        <p>Rp {{ number_format($product->price) }}</p>
        <span>★ {{ $product->rating }}</span>
    </div>
@else
    <!-- Show placeholder -->
    <p>Tidak ada rekomendasi di budget ini</p>
@endif
```

## 📊 Budget Recommendation Guidelines

### Budget Ranges by Use Case

#### Office Work
- **Minimum**: Rp 5.000.000
- **Recommended**: Rp 7.000.000 - Rp 12.000.000
- **Premium**: Rp 15.000.000+

#### Gaming
- **Minimum**: Rp 10.000.000
- **Recommended**: Rp 15.000.000 - Rp 25.000.000
- **Premium**: Rp 30.000.000+

#### Video Editing
- **Minimum**: Rp 12.000.000
- **Recommended**: Rp 18.000.000 - Rp 35.000.000
- **Premium**: Rp 40.000.000+

## 🔍 Compatibility Rules (Future Implementation)

### CPU Socket Compatibility
```php
// Intel
'LGA1700' => ['12th Gen', '13th Gen', '14th Gen']

// AMD
'AM5' => ['Ryzen 7000 Series']
'AM4' => ['Ryzen 5000 Series', 'Ryzen 3000 Series']
```

### RAM Type Compatibility
```php
'DDR5' => ['LGA1700 (12th Gen+)', 'AM5']
'DDR4' => ['LGA1200', 'AM4']
```

### PSU Wattage Calculation
```php
$requiredWattage = (CPU_TDP + GPU_TDP + 100W) * 1.2;
```

Example:
- Intel i5-13600K (125W TDP)
- RTX 4060 Ti (160W TDP)
- Other components (100W estimated)
- Required: (125 + 160 + 100) * 1.2 = **462W** → Recommend **550W PSU**

## 🚀 Future Enhancements

### Phase 2: Component Selection Modal
- [ ] Modal untuk memilih alternatif produk
- [ ] Filter berdasarkan brand, spesifikasi
- [ ] Comparison view untuk 2-3 produk
- [ ] User review integration

### Phase 3: Compatibility Validation
- [ ] Real-time socket matching (CPU-Motherboard)
- [ ] RAM type validation (DDR4/DDR5)
- [ ] PSU wattage calculator
- [ ] Casing size compatibility (ATX/mATX/ITX)

### Phase 4: Save & Share
- [ ] Save custom build to user account
- [ ] Share build via link
- [ ] Build templates/presets
- [ ] Community builds showcase

### Phase 5: Advanced Features
- [ ] AI-powered optimization suggestions
- [ ] Price trend analysis
- [ ] Performance benchmarking integration
- [ ] Part availability notifications
- [ ] Build difficulty rating

## 📝 Usage Example

### Example 1: Gaming PC - Rp 15.000.000
**Use Case**: Gaming  
**Tier**: Best Performance  
**Budget Allocation**:
- GPU: Rp 6.000.000 (40%)
- CPU: Rp 3.000.000 (20%)
- RAM: Rp 1.800.000 (12%)
- Storage: Rp 1.500.000 (10%)
- Motherboard: Rp 1.500.000 (10%)
- PSU: Rp 750.000 (5%)
- Casing: Rp 450.000 (3%)

**Recommended Build**:
- GPU: RTX 4060 Ti
- CPU: Intel Core i5-13600K
- RAM: 16GB DDR5
- Storage: 512GB NVMe Gen4
- Motherboard: B760 Chipset
- PSU: 650W 80+ Bronze
- Casing: Mid Tower ATX

### Example 2: Office PC - Rp 8.000.000
**Use Case**: Office  
**Tier**: Best Value  
**Budget Allocation**:
- CPU: Rp 2.240.000 (28%)
- RAM: Rp 1.600.000 (20%)
- Storage: Rp 1.600.000 (20%)
- Motherboard: Rp 1.200.000 (15%)
- PSU: Rp 800.000 (10%)
- Casing: Rp 560.000 (7%)

**Recommended Build**:
- CPU: Intel Core i3-13100 / Ryzen 5 5600G
- RAM: 16GB DDR4
- Storage: 512GB NVMe SSD
- Motherboard: B660 / B550
- PSU: 500W 80+ Bronze
- Casing: Micro ATX Case
- GPU: Integrated Graphics

### Example 3: Editing PC - Rp 25.000.000
**Use Case**: Editing  
**Tier**: Best Performance  
**Budget Allocation**:
- CPU: Rp 9.500.000 (38%)
- RAM: Rp 7.000.000 (28%)
- GPU: Rp 3.750.000 (15%)
- Storage: Rp 2.500.000 (10%)
- Motherboard: Rp 1.250.000 (5%)
- PSU: Rp 750.000 (3%)
- Casing: Rp 250.000 (1%)

**Recommended Build**:
- CPU: Intel Core i7-13700K / Ryzen 9 7900X
- RAM: 32GB DDR5 (2x16GB)
- GPU: RTX 4060 / RX 7600
- Storage: 1TB NVMe Gen4 + 2TB HDD
- Motherboard: Z790 / X670
- PSU: 750W 80+ Gold
- Casing: Mid Tower

## 🎓 Key Learnings

### Design Decisions
1. **Percentage-based allocation**: Scalable untuk any budget amount
2. **±15% price tolerance**: Balance between strict budget dan product availability
3. **Prioritize rating & featured**: Ensure quality recommendations
4. **Separate core & optional**: Clear user guidance
5. **Real-time UI updates**: Better user experience

### Performance Optimizations
1. Use `whereHas()` untuk efficient category filtering
2. Limit results dengan `first()` untuk faster queries
3. Eager load relationships jika diperlukan
4. Cache budget allocation arrays (future optimization)

### UX Principles
1. **Progressive disclosure**: Show recommendations first, allow manual override
2. **Visual hierarchy**: Use badges, colors, typography untuk guide user
3. **Instant feedback**: Real-time budget updates, active states
4. **Error tolerance**: Show placeholders when no recommendations found
5. **Mobile-first**: Responsive grid dan sticky elements

## 📚 References

- [SMART_PC_BUILDER_LOGIC.md](SMART_PC_BUILDER_LOGIC.md) - Complete budget allocation tables
- [routes/web.php](routes/web.php) - Route definition
- [app/Http/Controllers/PcBuildController.php](app/Http/Controllers/PcBuildController.php) - Backend logic
- [resources/views/pc-builds/builder.blade.php](resources/views/pc-builds/builder.blade.php) - Frontend UI

---

**Created**: December 2025  
**Version**: 1.0  
**Status**: Active Development
