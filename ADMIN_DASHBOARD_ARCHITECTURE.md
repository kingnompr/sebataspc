# ARSITEKTUR DASHBOARD ADMIN - E-COMMERCE RAKIT PC

## 📋 OVERVIEW

Dashboard Admin untuk sistem e-commerce rakit PC dengan fokus pada **Manajemen Produk**, **Kompatibilitas Komponen**, dan **Order Management**.

---

## 🗄️ SKEMA DATABASE SQL

### 1. Tabel `products` (Enhanced)

```sql
CREATE TABLE products (
    -- Existing fields
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    category_id BIGINT,
    name VARCHAR(255),
    slug VARCHAR(255) UNIQUE,
    description TEXT,
    specifications JSON,
    price DECIMAL(12,2),
    stock INT DEFAULT 0,
    image VARCHAR(255),
    rating DECIMAL(3,2),
    is_featured BOOLEAN DEFAULT FALSE,
    is_recommended BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    -- NEW: General Product Info
    brand VARCHAR(255),                    -- Intel, AMD, NVIDIA, Corsair, etc.
    model VARCHAR(255),                    -- i5-12400F, RTX 3070, etc.
    sku VARCHAR(255) UNIQUE,               -- SKU untuk inventory
    
    -- NEW: CPU/Motherboard Compatibility
    socket VARCHAR(100),                   -- LGA1700, LGA1200, AM4, AM5
    chipset VARCHAR(100),                  -- Z690, B550, H610, etc.
    
    -- NEW: RAM Compatibility
    memory_type VARCHAR(50),               -- DDR4, DDR5
    memory_speed INT,                      -- 3200, 3600, 6000 (MHz)
    memory_slots INT,                      -- For motherboards: 2, 4
    
    -- NEW: Storage Compatibility
    interface VARCHAR(100),                -- NVMe, SATA, M.2, PCIe 4.0
    capacity_gb INT,                       -- 512, 1024, 2048 (GB)
    
    -- NEW: Power & Thermal
    tdp INT,                               -- CPU/GPU power consumption (Watts)
    wattage INT,                           -- PSU wattage (450, 650, 850W)
    efficiency_rating VARCHAR(50),         -- 80+ Bronze, Gold, Platinum
    
    -- NEW: Physical Dimensions
    form_factor VARCHAR(50),               -- ATX, mATX, Mini-ITX, Mid-Tower
    length_mm INT,                         -- GPU/Casing length
    height_mm INT,                         -- GPU/Casing height
    
    -- NEW: Compatibility Arrays
    compatible_sockets JSON,               -- ["LGA1700", "LGA1200"] for coolers
    supported_memory_types JSON,           -- ["DDR4", "DDR5"] for motherboards
    rgb_support BOOLEAN DEFAULT FALSE,
    
    -- NEW: Stock Management
    min_stock_alert INT DEFAULT 5,         -- Alert ketika stock <= nilai ini
    last_restock_date DATE,                -- Tracking restock terakhir
    
    -- NEW: Pricing Management
    cost_price DECIMAL(12,2),              -- Harga modal/beli
    markup_percentage DECIMAL(5,2),        -- % keuntungan (20%, 30%)
    
    INDEX idx_category (category_id),
    INDEX idx_brand (brand),
    INDEX idx_socket (socket),
    INDEX idx_stock (stock),
    INDEX idx_price (price),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
```

**Contoh Data:**

```sql
-- CPU Example
INSERT INTO products VALUES (
    id: 1,
    category_id: 1,
    name: 'Intel Core i5-12400F',
    brand: 'Intel',
    model: 'i5-12400F',
    sku: 'CPU-INTEL-12400F',
    socket: 'LGA1700',
    tdp: 65,
    price: 2700000,
    cost_price: 2400000,
    markup_percentage: 12.50,
    ...
);

-- Motherboard Example
INSERT INTO products VALUES (
    id: 5,
    category_id: 3,
    name: 'MSI MAG B660M Mortar',
    brand: 'MSI',
    model: 'B660M Mortar',
    sku: 'MOBO-MSI-B660M',
    socket: 'LGA1700',
    chipset: 'B660',
    memory_slots: 4,
    supported_memory_types: '["DDR4"]',
    form_factor: 'mATX',
    ...
);

-- PSU Example
INSERT INTO products VALUES (
    id: 12,
    category_id: 6,
    name: 'Cooler Master MWE Gold 650',
    brand: 'Cooler Master',
    sku: 'PSU-CM-MWE650G',
    wattage: 650,
    efficiency_rating: '80+ Gold',
    ...
);
```

