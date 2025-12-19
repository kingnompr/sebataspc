@extends('admin.layout')

@section('title', 'Stok Menipis')
@section('page-title', 'Produk dengan Stok Menipis')

@section('content')
<div class="mb-6">
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <strong>{{ $products->count() }} produk</strong> memiliki stok di bawah minimum alert level
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok Saat Ini</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Min Alert</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50 {{ $product->stock == 0 ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded mr-3">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded mr-3"></div>
                            @endif
                            <div class="font-medium text-gray-900">{{ $product->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $product->category->name }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $product->brand }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-2xl font-bold {{ $product->stock == 0 ? 'text-red-600' : 'text-yellow-600' }}">
                            {{ $product->stock }}
                        </span>
                        <span class="text-sm text-gray-500">pcs</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $product->min_stock_alert }} pcs
                    </td>
                    <td class="px-6 py-4">
                        @if($product->stock == 0)
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                HABIS
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                MENIPIS
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800">
                            Restock
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="text-green-600 font-bold text-lg">
                            ✓ Semua produk memiliki stok yang cukup
                        </div>
                        <p class="text-gray-500 mt-2">Tidak ada produk dengan stok di bawah minimum alert level</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($products->count() > 0)
    <div class="mt-6 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold mb-4">Rekomendasi Action:</h3>
        <ul class="list-disc list-inside space-y-2 text-gray-700">
            <li>Segera lakukan <strong>Purchase Order</strong> untuk produk yang habis atau menipis</li>
            <li>Pastikan supplier sudah dikonfirmasi untuk ketersediaan barang</li>
            <li>Update <strong>last_restock_date</strong> setelah barang tiba</li>
            <li>Pertimbangkan menaikkan <strong>min_stock_alert</strong> untuk produk best-seller</li>
        </ul>
        
        <div class="mt-4 p-4 bg-blue-50 rounded">
            <strong>💡 Tip:</strong> Anda bisa mengubah stock langsung dari halaman edit produk, atau gunakan import Excel untuk mass update stok.
        </div>
    </div>
@endif
@endsection
