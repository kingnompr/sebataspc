<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja • SEBATAS PC</title>
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
                        surface: '#050915',
                        card: '#0b1324',
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Noto Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        glow: '0 0 30px rgba(19,91,236,0.35)',
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Space Grotesk', 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #1c2442; border-radius: 999px; }
        ::-webkit-scrollbar-track { background: #050915; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-surface text-white">
    <div class="min-h-screen bg-gradient-to-b from-surface via-[#060c1c] to-[#02030a]">
        <header class="border-b border-white/5 bg-surface/80 backdrop-blur">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4 md:px-0">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-2xl border border-primary/40 bg-primary/15 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">shopping_bag</span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Sebatas PC</p>
                        <p class="text-lg font-semibold">PC Master • Cart</p>
                    </div>
                </div>
                <nav class="hidden items-center gap-6 text-sm text-slate-300 md:flex">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                    <a href="{{ route('pc-builds.builder') }}" class="hover:text-white transition">Rakit PC</a>
                    <a href="{{ route('products.catalog') }}" class="hover:text-white transition">Produk</a>
                </nav>
                <div class="flex items-center gap-3 text-sm">
                    <a href="{{ route('products.catalog') }}" class="hidden items-center gap-2 rounded-xl border border-white/10 px-4 py-2 text-slate-300 hover:border-primary/50 sm:inline-flex">
                        <span class="material-symbols-outlined text-base">arrow_back</span>
                        Lanjut Belanja
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 font-semibold text-white shadow-glow hover:bg-blue-600">
                        <span class="material-symbols-outlined text-base">person</span>
                        Akun
                    </a>
                </div>
            </div>
        </header>

        @php
            use Illuminate\Support\Str;
            $items = $cart->items ?? collect();
            $formatCurrency = static fn ($value) => 'Rp '.number_format($value ?? 0, 0, ',', '.');
            $subtotal = $items->sum(function ($item) {
                $price = optional($item->product)->price ?? 0;
                return $price * ($item->quantity ?? 0);
            });
            $discount = 0;
            $serviceFee = $items->isEmpty() ? 0 : 1000;
            $shipping = 0;
            $total = $subtotal - $discount + $serviceFee + $shipping;
            $itemCount = $items->sum('quantity');
            $recommendedItems = ($recommended ?? collect())->take(4);
        @endphp

        <main class="mx-auto w-full max-w-6xl px-4 py-10 md:px-0">
            <div class="text-xs uppercase tracking-[0.4em] text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <span>Keranjang Belanja</span>
            </div>

            <div class="mt-6 flex flex-col gap-6 lg:flex-row">
                <section class="flex-1 space-y-4">
                    <div>
                        <h1 class="text-3xl font-semibold">Keranjang Belanja</h1>
                        <p class="text-sm text-slate-400">Anda memiliki {{ $itemCount }} item siap untuk checkout.</p>
                    </div>

                    <div class="rounded-3xl border border-white/5 bg-card/80 p-4 shadow-2xl">
                        <div class="grid grid-cols-[1fr,140px,150px,60px] items-center gap-4 px-4 pb-4 text-xs uppercase tracking-[0.3em] text-slate-500">
                            <span>Produk</span>
                            <span class="text-center">Jumlah</span>
                            <span class="text-right">Total</span>
                            <span></span>
                        </div>
                        <div class="space-y-3">
                            @forelse($items as $item)
                                @php
                                    $product = $item->product;
                                    $price = $product->price ?? 0;
                                    $lineTotal = $price * $item->quantity;
                                    $image = $product->image ?? null;
                                    $isAbsolute = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));
                                    $imageUrl = $image ? ($isAbsolute ? $image : asset($image)) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80';
                                    $badge = match (true) {
                                        $product && $product->stock <= 3 => ['Low Stock', 'text-amber-400 border-amber-400/40 bg-amber-400/10'],
                                        default => ['In Stock', 'text-emerald-400 border-emerald-400/40 bg-emerald-400/10'],
                                    };
                                @endphp
                                <article class="grid grid-cols-[1fr,140px,150px,60px] items-center gap-4 rounded-2xl border border-white/5 bg-[#0f1529] p-4">
                                    <div class="flex items-center gap-4">
                                        <div class="relative size-20 overflow-hidden rounded-2xl">
                                            <img src="{{ $imageUrl }}" alt="{{ $product->name ?? 'Produk' }}" class="h-full w-full object-cover">
                                            <span class="absolute left-2 top-2 rounded-full border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.3em] {{ $badge[1] }}">{{ $badge[0] }}</span>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <p class="text-sm font-semibold">{{ $product->name ?? 'Produk tidak tersedia' }}</p>
                                            <p class="text-xs text-slate-400">{{ optional($product->category)->name }}</p>
                                            <p class="text-xs text-slate-500">{{ Str::limit($product->description ?? 'Item telah dihapus.', 80) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <form method="POST" action="{{ route('cart.items.update', $item) }}" class="flex items-center gap-2 rounded-2xl border border-white/10 bg-black/20 px-3 py-1 quantity-form" data-item="{{ $item->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                                            <button type="button" class="quantity-step rounded-2xl bg-white/5 px-2 py-1 text-lg" data-step="-1">−</button>
                                            <span class="w-6 text-center text-sm font-semibold" data-quantity-display>{{ $item->quantity }}</span>
                                            <button type="button" class="quantity-step rounded-2xl bg-white/5 px-2 py-1 text-lg" data-step="1">+</button>
                                        </form>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-base font-semibold">{{ $formatCurrency($lineTotal) }}</p>
                                        <p class="text-xs text-slate-500">{{ $formatCurrency($price) }} / unit</p>
                                    </div>
                                    <div class="flex justify-end">
                                        <form method="POST" action="{{ route('cart.items.destroy', $item) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-2xl border border-white/10 p-2 text-slate-400 hover:border-rose-500/40 hover:text-rose-400">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-2xl border border-dashed border-white/10 p-10 text-center text-slate-400">
                                    Keranjang Anda kosong. <a href="{{ route('products.catalog') }}" class="text-primary">Belanja sekarang</a> untuk menambahkan produk.
                                </div>
                            @endforelse
                        </div>
                        @if($items->isNotEmpty())
                            <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                                <a href="{{ route('products.catalog') }}" class="text-sm font-semibold text-primary">← Belanja produk lainnya</a>
                                <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Kosongkan keranjang?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-slate-400 hover:text-rose-400">Kosongkan keranjang</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </section>

                <aside class="w-full max-w-md space-y-4">
                    <div class="rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl">
                        <div class="flex items-center justify-between">
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Ringkasan Pesanan</p>
                            <span class="text-xs text-slate-500">{{ $itemCount }} barang</span>
                        </div>
                        <dl class="mt-4 space-y-3 text-sm text-slate-300">
                            <div class="flex justify-between">
                                <dt>Total Harga</dt>
                                <dd>{{ $formatCurrency($subtotal) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Diskon Barang</dt>
                                <dd class="text-emerald-400">{{ $formatCurrency(-$discount) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Estimasi Ongkir</dt>
                                <dd class="text-emerald-400">Gratis</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Biaya Layanan</dt>
                                <dd>{{ $formatCurrency($serviceFee) }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6 flex items-center justify-between border-t border-white/5 pt-4">
                            <p class="text-sm text-slate-400">Total Tagihan</p>
                            <p class="text-2xl font-semibold">{{ $formatCurrency($total) }}</p>
                        </div>
                        @if($items->isEmpty())
                            <span class="mt-4 block w-full rounded-2xl bg-primary/40 py-3 text-center text-sm font-semibold text-white/70">Checkout Sekarang →</span>
                        @else
                            <a href="{{ route('checkout.show') }}" class="mt-4 block w-full rounded-2xl bg-primary py-3 text-center text-sm font-semibold text-white shadow-glow hover:bg-blue-600">
                                Checkout Sekarang →
                            </a>
                        @endif
                        <p class="mt-3 text-center text-xs text-slate-600">Transaksi Anda dilindungi & aman.</p>
                    </div>

                    <div class="rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl">
                        <div class="flex items-center gap-3">
                            <div class="rounded-2xl bg-primary/10 p-3 text-primary">
                                <span class="material-symbols-outlined">support_agent</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold">Butuh bantuan rakit?</p>
                                <p class="text-xs text-slate-400">Tim ekspert siap bantu spesifikasi impianmu.</p>
                            </div>
                        </div>
                        <a href="{{ route('pc-builds.builder') }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-white/10 px-4 py-2 text-sm font-semibold text-primary hover:border-primary/40">
                            Chat Tim Support →
                        </a>
                    </div>
                </aside>
            </div>

            @if($recommendedItems->isNotEmpty())
                <section class="mt-10 rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Sering dibeli bersama</p>
                            <h2 class="text-2xl font-semibold">Lengkapi setup kamu</h2>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach($recommendedItems as $product)
                            @php
                                $image = $product->image ?? null;
                                $isAbsolute = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));
                                $imageUrl = $image ? ($isAbsolute ? $image : asset($image)) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80';
                            @endphp
                            <article class="rounded-2xl border border-white/5 bg-[#0f1529] p-4 transition hover:border-primary/40">
                                <div class="overflow-hidden rounded-2xl">
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="h-36 w-full object-cover">
                                </div>
                                <div class="mt-4 space-y-1">
                                    <p class="text-sm font-semibold">{{ $product->name }}</p>
                                    <p class="text-xs text-slate-400">{{ optional($product->category)->name }}</p>
                                    <p class="text-base font-bold">{{ $formatCurrency($product->price) }}</p>
                                </div>
                                <form method="POST" action="{{ route('cart.items.store') }}" class="mt-4 flex items-center justify-between">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-xs font-semibold text-slate-400 hover:text-white">Detail</a>
                                    <button type="submit" class="rounded-2xl bg-primary/90 px-3 py-2 text-xs font-semibold text-white shadow-glow hover:bg-blue-600">
                                        + Tambah
                                    </button>
                                </form>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>

    <script>
        document.querySelectorAll('.quantity-form').forEach((form) => {
            const hiddenInput = form.querySelector('input[name="quantity"]');
            const display = form.querySelector('[data-quantity-display]');
            form.querySelectorAll('.quantity-step').forEach((button) => {
                button.addEventListener('click', () => {
                    const step = Number(button.dataset.step || 1);
                    let value = Number(hiddenInput.value || 1);
                    value = Math.max(1, value + step);
                    hiddenInput.value = value;
                    if (display) {
                        display.textContent = value;
                    }
                    form.submit();
                });
            });
        });
    </script>
</body>
</html>