---

### 2. Tabel `compatibility_rules`

```sql
CREATE TABLE compatibility_rules (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    rule_name VARCHAR(255),                -- "CPU-Motherboard Socket Match"
    component_type_a VARCHAR(100),         -- "Processor"
    component_type_b VARCHAR(100),         -- "Motherboard"
    rule_type VARCHAR(100),                -- socket_match, memory_type_match, tdp_check
    rule_conditions JSON,                  -- Flexible conditions
    error_message TEXT,                    -- "Socket tidak kompatibel!"
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEX idx_components (component_type_a, component_type_b)
);
```

**Contoh Data:**

```sql
-- Rule 1: CPU-Motherboard Socket Match
INSERT INTO compatibility_rules VALUES (
    rule_name: 'CPU-Motherboard Socket Match',
    component_type_a: 'Processor',
    component_type_b: 'Motherboard',
    rule_type: 'socket_match',
    rule_conditions: '{
        "field_a": "socket",
        "field_b": "socket",
        "operator": "equals",
        "required": true
    }',
    error_message: 'Socket CPU dan Motherboard harus sama! (LGA1700 vs AM5)',
    is_active: TRUE
);

-- Rule 2: Motherboard-RAM Memory Type Match
INSERT INTO compatibility_rules VALUES (
    rule_name: 'Motherboard-RAM Memory Type',
    component_type_a: 'Motherboard',
    component_type_b: 'Memory',
    rule_type: 'memory_type_match',
    rule_conditions: '{
        "field_a": "supported_memory_types",
        "field_b": "memory_type",
        "operator": "in_array",
        "required": true
    }',
    error_message: 'Motherboard hanya support DDR4, tapi RAM yang dipilih DDR5!',
    is_active: TRUE
);

-- Rule 3: PSU Wattage Check
INSERT INTO compatibility_rules VALUES (
    rule_name: 'PSU Wattage Sufficient',
    component_type_a: 'Power Supply',
    component_type_b: 'ALL',
    rule_type: 'tdp_check',
    rule_conditions: '{
        "formula": "psu_wattage >= (cpu_tdp + gpu_tdp + 100) * 1.2",
        "safety_margin": 1.2,
        "required": true
    }',
    error_message: 'PSU kurang daya! Minimal 650W untuk build ini.',
    is_active: TRUE
);
```

---

### 3. Tabel `orders` (Enhanced untuk Teknisi)

```sql
CREATE TABLE orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT,
    order_number VARCHAR(50) UNIQUE,
    
    -- NEW: Build Information
    is_pc_build BOOLEAN DEFAULT FALSE,     -- Apakah rakit PC atau beli biasa
    build_configuration JSON,              -- Menyimpan detail build
    assembly_notes TEXT,                   -- Catatan dari customer
    
    -- Status
    status VARCHAR(50),                    -- pending, assembly, quality_check, shipped
    payment_status VARCHAR(50),
    
    -- Pricing
    subtotal DECIMAL(12,2),
    tax DECIMAL(12,2),
    shipping_cost DECIMAL(12,2),
    total DECIMAL(12,2),
    
    -- NEW: Assembly Tracking
    assigned_technician_id BIGINT,        -- User ID teknisi
    assembly_started_at TIMESTAMP,
    assembly_completed_at TIMESTAMP,
    estimated_completion_time INT,         -- dalam menit
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_status (status),
    INDEX idx_technician (assigned_technician_id)
);
```

---

## 🎨 FITUR DASHBOARD ADMIN

### A. DASHBOARD OVERVIEW

**URL:** `/admin`

