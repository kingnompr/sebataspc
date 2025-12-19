@extends('admin.layout')

@section('title', 'Orders Management')
@section('page-title', 'Orders Management')
@section('page-description', 'Manage all customer orders')

@section('page-actions')
<div class="flex gap-3">
    <button class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
        <span class="material-symbols-outlined text-lg">download</span>
        Export Orders
    </button>
</div>
@endsection

@section('content')
<!-- Status Filter Tabs -->
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-4 mb-6">
    <div class="flex items-center gap-2 overflow-x-auto">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800' }}">
            All ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'pending' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800' }}">
            Pending ({{ $statusCounts['pending'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'paid' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800' }}">
            Paid ({{ $statusCounts['paid'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'processing' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800' }}">
            Processing ({{ $statusCounts['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'shipped' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800' }}">
            Shipped ({{ $statusCounts['shipped'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'delivered' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800' }}">
            Delivered ({{ $statusCounts['delivered'] }})
        </a>
    </div>
</div>

<!-- Orders Table -->
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50 text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Order Number</th>
                    <th class="px-6 py-4 font-semibold">Customer</th>
                    <th class="px-6 py-4 font-semibold">Items</th>
                    <th class="px-6 py-4 font-semibold">Total</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold">Date</th>
                    <th class="px-6 py-4 font-semibold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-sm">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                            <div class="flex items-center gap-2">
                                <div class="size-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr($order->user->name ?? 'G', 0, 2)) }}
                                </div>
                                <span>{{ $order->user->name ?? 'Guest' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $order->items->count() }} items</td>
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($order->status === 'delivered') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                @elseif($order->status === 'shipped') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                @elseif($order->status === 'processing') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                @elseif($order->status === 'pending') bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400
                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-primary hover:text-primary-hover">
                                <span class="material-symbols-outlined">visibility</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 mb-4">
                                <span class="material-symbols-outlined text-slate-400 text-3xl">shopping_cart</span>
                            </div>
                            <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-1">No Orders Found</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Orders will appear here when customers make purchases.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
