<!-- Basic Information -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <h3 class="text-lg font-bold mb-4">Informasi Dasar</h3>
    
    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
            @error('name')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
            <select name="category_id" id="categorySelect" required class="w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                            data-name="{{ $category->name }}"
                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
            <input type="text" name="brand" value="{{ old('brand', $product->brand ?? '') }}" list="brandList" class="w-full border rounded px-3 py-2">
            <datalist id="brandList">
                <option value="Intel">
                <option value="AMD">
                <option value="NVIDIA">
                <option value="MSI">
                <option value="ASUS">
                <option value="Gigabyte">
                <option value="Corsair">
                <option value="Kingston">
                <option value="Samsung">
                <option value="WD">
                <option value="Cooler Master">
                <option value="NZXT">
            </datalist>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
            <input type="text" name="model" value="{{ old('model', $product->model ?? '') }}" class="w-full border rounded px-3 py-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="CPU-INTEL-12400F">
        </div>
        
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $product->description ?? '') }}</textarea>
        </div>
    </div>
</div>

<!-- Pricing & Stock -->
<div class="bg-white p-6 rounded-lg shadow mb-6">
    <h3 class="text-lg font-bold mb-4">Harga & Stok</h3>
    
    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Modal (Rp)</label>
            <input type="number" name="cost_price" id="costPrice" value="{{ old('cost_price', $product->cost_price ?? '') }}" step="0.01" class="w-full border rounded px-3 py-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Markup (%)</label>
            <input type="number" name="markup_percentage" id="markupPercentage" value="{{ old('markup_percentage', $product->markup_percentage ?? '') }}" step="0.01" class="w-full border rounded px-3 py-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp) *</label>
            <input type="number" name="price" id="sellingPrice" value="{{ old('price', $product->price ?? '') }}" required class="w-full border rounded px-3 py-2 @error('price') border-red-500 @enderror">
            @error('price')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Stok *</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required class="w-full border rounded px-3 py-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Min Stock Alert</label>
            <input type="number" name="min_stock_alert" value="{{ old('min_stock_alert', $product->min_stock_alert ?? 5) }}" class="w-full border rounded px-3 py-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
            <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2">
            @if($product && $product->image)
                <img src="{{ asset($product->image) }}" alt="Current" class="mt-2 w-20 h-20 object-cover rounded">
            @endif
        </div>
    </div>
</div>

<!-- Dynamic Compatibility Fields -->
<!-- Processor Fields -->
<div id="processor-fields" class="bg-white p-6 rounded-lg shadow mb-6 hidden">
    <h3 class="text-lg font-bold mb-4">Spesifikasi Processor</h3>
    
    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Socket</label>
            <select name="socket" class="w-full border rounded px-3 py-2">
                <option value="">Pilih Socket</option>
                <option value="LGA1700" {{ old('socket', $product->socket ?? '') == 'LGA1700' ? 'selected' : '' }}>LGA1700</option>
                <option value="LGA1200" {{ old('socket', $product->socket ?? '') == 'LGA1200' ? 'selected' : '' }}>LGA1200</option>
                <option value="AM4" {{ old('socket', $product->socket ?? '') == 'AM4' ? 'selected' : '' }}>AM4</option>
                <option value="AM5" {{ old('socket', $product->socket ?? '') == 'AM5' ? 'selected' : '' }}>AM5</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">TDP (Watts)</label>
            <input type="number" name="tdp" value="{{ old('tdp', $product->tdp ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="65">
        </div>
    </div>
</div>