**Tampilan:**
```
┌─────────────────────────────────────────────────────────┐
│ DASHBOARD ADMIN - SEBATAS PC                            │
├─────────────────────────────────────────────────────────┤
│                                                           │
│  📦 Total Produk    💰 Total Revenue   📋 Pesanan Baru   │
│     91 items          Rp 125.5jt          12 orders     │
│                                                           │
│  ⚠️  STOK MENIPIS                                         │
│  ├─ AMD Ryzen 5 5600 (2 pcs tersisa)                     │
│  ├─ Corsair Vengeance 16GB (3 pcs)                       │
│  └─ Kingston NV2 500GB (4 pcs)                           │
│                                                           │
│  📊 GRAFIK PENJUALAN (7 Hari Terakhir)                    │
│  [Chart showing daily sales]                             │
│                                                           │
│  🔧 PESANAN RAKIT PC (Perlu Assembly)                     │
│  ├─ Order #ORD-001 - Gaming 15jt (Status: Assembly)      │
│  ├─ Order #ORD-002 - Office 8jt (Status: Pending)        │
│  └─ Order #ORD-003 - Editing 25jt (Status: Quality Check)│
└─────────────────────────────────────────────────────────┘
```

**Controller Method:**
```php
public function dashboard()
{
    $stats = [
        'total_products' => Product::count(),
        'total_revenue' => Order::where('status', 'completed')->sum('total'),
        'new_orders' => Order::where('created_at', '>=', now()->subDays(7))->count(),
        'low_stock' => Product::whereRaw('stock <= min_stock_alert')->count(),
    ];
    
    $lowStockProducts = Product::whereRaw('stock <= min_stock_alert')
        ->orderBy('stock', 'asc')
        ->take(5)
        ->get();
    
    $pcBuildOrders = Order::where('is_pc_build', true)
        ->whereIn('status', ['pending', 'assembly', 'quality_check'])
        ->with('user', 'technician')
        ->latest()
        ->get();
    
    return view('admin.dashboard', compact('stats', 'lowStockProducts', 'pcBuildOrders'));
}
```

---

### B. MANAJEMEN PRODUK

**URL:** `/admin/products`

#### 1. Listing Produk dengan Filter

**Fitur:**
- Filter by Category
- Filter by Brand
- Filter by Stock Status (Low Stock, Out of Stock, In Stock)
- Search by Name/SKU
- Sort by Price, Stock, Created Date

**Controller:**
```php
public function productIndex(Request $request)
{
    $query = Product::with('category');
    
    // Filter by category
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }
    
    // Filter by brand
    if ($request->filled('brand')) {
        $query->where('brand', $request->brand);
    }
    
    // Filter by stock status
    if ($request->stock_status == 'low') {
        $query->whereRaw('stock <= min_stock_alert');
    } elseif ($request->stock_status == 'out') {
        $query->where('stock', 0);
    }
    
    // Search
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'LIKE', "%{$request->search}%")
              ->orWhere('sku', 'LIKE', "%{$request->search}%");
        });
    }
    
    // Sort
    $sortField = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');
    $query->orderBy($sortField, $sortDirection);
    
    $products = $query->paginate(20);
    $brands = Product::distinct()->pluck('brand');
    
    return view('admin.products.index', compact('products', 'brands'));
}
```

#### 2. Form Input/Edit Produk

**Form Fields (Dinamis per Kategori):**

