@extends('admin.layout')

@section('title', 'Order Details')
@section('page-title', 'Order Details')
@section('page-description', 'Order #' . $order->order_number)

@section('content')
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Order Information</h3>
    
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Customer</p>
            <p class="font-medium text-slate-900 dark:text-white">{{ $order->user->name ?? 'Guest' }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Status</p>
            <p class="font-medium text-slate-900 dark:text-white">{{ ucfirst($order->status) }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Order Date</p>
            <p class="font-medium text-slate-900 dark:text-white">{{ $order->created_at->format('M d, Y H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Amount</p>
            <p class="font-medium text-slate-900 dark:text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <h4 class="font-bold text-slate-900 dark:text-white mb-3">Order Items</h4>
    <div class="space-y-3">
        @foreach($order->items as $item)
            <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <div class="flex-1">
                    <p class="font-medium text-slate-900 dark:text-white">{{ $item->product->name }}</p>
                    <p class="text-sm text-slate-500">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                </div>
                <p class="font-bold text-slate-900 dark:text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