<!-- Motherboard Fields -->
<div id="motherboard-fields" class="bg-white p-6 rounded-lg shadow mb-6 hidden">
    <h3 class="text-lg font-bold mb-4">Spesifikasi Motherboard</h3>
    
    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Socket</label>
            <select name="socket" class="w-full border rounded px-3 py-2">
                <option value="">Pilih Socket</option>
                <option value="LGA1700" {{ old('socket', $product->socket ?? '') == 'LGA1700' ? 'selected' : '' }}>LGA1700</option>
                <option value="LGA1200" {{ old('socket', $product->socket ?? '') == 'LGA1200' ? 'selected' : '' }}>LGA1200</option>
                <option value="AM4" {{ old('socket', $product->socket ?? '') == 'AM4' ? 'selected' : '' }}>AM4</option>
                <option value="AM5" {{ old('socket', $product->socket ?? '') == 'AM5' ? 'selected' : '' }}>AM5</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Chipset</label>
            <input type="text" name="chipset" value="{{ old('chipset', $product->chipset ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="Z690, B550">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Form Factor</label>
            <select name="form_factor" class="w-full border rounded px-3 py-2">
                <option value="">Pilih</option>
                <option value="ATX" {{ old('form_factor', $product->form_factor ?? '') == 'ATX' ? 'selected' : '' }}>ATX</option>
                <option value="mATX" {{ old('form_factor', $product->form_factor ?? '') == 'mATX' ? 'selected' : '' }}>mATX</option>
                <option value="Mini-ITX" {{ old('form_factor', $product->form_factor ?? '') == 'Mini-ITX' ? 'selected' : '' }}>Mini-ITX</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Memory Slots</label>
            <input type="number" name="memory_slots" value="{{ old('memory_slots', $product->memory_slots ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="4">
        </div>
        
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Supported Memory Types</label>
            <div class="flex space-x-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="supported_memory_types[]" value="DDR4" 
                           {{ is_array(old('supported_memory_types', $product->supported_memory_types ?? [])) && in_array('DDR4', old('supported_memory_types', $product->supported_memory_types ?? [])) ? 'checked' : '' }} 
                           class="rounded">
                    <span class="ml-2">DDR4</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="supported_memory_types[]" value="DDR5" 
                           {{ is_array(old('supported_memory_types', $product->supported_memory_types ?? [])) && in_array('DDR5', old('supported_memory_types', $product->supported_memory_types ?? [])) ? 'checked' : '' }} 
                           class="rounded">
                    <span class="ml-2">DDR5</span>
                </label>
            </div>
        </div>
    </div>
</div>

<!-- Memory (RAM) Fields -->
<div id="memory-fields" class="bg-white p-6 rounded-lg shadow mb-6 hidden">
    <h3 class="text-lg font-bold mb-4">Spesifikasi Memory</h3>
    
    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Memory Type</label>
            <select name="memory_type" class="w-full border rounded px-3 py-2">
                <option value="">Pilih</option>
                <option value="DDR4" {{ old('memory_type', $product->memory_type ?? '') == 'DDR4' ? 'selected' : '' }}>DDR4</option>
                <option value="DDR5" {{ old('memory_type', $product->memory_type ?? '') == 'DDR5' ? 'selected' : '' }}>DDR5</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Speed (MHz)</label>
            <input type="number" name="memory_speed" value="{{ old('memory_speed', $product->memory_speed ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="3200">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Capacity (GB)</label>
            <input type="number" name="capacity_gb" value="{{ old('capacity_gb', $product->capacity_gb ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="16">
        </div>
    </div>
</div>

<!-- Storage Fields -->
<div id="storage-fields" class="bg-white p-6 rounded-lg shadow mb-6 hidden">
    <h3 class="text-lg font-bold mb-4">Spesifikasi Storage</h3>
    
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Interface</label>
            <select name="interface" class="w-full border rounded px-3 py-2">
                <option value="">Pilih</option>
                <option value="NVMe M.2" {{ old('interface', $product->interface ?? '') == 'NVMe M.2' ? 'selected' : '' }}>NVMe M.2</option>
                <option value="SATA SSD" {{ old('interface', $product->interface ?? '') == 'SATA SSD' ? 'selected' : '' }}>SATA SSD</option>
                <option value="SATA HDD" {{ old('interface', $product->interface ?? '') == 'SATA HDD' ? 'selected' : '' }}>SATA HDD</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Capacity (GB)</label>
            <input type="number" name="capacity_gb" value="{{ old('capacity_gb', $product->capacity_gb ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="512">
        </div>
    </div>