```html
<form action="/admin/products" method="POST" enctype="multipart/form-data">
    <!-- Basic Info -->
    <input name="name" required>
    <select name="category_id" required>
        <option value="1">Processor</option>
        <option value="2">Graphics Card</option>
        ...
    </select>
    <input name="brand" list="brands">
    <input name="model">
    <input name="sku">
    <textarea name="description"></textarea>
    
    <!-- Pricing -->
    <input type="number" name="cost_price" step="0.01">
    <input type="number" name="markup_percentage" step="0.01">
    <input type="number" name="price" readonly> <!-- Auto-calculated -->
    
    <!-- Stock -->
    <input type="number" name="stock">
    <input type="number" name="min_stock_alert" value="5">
    
    <!-- DYNAMIC FIELDS: Muncul berdasarkan kategori yang dipilih -->
    
    <!-- If Category = Processor -->
    <div id="cpu-fields" class="hidden">
        <select name="socket">
            <option>LGA1700</option>
            <option>LGA1200</option>
            <option>AM4</option>
            <option>AM5</option>
        </select>
        <input type="number" name="tdp" placeholder="TDP (Watts)">
    </div>
    
    <!-- If Category = Motherboard -->
    <div id="motherboard-fields" class="hidden">
        <select name="socket"></select>
        <select name="chipset"></select>
        <select name="form_factor">
            <option>ATX</option>
            <option>mATX</option>
            <option>Mini-ITX</option>
        </select>
        <input type="number" name="memory_slots">
        <select name="supported_memory_types" multiple>
            <option>DDR4</option>
            <option>DDR5</option>
        </select>
    </div>
    
    <!-- If Category = Memory (RAM) -->
    <div id="ram-fields" class="hidden">
        <select name="memory_type">
            <option>DDR4</option>
            <option>DDR5</option>
        </select>
        <input type="number" name="memory_speed" placeholder="Speed (MHz)">
        <input type="number" name="capacity_gb" placeholder="Capacity (GB)">
    </div>
    
    <!-- If Category = Storage -->
    <div id="storage-fields" class="hidden">
        <select name="interface">
            <option>NVMe M.2</option>
            <option>SATA SSD</option>
            <option>SATA HDD</option>
        </select>
        <input type="number" name="capacity_gb">
    </div>
    
    <!-- If Category = Power Supply -->
    <div id="psu-fields" class="hidden">
        <input type="number" name="wattage" placeholder="Wattage">
        <select name="efficiency_rating">
            <option>80+ Bronze</option>
            <option>80+ Silver</option>
            <option>80+ Gold</option>
            <option>80+ Platinum</option>
        </select>
        <select name="form_factor">
            <option>ATX</option>
            <option>SFX</option>
        </select>
    </div>
    
    <!-- If Category = Graphics Card -->
    <div id="gpu-fields" class="hidden">
        <input type="number" name="tdp">
        <input type="number" name="length_mm" placeholder="Length (mm)">
        <input type="number" name="height_mm">
    </div>
    
    <!-- Image Upload -->
    <input type="file" name="image" accept="image/*">
    
    <button type="submit">Simpan Produk</button>
</form>

<script>
// Auto-calculate price from cost + markup
document.querySelector('[name="cost_price"]').addEventListener('input', calculatePrice);
document.querySelector('[name="markup_percentage"]').addEventListener('input', calculatePrice);

function calculatePrice() {
    const cost = parseFloat(document.querySelector('[name="cost_price"]').value) || 0;
    const markup = parseFloat(document.querySelector('[name="markup_percentage"]').value) || 0;
    const price = cost * (1 + markup / 100);
    document.querySelector('[name="price"]').value = Math.round(price);
}

// Show/hide fields based on category
document.querySelector('[name="category_id"]').addEventListener('change', function() {
    const category = this.options[this.selectedIndex].text;
    document.querySelectorAll('[id$="-fields"]').forEach(el => el.classList.add('hidden'));
    
    if (category.includes('Processor')) {
        document.getElementById('cpu-fields').classList.remove('hidden');
    } else if (category.includes('Motherboard')) {
        document.getElementById('motherboard-fields').classList.remove('hidden');
    }
    // ... and so on
});
</script>
```

**Controller:**
```php
public function productStore(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'brand' => 'nullable|string',
        'model' => 'nullable|string',
        'sku' => 'nullable|unique:products,sku',
        'cost_price' => 'nullable|numeric',
        'markup_percentage' => 'nullable|numeric',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        // ... dynamic fields validation
    ]);
    
    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $validated['image'] = 'storage/' . $imagePath;
    }
    
    Product::create($validated);
    
    return redirect()->route('admin.products.index')
        ->with('success', 'Produk berhasil ditambahkan!');
}
```

---

### C. MASS UPDATE HARGA

**URL:** `/admin/products/mass-update`

**Form:**
```html
<form action="/admin/products/mass-update" method="POST">
    <h3>Mass Update Harga</h3>
    
    <!-- Filter Selection -->
    <label>
        <input type="checkbox" name="filter_type[]" value="category">
        Berdasarkan Kategori
    </label>
    <select name="category_ids[]" multiple>
        <option value="1">Processor</option>
        <option value="2">Graphics Card</option>
        ...
    </select>
    
    <label>
        <input type="checkbox" name="filter_type[]" value="brand">
        Berdasarkan Brand
    </label>
    <select name="brands[]" multiple>
        <option>Intel</option>
        <option>AMD</option>
        <option>NVIDIA</option>
        ...
    </select>
    
    <!-- Update Type -->
    <h4>Jenis Update:</h4>
    <label>
        <input type="radio" name="update_type" value="percentage" checked>
        Persentase
    </label>
    <input type="number" name="percentage" step="0.01" placeholder="5.00">
    <select name="percentage_direction">
        <option value="increase">Naik</option>
        <option value="decrease">Turun</option>
    </select>
    
    <label>
        <input type="radio" name="update_type" value="fixed">
        Jumlah Tetap
    </label>
    <input type="number" name="fixed_amount" placeholder="100000">
    <select name="fixed_direction">
        <option value="increase">Naik</option>
        <option value="decrease">Turun</option>
    </select>
    
    <!-- Preview -->
    <button type="button" onclick="previewChanges()">Preview Perubahan</button>
    
    <div id="preview-table" class="hidden">
        <!-- AJAX load preview table -->
    </div>
    
    <button type="submit" class="btn-danger">Terapkan Perubahan</button>
</form>
```

