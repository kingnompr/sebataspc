@extends('admin.layout')

@section('title', 'Manajemen Produk')
@section('page-title', 'Manajemen Produk')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
        </a>
        <button onclick="document.getElementById('massUpdateModal').classList.remove('hidden')" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 ml-2">
            Mass Update Harga
        </button>
    </div>
    
    <div class="text-gray-600">
        Total: <strong>{{ $products->total() }}</strong> produk
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, SKU, Brand..." class="w-full border rounded px-3 py-2">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select name="category" class="w-full border rounded px-3 py-2">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
            <select name="brand" class="w-full border rounded px-3 py-2">
                <option value="">Semua Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                        {{ $brand }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status Stok</label>
            <select name="stock_status" class="w-full border rounded px-3 py-2">
                <option value="">Semua</option>
                <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Stok Menipis</option>
                <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Habis</option>
                <option value="in" {{ request('stock_status') == 'in' ? 'selected' : '' }}>Tersedia</option>
            </select>
        </div>
        
        <div class="col-span-4 flex justify-end space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filter
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand/SKU</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded mr-3">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                @if($product->socket)
                                    <div class="text-xs text-gray-500">Socket: {{ $product->socket }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $product->category->name }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="font-medium">{{ $product->brand }}</div>
                        @if($product->sku)
                            <div class="text-xs text-gray-500">{{ $product->sku }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        @if($product->cost_price)
                            <div class="text-xs text-gray-500">
                                Modal: Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($product->stock == 0)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Habis
                            </span>
                        @elseif($product->stock <= $product->min_stock_alert)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                {{ $product->stock }} pcs
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $product->stock }} pcs
                            </span>
                        @endif
                        <div class="text-xs text-gray-500 mt-1">Alert: {{ $product->min_stock_alert }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 mr-3">
                            Edit
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        Tidak ada produk ditemukan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $products->links() }}
</div>

<!-- Mass Update Modal -->
<div id="massUpdateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-2xl w-full max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Mass Update Harga</h3>
            <button onclick="document.getElementById('massUpdateModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form id="massUpdateForm" method="POST" action="{{ route('admin.products.mass-update') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Produk</label>
                
                <div class="mb-3">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="filter_category" class="rounded" onchange="toggleFilter('category')">
                        <span class="ml-2">Berdasarkan Kategori</span>
                    </label>
                    <select name="category_ids[]" id="categoryFilter" multiple class="w-full border rounded px-3 py-2 mt-2 hidden">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="filter_brand" class="rounded" onchange="toggleFilter('brand')">
                        <span class="ml-2">Berdasarkan Brand</span>
                    </label>
                    <select name="brands[]" id="brandFilter" multiple class="w-full border rounded px-3 py-2 mt-2 hidden">
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}">{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Update</label>
                
                <label class="inline-flex items-center mr-6">
                    <input type="radio" name="update_type" value="percentage" checked class="rounded" onchange="toggleUpdateType()">
                    <span class="ml-2">Persentase</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="update_type" value="fixed" class="rounded" onchange="toggleUpdateType()">
                    <span class="ml-2">Jumlah Tetap</span>
                </label>
            </div>
            
            <div id="percentageFields" class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Persentase</label>
                    <input type="number" name="percentage" step="0.01" class="w-full border rounded px-3 py-2" placeholder="5.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Arah</label>
                    <select name="percentage_direction" class="w-full border rounded px-3 py-2">
                        <option value="increase">Naik</option>
                        <option value="decrease">Turun</option>
                    </select>
                </div>
            </div>
            
            <div id="fixedFields" class="mb-4 grid grid-cols-2 gap-4 hidden">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
                    <input type="number" name="fixed_amount" class="w-full border rounded px-3 py-2" placeholder="100000">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Arah</label>
                    <select name="fixed_direction" class="w-full border rounded px-3 py-2">
                        <option value="increase">Naik</option>
                        <option value="decrease">Turun</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <button type="button" onclick="previewMassUpdate()" class="w-full bg-blue-100 text-blue-700 px-4 py-2 rounded hover:bg-blue-200">
                    Preview Perubahan
                </button>
            </div>
            
            <div id="previewResults" class="mb-4 hidden">
                <!-- Preview akan dimuat di sini -->
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('massUpdateModal').classList.add('hidden')" class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Terapkan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleFilter(type) {
    const checkbox = document.querySelector(`[name="filter_${type}"]`);
    const filter = document.getElementById(`${type}Filter`);
    if (checkbox.checked) {
        filter.classList.remove('hidden');
    } else {
        filter.classList.add('hidden');
    }
}

function toggleUpdateType() {
    const updateType = document.querySelector('input[name="update_type"]:checked').value;
    if (updateType === 'percentage') {
        document.getElementById('percentageFields').classList.remove('hidden');
        document.getElementById('fixedFields').classList.add('hidden');
    } else {
        document.getElementById('percentageFields').classList.add('hidden');
        document.getElementById('fixedFields').classList.remove('hidden');
    }
}

async function previewMassUpdate() {
    const form = document.getElementById('massUpdateForm');
    const formData = new FormData(form);
    
    try {
        const response = await fetch('{{ route("admin.products.mass-update-preview") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            let html = `
                <div class="border rounded p-4 bg-gray-50">
                    <h4 class="font-bold mb-2">Preview: ${data.count} produk akan diupdate</h4>
                    <div class="max-h-60 overflow-y-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-200 sticky top-0">
                                <tr>
                                    <th class="px-2 py-1 text-left">Produk</th>
                                    <th class="px-2 py-1 text-right">Harga Lama</th>
                                    <th class="px-2 py-1 text-right">Harga Baru</th>
                                    <th class="px-2 py-1 text-right">Selisih</th>
                                </tr>
                            </thead>
                            <tbody>
            `;
            
            data.products.forEach(product => {
                const diffClass = product.difference >= 0 ? 'text-green-600' : 'text-red-600';
                html += `
                    <tr class="border-b">
                        <td class="px-2 py-1">${product.name}</td>
                        <td class="px-2 py-1 text-right">Rp ${product.current_price.toLocaleString()}</td>
                        <td class="px-2 py-1 text-right font-bold">Rp ${product.new_price.toLocaleString()}</td>
                        <td class="px-2 py-1 text-right ${diffClass}">
                            ${product.difference >= 0 ? '+' : ''}Rp ${product.difference.toLocaleString()}
                            (${product.percentage_change >= 0 ? '+' : ''}${product.percentage_change}%)
                        </td>
                    </tr>
                `;
            });
            
            html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            
            document.getElementById('previewResults').innerHTML = html;
            document.getElementById('previewResults').classList.remove('hidden');
        }
    } catch (error) {
        alert('Error loading preview: ' + error.message);
    }
}
</script>
@endsection