</div>

<!-- Graphics Card Fields -->
<div id="graphics-fields" class="bg-white p-6 rounded-lg shadow mb-6 hidden">
    <h3 class="text-lg font-bold mb-4">Spesifikasi Graphics Card</h3>
    
    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">TDP (Watts)</label>
            <input type="number" name="tdp" value="{{ old('tdp', $product->tdp ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="115">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Length (mm)</label>
            <input type="number" name="length_mm" value="{{ old('length_mm', $product->length_mm ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="199">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Height (mm)</label>
            <input type="number" name="height_mm" value="{{ old('height_mm', $product->height_mm ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="112">
        </div>
    </div>
</div>

<!-- Power Supply Fields -->
<div id="psu-fields" class="bg-white p-6 rounded-lg shadow mb-6 hidden">
    <h3 class="text-lg font-bold mb-4">Spesifikasi Power Supply</h3>
    
    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Wattage</label>
            <input type="number" name="wattage" value="{{ old('wattage', $product->wattage ?? '') }}" class="w-full border rounded px-3 py-2" placeholder="650">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Efficiency Rating</label>
            <select name="efficiency_rating" class="w-full border rounded px-3 py-2">
                <option value="">Pilih</option>
                <option value="80+ Bronze" {{ old('efficiency_rating', $product->efficiency_rating ?? '') == '80+ Bronze' ? 'selected' : '' }}>80+ Bronze</option>
                <option value="80+ Silver" {{ old('efficiency_rating', $product->efficiency_rating ?? '') == '80+ Silver' ? 'selected' : '' }}>80+ Silver</option>
                <option value="80+ Gold" {{ old('efficiency_rating', $product->efficiency_rating ?? '') == '80+ Gold' ? 'selected' : '' }}>80+ Gold</option>
                <option value="80+ Platinum" {{ old('efficiency_rating', $product->efficiency_rating ?? '') == '80+ Platinum' ? 'selected' : '' }}>80+ Platinum</option>
                <option value="80+ Titanium" {{ old('efficiency_rating', $product->efficiency_rating ?? '') == '80+ Titanium' ? 'selected' : '' }}>80+ Titanium</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Form Factor</label>
            <select name="form_factor" class="w-full border rounded px-3 py-2">
                <option value="">Pilih</option>
                <option value="ATX" {{ old('form_factor', $product->form_factor ?? '') == 'ATX' ? 'selected' : '' }}>ATX</option>
                <option value="SFX" {{ old('form_factor', $product->form_factor ?? '') == 'SFX' ? 'selected' : '' }}>SFX</option>
            </select>
        </div>
    </div>
</div>

<!-- Casing Fields -->
<div id="casing-fields" class="bg-white p-6 rounded-lg shadow mb-6 hidden">
    <h3 class="text-lg font-bold mb-4">Spesifikasi Casing</h3>
    
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Form Factor</label>
            <select name="form_factor" class="w-full border rounded px-3 py-2">
                <option value="">Pilih</option>
                <option value="ATX" {{ old('form_factor', $product->form_factor ?? '') == 'ATX' ? 'selected' : '' }}>ATX</option>
                <option value="mATX" {{ old('form_factor', $product->form_factor ?? '') == 'mATX' ? 'selected' : '' }}>mATX</option>
                <option value="Mini-ITX" {{ old('form_factor', $product->form_factor ?? '') == 'Mini-ITX' ? 'selected' : '' }}>Mini-ITX</option>
            </select>
        </div>
        
        <div>
            <label class="inline-flex items-center mt-6">
                <input type="checkbox" name="rgb_support" value="1" {{ old('rgb_support', $product->rgb_support ?? false) ? 'checked' : '' }} class="rounded">
                <span class="ml-2">RGB Support</span>
            </label>
        </div>
    </div>
</div>