**Controller:**
```php
public function massUpdatePrice(Request $request)
{
    $query = Product::query();
    
    // Apply filters
    if (in_array('category', $request->filter_type)) {
        $query->whereIn('category_id', $request->category_ids);
    }
    
    if (in_array('brand', $request->filter_type)) {
        $query->whereIn('brand', $request->brands);
    }
    
    $products = $query->get();
    $updatedCount = 0;
    
    foreach ($products as $product) {
        $newPrice = $product->price;
        
        if ($request->update_type === 'percentage') {
            $percentage = $request->percentage / 100;
            if ($request->percentage_direction === 'increase') {
                $newPrice = $product->price * (1 + $percentage);
            } else {
                $newPrice = $product->price * (1 - $percentage);
            }
        } elseif ($request->update_type === 'fixed') {
            if ($request->fixed_direction === 'increase') {
                $newPrice = $product->price + $request->fixed_amount;
            } else {
                $newPrice = $product->price - $request->fixed_amount;
            }
        }
        
        $product->update(['price' => round($newPrice)]);
        $updatedCount++;
    }
    
    return redirect()->back()
        ->with('success', "{$updatedCount} produk berhasil diupdate!");
}

public function massUpdatePreview(Request $request)
{
    // Same logic as above but return JSON for preview
    $products = // ... get products with filters
    
    $preview = [];
    foreach ($products as $product) {
        $newPrice = // ... calculate new price
        
        $preview[] = [
            'name' => $product->name,
            'current_price' => $product->price,
            'new_price' => $newPrice,
            'difference' => $newPrice - $product->price,
        ];
    }
    
    return response()->json($preview);
}
```

---

### D. ORDER SUMMARY UNTUK TEKNISI

**URL:** `/admin/orders/{id}/assembly-sheet`

**View: Assembly Worksheet**

