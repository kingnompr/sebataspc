<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $order->order_number }} • SEBATAS PC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD@400,0,0&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <style>
        body { font-family: 'Space Grotesk', 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900">
    @php
        $formatCurrency = static fn ($value) => 'Rp '.number_format($value ?? 0, 0, ',', '.');
        $statusMap = [
            'pending' => ['Menunggu Pembayaran', 'bg-amber-100 text-amber-600'],
            'paid' => ['Pembayaran Terverifikasi', 'bg-blue-100 text-blue-600'],
            'processing' => ['Sedang Diproses', 'bg-indigo-100 text-indigo-600'],
            'qc' => ['Quality Check', 'bg-purple-100 text-purple-600'],
            'shipped' => ['Dalam Pengiriman', 'bg-amber-100 text-amber-600'],
            'delivered' => ['Selesai', 'bg-emerald-100 text-emerald-600'],
            'cancelled' => ['Dibatalkan', 'bg-rose-100 text-rose-600'],
        ];
        [$statusLabel, $statusClass] = $statusMap[$order->status] ?? ['Status Tidak Dikenal', 'bg-slate-100 text-slate-600'];
    @endphp

    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex w-full max-w-5xl items-center justify-between px-4 py-5">
                <div>
                    <p class="text-xs font-semibold tracking-[0.35em] text-slate-400">SEBATAS PC</p>
                    <h1 class="text-2xl font-semibold">Invoice {{ $order->order_number }}</h1>
                    <p class="text-sm text-slate-500">Dipesan pada {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
                <div class="flex items-center gap-3 no-print">
                    <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-2xl border border-primary bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                        <span class="material-symbols-outlined text-base">download</span>
                        Unduh PDF
                    </button>
                    <a href="{{ route('account.overview') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">← Kembali ke Akun</a>
                </div>
            </div>
        </header>

        <main class="mx-auto w-full max-w-5xl px-4 py-10">
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1.4fr),minmax(0,0.8fr)]">
                <section class="space-y-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Status Pesanan</p>
                                <h2 class="text-xl font-semibold text-slate-900">{{ $statusLabel }}</h2>
                            </div>
                            <span class="rounded-full px-4 py-1 text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>
                        <div class="mt-6 space-y-3">
                            @foreach($order->items as $item)
                                @php
                                    $product = $item->product;
                                @endphp
                                <div class="flex items-start justify-between rounded-2xl border border-slate-100 p-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $item->name }}</p>
                                        <p class="text-xs text-slate-500">Qty {{ $item->quantity }} • {{ $formatCurrency($item->price) }}</p>
                                        @if($product && $product->category)
                                            <p class="text-xs text-slate-400">Kategori: {{ $product->category->name }}</p>
                                        @endif
                                    </div>
                                    <p class="text-sm font-semibold text-slate-900">{{ $formatCurrency($item->price * $item->quantity) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6">
                        <p class="text-sm font-semibold text-slate-900">Ringkasan Pembayaran</p>
                        <div class="mt-4 space-y-3 text-sm text-slate-600">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>{{ $formatCurrency($order->subtotal) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Ongkos Kirim</span>
                                <span>{{ $formatCurrency($order->shipping_fee) }}</span>
                            </div>
                            <div class="flex justify-between text-emerald-600">
                                <span>Diskon</span>
                                <span>-{{ $formatCurrency($order->discount) }}</span>
                            </div>
                            <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-semibold text-slate-900">
                                <span>Total Dibayar</span>
                                <span>{{ $formatCurrency($order->total) }}</span>
                            </div>
                        </div>
                    </div>
                </section>

                <aside class="space-y-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6">
                        <p class="text-sm font-semibold text-slate-900">Alamat Penagihan</p>
                        @if($address)
                            <p class="mt-2 text-sm text-slate-600">
                                {{ $address->recipient }}<br>
                                {{ $address->line_one }}<br>
                                @if($address->line_two)
                                    {{ $address->line_two }}<br>
                                @endif
                                {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}<br>
                                {{ $address->phone }}
                            </p>
                        @else
                            <p class="mt-2 text-sm text-slate-500">Belum ada alamat default.</p>
                        @endif
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6">
                        <p class="text-sm font-semibold text-slate-900">Detail Pengiriman</p>
                        <p class="mt-2 text-sm text-slate-500">
                            Kurir: {{ $order->courier ?? 'Menunggu penjadwalan' }}<br>
                            Estimasi Tiba: {{ optional($order->estimated_delivery_at)->translatedFormat('d M Y') ?? 'Segera dikonfirmasi' }}
                        </p>
                        <a href="{{ route('account.overview') }}" class="mt-4 inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">
                            <span class="material-symbols-outlined text-base">chat</span>
                            Hubungi Support
                        </a>
                    </div>
                </aside>
            </div>
        </main>
    </div>
</body>
</html>
