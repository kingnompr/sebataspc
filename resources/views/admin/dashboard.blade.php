@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Overview')
@section('page-description', 'Welcome back, here is what is happening today.')

@section('page-actions')
<div class="flex gap-3">
    <button class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined text-lg">download</span>
        Export Report
    </button>
    <a href="{{ route('admin.products.create') }}" class="flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-hover text-white rounded-lg text-sm font-medium transition-colors shadow-sm shadow-primary/30">
        <span class="material-symbols-outlined text-lg">add</span>
        Add Product
    </a>
</div>
@endsection

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Revenue -->
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col gap-3">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400">payments</span>
            </div>
            <span class="flex items-center text-xs font-medium text-slate-500 dark:text-slate-400">All Time</span>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Revenue</p>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">Rp {{ $stats['revenue_formatted'] }}</h3>
        </div>
    </div>
    
    <!-- Orders Today -->
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col gap-3">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-primary/10 rounded-lg">
                <span class="material-symbols-outlined text-primary">shopping_bag</span>
            </div>
            @if($stats['orders_today'] > 0)
                <span class="flex items-center text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">Today</span>
            @else
                <span class="flex items-center text-xs font-medium text-slate-400">Today</span>
            @endif
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Orders Today</p>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['orders_today'] }}</h3>
        </div>
    </div>
    
    <!-- Pending Orders -->
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col gap-3">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">pending_actions</span>
            </div>
            @if($stats['pending_orders'] > 0)
                <span class="flex items-center text-xs font-medium text-red-600 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-full">Action Needed</span>
            @else
                <span class="flex items-center text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">All Clear</span>
            @endif
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Pending Orders</p>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['pending_orders'] }}</h3>
        </div>
    </div>
    
    <!-- Low Stock -->
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col gap-3">
        <div class="flex items-start justify-between">
            <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400">warning</span>
            </div>
            @if($stats['low_stock_count'] > 0)
                <span class="flex items-center text-xs font-medium text-red-600 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-full">Stock ≤10</span>
            @else
                <span class="flex items-center text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">Good</span>
            @endif
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Low Stock Items</p>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['low_stock_count'] }}</h3>
        </div>
    </div>
</div>

<!-- Main Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Sales Chart -->
    <div class="lg:col-span-2 bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Product Distribution</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">By Category</p>
            </div>
            <div class="flex items-center gap-2">
                <h4 class="text-xl font-bold text-slate-900 dark:text-white">{{ $stats['total_products'] }} Produk</h4>
                <span class="text-xs font-medium text-blue-600 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-full">{{ $stats['categories'] }} Categories</span>
            </div>
        </div>
        
        <!-- Category Breakdown -->
        <div class="space-y-3">
            @foreach($productsByCategory as $category)
                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $category->name }}</span>
                            <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $category->products_count }} produk</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: {{ ($category->products_count / max($stats['total_products'], 1)) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-100 dark:border-gray-800">
            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">PC Builds Tersedia</p>
                <p class="text-lg font-bold text-slate-900 dark:text-white mt-1">{{ $stats['pc_builds'] }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Custom Builds</p>
                <p class="text-lg font-bold text-slate-900 dark:text-white mt-1">{{ $stats['custom_builds'] }}</p>
            </div>
        </div>
    </div>
    
    <!-- Low Stock Widget -->
    <div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-slate-900 dark:text-white">Low Stock Alert</h3>
            <a href="{{ route('admin.products.low-stock') }}" class="text-xs text-primary font-medium hover:underline">View Inventory</a>
        </div>
        <div class="space-y-4 flex-1 overflow-y-auto pr-2">
            @forelse($lowStockProducts->take(4) as $product)
                <div class="flex items-center gap-3">
                    @if($product->image)
                        <div class="size-10 rounded-lg bg-gray-100 dark:bg-gray-700 bg-center bg-cover" style="background-image: url('{{ asset($product->image) }}');"></div>
                    @else
                        <div class="size-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <span class="material-symbols-outlined text-gray-400">inventory_2</span>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $product->name }}</p>
                        <p class="text-xs text-slate-500">{{ $product->category->name }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-bold {{ $product->stock == 0 ? 'text-red-600' : 'text-orange-600' }}">{{ $product->stock }} Left</span>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-8">
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-full mb-3">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-3xl">check_circle</span>
                    </div>
                    <p class="text-sm text-slate-500 dark:text-slate-400 text-center">All products have sufficient stock</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
        <h3 class="text-base font-bold text-slate-900 dark:text-white">Recent Orders</h3>
        <a class="text-sm text-primary font-medium hover:underline flex items-center gap-1" href="#">
            View All
            <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
    </div>
    
    @if($recentOrders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50 text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Order ID</th>
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Items</th>
                        <th class="px-6 py-4 font-semibold">Date</th>
                        <th class="px-6 py-4 font-semibold">Amount</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-sm">
                    @foreach($recentOrders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                <div class="flex items-center gap-2">
                                    <div class="size-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($order->user->name ?? 'Guest', 0, 2)) }}
                                    </div>
                                    <span>{{ $order->user->name ?? 'Guest' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $order->items->count() }} item(s)</td>
                            <td class="px-6 py-4 text-slate-500">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($order->status == 'delivered')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Delivered
                                    </span>
                                @elseif($order->status == 'paid' || $order->status == 'shipped')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @elseif($order->status == 'processing')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        Processing
                                    </span>
                                @elseif($order->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-slate-400 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 mb-4">
                <span class="material-symbols-outlined text-slate-400 text-3xl">shopping_cart</span>
            </div>
            <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-1">No Orders Yet</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Orders will appear here when customers start purchasing.</p>
        </div>
    @endif
</div>
@endsection
