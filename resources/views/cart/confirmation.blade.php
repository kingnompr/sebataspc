<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Pesanan • SEBATAS PC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD@400,0,0&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#135bec',
                        accent: '#0f172a',
                        slate: {
                            850: '#101624',
                        },
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Noto Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        card: '0 20px 60px rgba(15,23,42,0.08)',
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Space Grotesk', 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-[#f4f6fb] text-slate-900">
    @php
        use Illuminate\Support\Str;
        $items = $cart->items ?? collect();
        $formatCurrency = static fn ($value) => 'Rp '.number_format($value ?? 0, 0, ',', '.');
    @endphp
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4 md:px-0">
                <div class="flex items-center gap-3 text-primary">
                    <span class="material-symbols-outlined text-3xl">memory</span>
                    <span class="text-lg font-semibold text-slate-900">PC Builder ID</span>
                </div>
                <nav class="hidden items-center gap-6 text-sm font-semibold text-slate-500 md:flex">
                    <a href="{{ route('pc-builds.builder') }}" class="hover:text-primary">Rakit PC</a>
                    <a href="{{ route('products.catalog') }}" class="hover:text-primary">Produk</a>
                    <a href="{{ route('products.catalog', ['search' => 'laptop']) }}" class="hover:text-primary">Laptop</a>
                </nav>
                <div class="hidden items-center gap-3 md:flex">
                    <div class="flex items-center rounded-2xl border border-slate-200 px-3 py-2 text-slate-400">
                        <span class="material-symbols-outlined text-base">search</span>
                        <input type="text" placeholder="Cari produk..." class="ml-2 bg-transparent text-sm focus:outline-none">
                    </div>
                    <a href="{{ route('cart.index') }}" class="flex size-10 items-center justify-center rounded-full border border-slate-200 text-slate-500">
                        <span class="material-symbols-outlined">shopping_cart</span>
                    </a>
                    <a href="{{ route('login') }}" class="flex size-10 items-center justify-center rounded-full border border-slate-200 text-slate-500">
                        <span class="material-symbols-outlined">person</span>
                    </a>
                </div>
            </div>
        </header>

        <main class="mx-auto w-full max-w-6xl px-4 py-10 md:px-0">
            <div class="rounded-3xl border border-slate-200 bg-white p-10 shadow-card">
                <div class="flex flex-col items-center text-center">
                    <div class="flex size-16 items-center justify-center rounded-full bg-emerald-100 text-emerald-500">
                        <span class="material-symbols-outlined text-3xl">check_circle</span>
                    </div>
                    <h1 class="mt-4 text-3xl font-semibold text-slate-900">Terima Kasih! Pesanan Dikonfirmasi</h1>
                    <p class="mt-2 text-sm text-slate-500">Kami telah mengirimkan email konfirmasi ke <span class="font-semibold">user@example.com</span>. Pesanan Anda sedang dipersiapkan.</p>
                    <p class="mt-1 text-xs text-slate-400">No. Pesanan: <span class="font-semibold text-primary">{{ $orderNumber }}</span></p>
                </div>

                <div class="mt-10 grid gap-8 lg:grid-cols-[minmax(0,1.2fr),minmax(0,0.8fr)]">
                    <div class="space-y-6">
                        <section class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                            <p class="text-sm font-semibold text-slate-900">Status Pengiriman</p>
                            <div class="mt-6 space-y-6">
                                @foreach($trackingTimeline as $index => $step)
                                    <div class="flex gap-4">
                                        <div class="flex flex-col items-center">
                                            @php
                                                $state = $step['status'];
                                                $icon = $state === 'done' ? 'check_circle' : ($state === 'active' ? 'package_2' : 'radio_button_unchecked');
                                                $color = $state === 'pending' ? 'text-slate-300' : 'text-primary';
                                            @endphp
                                            <span class="material-symbols-outlined {{ $color }}">{{ $icon }}</span>
                                            @if($index < count($trackingTimeline) - 1)
                                                <span class="block h-10 w-px bg-slate-200"></span>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-slate-900">{{ $step['label'] }}</p>
                                            <p class="text-xs text-slate-500">{{ $step['time'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section class="rounded-2xl border border-slate-200 bg-white p-6">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-slate-900">Rincian Produk</p>
                                <button type="button" onclick="window.print()" class="text-xs font-semibold text-primary hover:underline">Unduh Invoice</button>
                            </div>
                            <div class="mt-4 divide-y divide-slate-100 rounded-2xl border border-slate-100">
                                @forelse($items as $item)
                                    @php
                                        $product = $item->product;
                                        $image = $product->image ?? null;
                                        $isAbsolute = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));
                                        $imageUrl = $image ? ($isAbsolute ? $image : asset($image)) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80';
                                    @endphp
                                    <div class="flex gap-4 p-4">
                                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="size-16 rounded-xl object-cover">
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-slate-900">{{ $product->name }}</p>
                                            <p class="text-xs text-slate-500">{{ optional($product->category)->name }} • {{ Str::limit($product->description, 70) }}</p>
                                        </div>
                                        <div class="text-right text-sm text-slate-500">
                                            <p>Qty {{ $item->quantity }}</p>
                                            <p class="text-base font-semibold text-slate-900">{{ $formatCurrency(($product->price ?? 0) * $item->quantity) }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="p-6 text-center text-sm text-slate-500">Tidak ada item di pesanan.</p>
                                @endforelse
                            </div>
                            <dl class="mt-4 space-y-2 text-sm text-slate-600">
                                <div class="flex justify-between"><dt>Subtotal</dt><dd>{{ $formatCurrency($summary['subtotal']) }}</dd></div>
                                <div class="flex justify-between"><dt>Pengiriman</dt><dd>{{ $formatCurrency($summary['shipping']) }}</dd></div>
                                <div class="flex justify-between text-base font-semibold text-slate-900"><dt>Total</dt><dd>{{ $formatCurrency($summary['total']) }}</dd></div>
                            </dl>
                        </section>
                    </div>

                    <div class="space-y-6">
                        <section class="rounded-2xl border border-slate-200 bg-white p-6">
                            <p class="text-sm font-semibold text-slate-900">Alamat Pengiriman</p>
                            <div class="mt-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 text-sm text-slate-600">
                                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-400">Lokasi</p>
                                <p class="text-base font-semibold text-slate-900">{{ $shippingAddress['city'] }}</p>
                                <p class="mt-3 text-sm text-slate-600">{{ $shippingAddress['recipient'] }}</p>
                                <p class="text-sm text-slate-500">{{ $shippingAddress['address'] }}</p>
                                <p class="mt-2 text-sm text-slate-500">Telp: {{ $shippingAddress['phone'] }}</p>
                            </div>
                        </section>

                        <section class="rounded-2xl border border-slate-200 bg-white p-6">
                            <p class="text-sm font-semibold text-slate-900">Pembayaran</p>
                            <div class="mt-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 text-sm text-slate-600">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500">Metode</span>
                                    <span class="font-semibold text-slate-900">{{ $paymentSummary['method'] }}</span>
                                </div>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-slate-500">Status</span>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                                        <span class="material-symbols-outlined text-base">check</span>{{ $paymentSummary['status'] }}
                                    </span>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-2xl border border-slate-200 bg-white p-6">
                            <p class="text-sm font-semibold text-slate-900">Butuh bantuan?</p>
                            <p class="mt-2 text-sm text-slate-500">Jika ada kesalahan pada pesanan, hubungi kami segera.</p>
                            <a href="{{ route('pc-builds.builder') }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-primary bg-primary/5 px-4 py-2 text-sm font-semibold text-primary">
                                Chat WhatsApp
                            </a>
                        </section>

                        <div class="flex flex-col gap-3">
                            <a href="{{ route('account.overview') }}" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary py-3 text-sm font-semibold text-white shadow-card hover:bg-blue-600">Lacak Pesanan</a>
                            <a href="{{ route('home') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-300 py-3 text-sm font-semibold text-slate-600 hover:text-slate-900">Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="mx-auto flex w-full max-w-6xl flex-col gap-2 px-4 py-6 text-xs text-slate-500 md:flex-row md:items-center md:justify-between">
                <p>© {{ date('Y') }} PC Builder ID. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-slate-900">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-slate-900">Kebijakan Privasi</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