```
┌─────────────────────────────────────────────────────────┐
│ ORDER ASSEMBLY WORKSHEET                                 │
│ Order #: ORD-20251219-001                               │
│ Customer: John Doe (081234567890)                       │
│ Order Date: 19 Des 2025 14:30                           │
│ Estimated Build Time: 120 minutes                       │
├─────────────────────────────────────────────────────────┤
│                                                           │
│ BUILD CONFIGURATION: Gaming 15jt - Best Value            │
│                                                           │
│ KOMPONEN YANG DIPERLUKAN:                                │
│                                                           │
│ ✓ PROCESSOR                                              │
│   ├─ Intel Core i5-12400F                                │
│   ├─ Socket: LGA1700                                     │
│   ├─ TDP: 65W                                            │
│   └─ Lokasi: Rak A3, Box 12                              │
│                                                           │
│ ✓ MOTHERBOARD                                            │
│   ├─ MSI MAG B660M Mortar                                │
│   ├─ Socket: LGA1700 ✓ Compatible                        │
│   ├─ Form Factor: mATX                                   │
│   ├─ Memory Slots: 4 x DDR4                              │
│   └─ Lokasi: Rak B1, Box 5                               │
│                                                           │
│ ✓ MEMORY (RAM)                                           │
│   ├─ Corsair Vengeance 16GB DDR4-3200                    │
│   ├─ Type: DDR4 ✓ Compatible with Motherboard           │
│   ├─ Speed: 3200MHz                                      │
│   └─ Lokasi: Rak C2, Box 18                              │
│                                                           │
│ ✓ GRAPHICS CARD                                          │
│   ├─ MSI GeForce RTX 4060 Ventus                         │
│   ├─ TDP: 115W                                           │
│   ├─ Length: 199mm                                       │
│   └─ Lokasi: Rak D1, Box 3                               │
│                                                           │
│ ✓ STORAGE                                                │
│   ├─ Kingston NV2 500GB NVMe                             │
│   ├─ Interface: NVMe M.2                                 │
│   └─ Lokasi: Rak E4, Box 22                              │
│                                                           │
│ ✓ POWER SUPPLY                                           │
│   ├─ Cooler Master MWE Gold 650W                         │
│   ├─ Wattage: 650W                                       │
│   ├─ Total TDP: 180W (CPU+GPU)                           │
│   ├─ Recommended: 300W (with 20% margin)                 │
│   └─ ✓ SUFFICIENT POWER                                  │
│      Lokasi: Rak F2, Box 9                               │
│                                                           │
│ ✓ CASING                                                 │
│   ├─ NZXT H510                                           │
│   ├─ Form Factor: ATX (supports mATX) ✓                  │
│   └─ Lokasi: Rak G1, Box 1                               │
│                                                           │
│ ✓ CPU COOLER                                             │
│   ├─ Intel Stock Cooler                                  │
│   ├─ Compatible: LGA1700 ✓                               │
│   └─ Lokasi: Box with CPU                                │
│                                                           │
├─────────────────────────────────────────────────────────┤
│ COMPATIBILITY CHECK RESULTS:                             │
│ ✓ CPU Socket matches Motherboard                         │
│ ✓ RAM Type compatible with Motherboard                   │
│ ✓ PSU Wattage sufficient for system                      │
│ ✓ GPU fits in case (199mm < 310mm max)                   │
│ ✓ Motherboard fits in case (mATX < ATX)                  │
│                                                           │
│ ⚠️  CATATAN CUSTOMER:                                     │
│ "Tolong pastikan RGB-nya nyala semua. Install Windows    │
│  11 dan driver lengkap. Testing game minimal 1 jam."     │
│                                                           │
├─────────────────────────────────────────────────────────┤
│ ASSEMBLY CHECKLIST:                                      │
│ [ ] Pasang CPU ke Motherboard                            │
│ [ ] Pasang CPU Cooler                                    │
│ [ ] Pasang RAM ke slot                                   │
│ [ ] Install Motherboard ke casing                        │
│ [ ] Pasang PSU ke casing                                 │
│ [ ] Install Storage (M.2/SATA)                           │
│ [ ] Pasang Graphics Card                                 │
│ [ ] Cable management                                     │
│ [ ] Connect semua power cables                           │
│ [ ] Test POST (Power On Self Test)                       │
│ [ ] Install OS                                           │
│ [ ] Install Drivers                                      │
│ [ ] Stress Test (1 hour)                                 │
│ [ ] Final QC & Photos                                    │
│                                                           │
│ Technician: ________________  Waktu Mulai: __________    │
│ Supervisor: ________________  Waktu Selesai: _________   │
└─────────────────────────────────────────────────────────┘
```

**Controller:**
```php
public function assemblySheet(Order $order)
{
    $order->load(['items.product.category', 'user']);
    
    // Get build configuration
    $buildConfig = json_decode($order->build_configuration, true);
    
    // Group components by category
    $components = [];
    foreach ($order->items as $item) {
        $category = $item->product->category->name;
        $components[$category] = $item->product;
    }
    
    // Run compatibility checks
    $compatibilityResults = $this->checkCompatibility($components);
    
    // Calculate total TDP
    $totalTDP = 0;
    if (isset($components['Processor'])) {
        $totalTDP += $components['Processor']->tdp ?? 0;
    }
    if (isset($components['Graphics Card'])) {
        $totalTDP += $components['Graphics Card']->tdp ?? 0;
    }
    
    // Check PSU sufficiency
    $requiredWattage = ($totalTDP + 100) * 1.2; // 20% margin
    $psuSufficient = false;
    if (isset($components['Power Supply'])) {
        $psuWattage = $components['Power Supply']->wattage;
        $psuSufficient = $psuWattage >= $requiredWattage;
    }
    
    return view('admin.orders.assembly-sheet', compact(
        'order',
        'components',
        'compatibilityResults',
        'totalTDP',
        'requiredWattage',
        'psuSufficient'
    ));
}

private function checkCompatibility($components)
{
    $results = [];
    
    // Check CPU-Motherboard socket
    if (isset($components['Processor']) && isset($components['Motherboard'])) {
        $cpuSocket = $components['Processor']->socket;
        $moboSocket = $components['Motherboard']->socket;
        $results['cpu_mobo_socket'] = [
            'pass' => $cpuSocket === $moboSocket,
            'message' => $cpuSocket === $moboSocket 
                ? "✓ CPU Socket matches Motherboard" 
                : "✗ Socket mismatch: {$cpuSocket} vs {$moboSocket}"
        ];
    }
    
    // Check RAM-Motherboard type
    if (isset($components['Memory']) && isset($components['Motherboard'])) {
        $ramType = $components['Memory']->memory_type;
        $moboTypes = json_decode($components['Motherboard']->supported_memory_types, true);
        $compatible = in_array($ramType, $moboTypes);
        $results['ram_mobo_type'] = [
            'pass' => $compatible,
            'message' => $compatible
                ? "✓ RAM Type compatible with Motherboard"
                : "✗ RAM type incompatible: {$ramType} not in " . implode(', ', $moboTypes)
        ];
    }
    
    // Add more checks...
    
    return $results;
}
```

