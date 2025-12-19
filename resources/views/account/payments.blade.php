<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Saya • SEBATAS PC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD@400,0,0&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <style>
        body { font-family: 'Space Grotesk', 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex w-full max-w-5xl items-center justify-between px-4 py-5">
                <div>
                    <p class="text-xs font-semibold tracking-[0.35em] text-slate-400">SEBATAS PC</p>
                    <h1 class="text-2xl font-semibold">Pesanan Saya</h1>
                    <p class="text-sm text-slate-500">Kelola dan lacak pesanan Anda.</p>
                </div>
                <a href="{{ route('account.overview') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">← Kembali ke Akun</a>
            </div>
        </header>

        <main class="mx-auto w-full max-w-5xl px-4 py-10 space-y-8">
            <!-- Pending Payment Orders -->
            <div class="rounded-3xl border border-slate-200 bg-white p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Menunggu Pembayaran</p>
                        <h2 class="text-xl font-semibold text-slate-900">{{ $pendingOrders->count() }} pesanan belum dibayar</h2>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($pendingOrders as $order)
                        <div class="rounded-2xl border border-orange-200 bg-orange-50/50 p-5">
                            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                                            <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                                            Menunggu Pembayaran
                                        </span>
                                        <p class="text-sm font-semibold text-slate-900">#{{ $order->order_number }}</p>
                                    </div>
                                    <p class="text-sm text-slate-600">Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>
                                    
                                    <div class="mt-4 space-y-2">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-slate-100 rounded flex items-center justify-center flex-shrink-0">
                                                    <span class="material-symbols-outlined text-slate-400">computer</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-slate-900 truncate">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</p>
                                                    <p class="text-xs text-slate-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex flex-col items-end gap-2">
                                    <p class="text-xs text-slate-500">Total Pesanan</p>
                                    <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                    <div class="flex gap-2 mt-2">
                                        <a href="{{ route('checkout.payment') }}" class="px-4 py-2 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700">
                                            Bayar Sekarang
                                        </a>
                                        <button class="px-4 py-2 border border-slate-300 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50">
                                            Batalkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 p-8 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">shopping_bag</span>
                            <p class="text-sm text-slate-500">Tidak ada pesanan yang menunggu pembayaran</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Paid Orders -->
            <div class="rounded-3xl border border-slate-200 bg-white p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Pesanan Lunas</p>
                        <h2 class="text-xl font-semibold text-slate-900">{{ $paidOrders->count() }} pesanan sudah dibayar</h2>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($paidOrders as $order)
                        @php
                            $statusConfig = match($order->status) {
                                'paid' => ['label' => 'Dibayar', 'color' => 'blue', 'icon' => 'check_circle'],
                                'processing' => ['label' => 'Diproses', 'color' => 'indigo', 'icon' => 'autorenew'],
                                'shipped' => ['label' => 'Dikirim', 'color' => 'purple', 'icon' => 'local_shipping'],
                                'delivered' => ['label' => 'Selesai', 'color' => 'green', 'icon' => 'done_all'],
                                default => ['label' => 'Diproses', 'color' => 'gray', 'icon' => 'schedule'],
                            };
                        @endphp
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 hover:shadow-md transition-shadow">
                            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-{{ $statusConfig['color'] }}-100 text-{{ $statusConfig['color'] }}-700 border border-{{ $statusConfig['color'] }}-200">
                                            <span class="material-symbols-outlined text-sm mr-1">{{ $statusConfig['icon'] }}</span>
                                            {{ $statusConfig['label'] }}
                                        </span>
                                        <p class="text-sm font-semibold text-slate-900">#{{ $order->order_number }}</p>
                                    </div>
                                    <p class="text-sm text-slate-600">Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>
                                    
                                    <div class="mt-4 space-y-2">
                                        @foreach($order->items->take(3) as $item)
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-slate-100 rounded flex items-center justify-center flex-shrink-0">
                                                    <span class="material-symbols-outlined text-slate-400">computer</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-slate-900 truncate">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</p>
                                                    <p class="text-xs text-slate-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($order->items->count() > 3)
                                            <p class="text-xs text-slate-500 ml-15">+{{ $order->items->count() - 3 }} produk lainnya</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col items-end gap-2">
                                    <p class="text-xs text-slate-500">Total Pesanan</p>
                                    <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                    <div class="flex gap-2 mt-2">
                                        <a href="{{ route('account.orders.invoice', $order) }}" class="px-4 py-2 bg-slate-900 text-white text-sm font-semibold rounded-lg hover:bg-slate-800">
                                            Lihat Detail
                                        </a>
                                        @if($order->status === 'delivered')
                                            <button class="px-4 py-2 border border-slate-300 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50">
                                                Beli Lagi
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 p-8 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">receipt_long</span>
                            <p class="text-sm text-slate-500">Belum ada pesanan yang dibayar</p>
                            <a href="{{ route('products.catalog') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-slate-900 text-white text-sm font-semibold rounded-lg hover:bg-slate-800">
                                <span class="material-symbols-outlined text-base">shopping_bag</span>
                                Mulai Belanja
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</body>
</html>
