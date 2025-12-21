@extends('admin.layout')

@section('title', 'Reports & Analytics')
@section('page-title', 'Reports & Analytics')
@section('page-description', 'Business insights and statistics')

@section('content')
<!-- Revenue Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400">payments</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Revenue</p>
        </div>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">
            @if($totalRevenue <= 50000000)
                Rp {{ number_format($totalRevenue / 1000000, 1) }} Juta
            @else
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            @endif
        </h3>
    </div>
    
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">trending_up</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">This Month</p>
        </div>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">
            @if($monthlyRevenue <= 50000000)
                Rp {{ number_format($monthlyRevenue / 1000000, 1) }} Juta
            @else
                Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}
            @endif
        </h3>
    </div>
    
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">shopping_bag</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Orders</p>
        </div>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalOrders }}</h3>
    </div>
    
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="p-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">inventory_2</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Products</p>
        </div>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalProducts }}</h3>
    </div>
</div>

<!-- Top Selling Products -->
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6 mb-6">
    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Top Selling Products</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50 text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-3 font-semibold">Product Name</th>
                    <th class="px-6 py-3 font-semibold text-right">Units Sold</th>
                    <th class="px-6 py-3 font-semibold text-right">Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-sm">
                @forelse($topProducts as $product)
                    <tr>
                        <td class="px-6 py-3 font-medium text-slate-900 dark:text-white">{{ $product->name }}</td>
                        <td class="px-6 py-3 text-right text-slate-600 dark:text-slate-300">{{ $product->total_sold }}</td>
                        <td class="px-6 py-3 text-right font-medium text-slate-900 dark:text-white">Rp {{ number_format($product->revenue, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">No sales data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Sales by Category -->
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Sales by Category</h3>
    <div class="space-y-3">
        @foreach($salesByCategory as $category)
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $category->name }}</span>
                    <span class="text-sm font-bold text-slate-900 dark:text-white">
                        @if($category->revenue <= 50000000)
                            Rp {{ number_format($category->revenue / 1000000, 1) }} Juta
                        @else
                            Rp {{ number_format($category->revenue, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-primary h-2 rounded-full" style="width: {{ ($category->revenue / $salesByCategory->max('revenue')) * 100 }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