---

## 🔌 API ENDPOINTS

### Admin Product Management

```php
// routes/web.php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProductController::class);
    Route::post('products/mass-update-preview', [AdminProductController::class, 'massUpdatePreview']);
    Route::post('products/mass-update', [AdminProductController::class, 'massUpdate']);
    Route::get('products/low-stock', [AdminProductController::class, 'lowStock']);
    
    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/assembly-sheet', [AdminOrderController::class, 'assemblySheet']);
    Route::post('orders/{order}/assign-technician', [AdminOrderController::class, 'assignTechnician']);
    Route::post('orders/{order}/update-status', [AdminOrderController::class, 'updateStatus']);
    
    // Compatibility Rules
    Route::resource('compatibility-rules', AdminCompatibilityController::class);
    
    // Reports
    Route::get('reports/sales', [AdminReportController::class, 'sales']);
    Route::get('reports/inventory', [AdminReportController::class, 'inventory']);
});
```

---

## 📊 QUERY EXAMPLES

### 1. Cari produk dengan stok menipis
```sql
SELECT id, name, brand, stock, min_stock_alert
FROM products
WHERE stock <= min_stock_alert
ORDER BY stock ASC;
```

### 2. Cari CPU yang compatible dengan motherboard tertentu
```sql
SELECT p.*
FROM products p
WHERE p.category_id = 1 -- Processor
  AND p.socket = (
      SELECT socket 
      FROM products 
      WHERE id = 5 -- Motherboard ID
  );
```

### 3. Validasi build configuration
```sql
-- Check if CPU and Motherboard socket match
SELECT 
    cpu.name AS cpu_name,
    cpu.socket AS cpu_socket,
    mobo.name AS mobo_name,
    mobo.socket AS mobo_socket,
    CASE 
        WHEN cpu.socket = mobo.socket THEN 'Compatible'
        ELSE 'Incompatible'
    END AS compatibility
FROM products cpu
CROSS JOIN products mobo
WHERE cpu.id = 1   -- Selected CPU
  AND mobo.id = 5  -- Selected Motherboard;
```

### 4. Calculate recommended PSU wattage
```sql
SELECT 
    (COALESCE(cpu.tdp, 0) + COALESCE(gpu.tdp, 0) + 100) * 1.2 AS recommended_wattage
FROM products cpu
LEFT JOIN products gpu ON gpu.id = 23  -- Selected GPU
WHERE cpu.id = 1;  -- Selected CPU
```

---

## 🎯 IMPLEMENTASI PRIORITAS

**Phase 1 (Segera):**
- ✅ Migration kolom kompatibilitas
- ✅ Model Product update
- ⏳ Admin Dashboard basic
- ⏳ Product CRUD dengan form dinamis

**Phase 2:**
- ⏳ Mass Update Harga
- ⏳ Low Stock Alert
- ⏳ Order Assembly Sheet

**Phase 3:**
- ⏳ Compatibility Rules Engine
- ⏳ Auto-validation saat customer build PC
- ⏳ Reporting & Analytics

---

**Dokumentasi:** 19 Desember 2025  
**Developer:** Sebatas PC Dev Team