<!-- CPU Cooler Fields -->
<div id="cooler-fields" class="bg-white p-6 rounded-lg shadow mb-6 hidden">
    <h3 class="text-lg font-bold mb-4">Spesifikasi CPU Cooler</h3>
    
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Compatible Sockets</label>
            <div class="space-y-2">
                <label class="inline-flex items-center mr-4">
                    <input type="checkbox" name="compatible_sockets[]" value="LGA1700" 
                           {{ is_array(old('compatible_sockets', $product->compatible_sockets ?? [])) && in_array('LGA1700', old('compatible_sockets', $product->compatible_sockets ?? [])) ? 'checked' : '' }} 
                           class="rounded">
                    <span class="ml-2">LGA1700</span>
                </label>
                <label class="inline-flex items-center mr-4">
                    <input type="checkbox" name="compatible_sockets[]" value="LGA1200" 
                           {{ is_array(old('compatible_sockets', $product->compatible_sockets ?? [])) && in_array('LGA1200', old('compatible_sockets', $product->compatible_sockets ?? [])) ? 'checked' : '' }} 
                           class="rounded">
                    <span class="ml-2">LGA1200</span>
                </label>
                <label class="inline-flex items-center mr-4">
                    <input type="checkbox" name="compatible_sockets[]" value="AM4" 
                           {{ is_array(old('compatible_sockets', $product->compatible_sockets ?? [])) && in_array('AM4', old('compatible_sockets', $product->compatible_sockets ?? [])) ? 'checked' : '' }} 
                           class="rounded">
                    <span class="ml-2">AM4</span>
                </label>
                <label class="inline-flex items-center mr-4">
                    <input type="checkbox" name="compatible_sockets[]" value="AM5" 
                           {{ is_array(old('compatible_sockets', $product->compatible_sockets ?? [])) && in_array('AM5', old('compatible_sockets', $product->compatible_sockets ?? [])) ? 'checked' : '' }} 
                           class="rounded">
                    <span class="ml-2">AM5</span>
                </label>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-calculate price
document.getElementById('costPrice').addEventListener('input', calculatePrice);
document.getElementById('markupPercentage').addEventListener('input', calculatePrice);

function calculatePrice() {
    const cost = parseFloat(document.getElementById('costPrice').value) || 0;
    const markup = parseFloat(document.getElementById('markupPercentage').value) || 0;
    if (cost > 0 && markup > 0) {
        const price = cost * (1 + markup / 100);
        document.getElementById('sellingPrice').value = Math.round(price);
    }
}

// Show/hide fields based on category
const categorySelect = document.getElementById('categorySelect');
const allFieldsections = [
    'processor-fields', 
    'motherboard-fields', 
    'memory-fields', 
    'storage-fields', 
    'graphics-fields', 
    'psu-fields', 
    'casing-fields', 
    'cooler-fields'
];

categorySelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const categoryName = selectedOption.getAttribute('data-name');
    
    // Hide all dynamic fields
    allFieldsections.forEach(id => {
        document.getElementById(id).classList.add('hidden');
    });
    
    // Show relevant fields based on category
    if (categoryName && categoryName.includes('Processor')) {
        document.getElementById('processor-fields').classList.remove('hidden');
    } else if (categoryName && categoryName.includes('Motherboard')) {
        document.getElementById('motherboard-fields').classList.remove('hidden');
    } else if (categoryName && categoryName.includes('Memory')) {
        document.getElementById('memory-fields').classList.remove('hidden');
    } else if (categoryName && categoryName.includes('Storage')) {
        document.getElementById('storage-fields').classList.remove('hidden');
    } else if (categoryName && categoryName.includes('Graphics')) {
        document.getElementById('graphics-fields').classList.remove('hidden');
    } else if (categoryName && categoryName.includes('Power Supply')) {
        document.getElementById('psu-fields').classList.remove('hidden');
    } else if (categoryName && categoryName.includes('Casing')) {
        document.getElementById('casing-fields').classList.remove('hidden');
    } else if (categoryName && categoryName.includes('CPU Cooler')) {
        document.getElementById('cooler-fields').classList.remove('hidden');
    }
});

// Trigger on page load if editing
@if($product)
    categorySelect.dispatchEvent(new Event('change'));
@endif
</script>
