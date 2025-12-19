<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout • SEBATAS PC</title>
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
                        surface: '#f3f4f6',
                        slate: {
                            950: '#0f172a',
                        },
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Noto Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        card: '0 20px 50px rgba(15,23,42,0.08)',
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
<body class="bg-surface text-slate-900">
    @php
        use Illuminate\Support\Str;
        $items = $cart->items ?? collect();
        $formatCurrency = static fn ($value) => 'Rp '.number_format($value ?? 0, 0, ',', '.');
    @endphp
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4 md:px-0">
                <div class="flex items-center gap-4">
                    <div class="flex size-11 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                        <span class="material-symbols-outlined">security</span>
                    </div>
                    <div>
                        <p class="text-lg font-semibold">Rakitan PC Store</p>
                        <p class="text-xs text-slate-500">Checkout aman & terenkripsi 256-bit</p>
                    </div>
                </div>
                <div class="hidden items-center gap-6 text-sm font-semibold md:flex">
                    <span class="text-primary">Pengiriman</span>
                    <span class="text-primary/70">Pembayaran</span>
                    <span class="text-slate-400">Selesai</span>
                </div>
                <a href="{{ route('cart.index') }}" class="text-sm font-semibold text-primary">← Kembali ke Keranjang</a>
            </div>
        </header>

        <main class="mx-auto w-full max-w-6xl px-4 py-10 md:px-0">
            <div class="text-sm text-slate-500">
                Home <span class="mx-2">/</span> Keranjang <span class="mx-2">/</span> <span class="text-slate-900 font-semibold">Checkout</span>
            </div>
            <h1 class="mt-4 text-3xl font-semibold text-slate-900">Checkout</h1>
            <p class="text-sm text-slate-500">Selesaikan pesanan PC impian Anda.</p>

            <form method="POST" action="{{ route('checkout.process') }}" class="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1.7fr),minmax(320px,0.8fr)]">
                @csrf
                <section class="space-y-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-card">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-primary">1. Informasi Pengiriman</p>
                                <p class="text-sm text-slate-500">Masukkan alamat lengkap untuk pengiriman.</p>
                            </div>
                        </div>
                        <div class="mt-6 grid gap-4 md:grid-cols-2">
                            <label class="text-sm font-semibold text-slate-600">Nama Depan
                                <input type="text" name="first_name" value="" placeholder="Masukkan nama depan" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </label>
                            <label class="text-sm font-semibold text-slate-600">Nama Belakang
                                <input type="text" name="last_name" value="" placeholder="Masukkan nama belakang" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </label>
                            <label class="md:col-span-2 text-sm font-semibold text-slate-600">Alamat Lengkap
                                <input type="text" name="address" value="" placeholder="Jl. Nama Jalan No. 123, Kav 10" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </label>
                            <label class="text-sm font-semibold text-slate-600">Kota / Kabupaten
                                <input type="text" name="city" value="" placeholder="Jakarta Pusat" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </label>
                            <label class="text-sm font-semibold text-slate-600">Kode Pos
                                <input type="text" name="postal_code" value="" placeholder="10220" pattern="[0-9]*" inputmode="numeric" maxlength="5" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </label>
                            <label class="md:col-span-2 text-sm font-semibold text-slate-600">Nomor Telepon
                                <input type="tel" name="phone" value="" placeholder="081234567890" pattern="[0-9]*" inputmode="numeric" maxlength="15" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </label>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-card">
                        <p class="text-xs font-semibold uppercase tracking-[0.4em] text-primary">2. Metode Pengiriman</p>
                        <p class="text-sm text-slate-500">Pilih metode pengiriman terbaik untukmu.</p>
                        <div class="mt-4 space-y-3">
                            @foreach($shippingOptions as $option)
                                @php $active = $option['id'] === $selectedShippingId; @endphp
                                <label class="flex flex-col gap-2 rounded-2xl border px-4 py-4 transition @if($active) border-primary bg-primary/5 @else border-slate-200 hover:border-primary/40 @endif">
                                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <div class="flex items-start gap-3">
                                            <input type="radio" name="shipping_method" value="{{ $option['id'] }}" @checked($active) required class="mt-1 size-4 text-primary focus:ring-primary">
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">{{ $option['label'] }}</p>
                                                <p class="text-xs text-slate-500">{{ $option['description'] }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-base font-semibold text-slate-900">{{ $formatCurrency($option['price']) }}</p>
                                            @if(!empty($option['badge']))
                                                <span class="text-xs font-semibold uppercase tracking-wide text-primary">{{ $option['badge'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-card">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-primary">3. Metode Pembayaran</p>
                                <p class="text-sm text-slate-500">Pilih salah satu metode pembayaran yang tersedia.</p>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-400">
                                <span class="material-symbols-outlined text-base">lock</span>
                                Enkripsi 256-bit
                            </div>
                        </div>
                        <div class="mt-4 space-y-3">
                            <!-- COD Option -->
                            <label class="rounded-2xl border-2 border-primary bg-primary/5 p-4 cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="cod" checked required class="size-4 text-primary focus:ring-primary">
                                        <span class="material-symbols-outlined text-primary">payments</span>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">Cash on Delivery (COD)</p>
                                            <p class="text-xs text-slate-500">Bayar saat barang diterima</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            
                            <!-- Bank Transfer Options -->
                            <div class="space-y-2">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Transfer Bank</p>
                                <label class="rounded-2xl border border-slate-200 p-4 hover:border-primary hover:bg-primary/5 cursor-pointer transition-colors block">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="bank_mandiri" required class="size-4 text-primary focus:ring-primary">
                                        <div class="flex size-10 items-center justify-center rounded-lg bg-blue-100 font-bold text-blue-600">M</div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">Bank MANDIRI</p>
                                            <p class="text-xs text-slate-500">Transfer via Virtual Account</p>
                                        </div>
                                    </div>
                                </label>
                                <label class="rounded-2xl border border-slate-200 p-4 hover:border-primary hover:bg-primary/5 cursor-pointer transition-colors block">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="bank_bca" required class="size-4 text-primary focus:ring-primary">
                                        <div class="flex size-10 items-center justify-center rounded-lg bg-blue-600 font-bold text-white">BCA</div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">Bank BCA</p>
                                            <p class="text-xs text-slate-500">Transfer via Virtual Account</p>
                                        </div>
                                    </div>
                                </label>
                                <label class="rounded-2xl border border-slate-200 p-4 hover:border-primary hover:bg-primary/5 cursor-pointer transition-colors block">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="bank_bri" required class="size-4 text-primary focus:ring-primary">
                                        <div class="flex size-10 items-center justify-center rounded-lg bg-blue-500 font-bold text-white">BRI</div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">Bank BRI</p>
                                            <p class="text-xs text-slate-500">Transfer via Virtual Account</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            
                            <!-- E-Wallet Options -->
                            <div class="space-y-2">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">E-Wallet</p>
                                <label class="rounded-2xl border border-slate-200 p-4 hover:border-primary hover:bg-primary/5 cursor-pointer transition-colors block">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="dana" required class="size-4 text-primary focus:ring-primary">
                                        <div class="flex size-10 items-center justify-center rounded-lg bg-blue-500 font-bold text-white">DA</div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">DANA</p>
                                            <p class="text-xs text-slate-500">Bayar dengan saldo DANA</p>
                                        </div>
                                    </div>
                                </label>
                                <label class="rounded-2xl border border-slate-200 p-4 hover:border-primary hover:bg-primary/5 cursor-pointer transition-colors block">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="gopay" required class="size-4 text-primary focus:ring-primary">
                                        <div class="flex size-10 items-center justify-center rounded-lg bg-emerald-500 font-bold text-white">GP</div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">GOPAY</p>
                                            <p class="text-xs text-slate-500">Bayar dengan saldo GOPAY</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </section>

                <aside class="space-y-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-card">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-slate-900">Ringkasan Pesanan</p>
                            <span class="text-xs text-slate-400">{{ $items->sum('quantity') }} barang</span>
                        </div>
                        <div class="mt-4 space-y-4">
                            @forelse($items as $item)
                                @php
                                    $product = $item->product;
                                    $image = $product->image ?? null;
                                    $isAbsolute = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));
                                    $imageUrl = $image ? ($isAbsolute ? $image : asset(ltrim($image, '/'))) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80';
                                @endphp
                                <div class="flex gap-3 rounded-2xl border border-slate-100 p-3">
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="size-16 rounded-xl object-cover">
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-slate-900">{{ $product->name }}</p>
                                        <p class="text-xs text-slate-500">{{ Str::limit($product->description, 60) }}</p>
                                        <div class="mt-2 flex items-center justify-between text-xs text-slate-500">
                                            <span>Qty {{ $item->quantity }}</span>
                                            <span class="font-semibold text-slate-900">{{ $formatCurrency(($product->price ?? 0) * $item->quantity) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="rounded-2xl border border-dashed border-slate-200 p-4 text-center text-sm text-slate-500">Keranjang Anda kosong.</p>
                            @endforelse
                        </div>
                        <div class="mt-6 space-y-3 text-sm text-slate-600">
                            <div class="flex justify-between"><span>Subtotal</span><span>{{ $formatCurrency($summary['subtotal']) }}</span></div>
                            <div class="flex justify-between"><span>Biaya Pengiriman</span><span>{{ $formatCurrency($summary['shipping']) }}</span></div>
                            <div class="flex justify-between"><span>Asuransi (0.2%)</span><span>{{ $formatCurrency($summary['insurance']) }}</span></div>
                            <div class="flex justify-between text-emerald-500"><span>Diskon</span><span>-{{ $formatCurrency($summary['discount']) }}</span></div>
                        </div>

                        <div class="mt-6 flex items-center justify-between border-t border-slate-200 pt-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Total Bayar</p>
                                <p class="text-2xl font-semibold text-slate-900">{{ $formatCurrency($summary['total']) }}</p>
                            </div>
                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-emerald-600">Checkout Aman</span>
                        </div>
                        @if($items->isEmpty())
                            <span class="mt-4 block w-full rounded-2xl bg-slate-200 py-3 text-center text-sm font-semibold text-slate-500">Tambahkan produk untuk bayar</span>
                        @else
                            <button type="submit" class="mt-4 block w-full rounded-2xl bg-primary py-3 text-center text-sm font-semibold text-white shadow-card hover:bg-blue-600">Konfirmasi & Bayar</button>
                        @endif
                        <p class="mt-3 text-center text-xs text-slate-400">Dengan membayar, Anda menyetujui Syarat & Ketentuan kami.</p>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-card">
                        <p class="text-sm font-semibold text-slate-900">Butuh bantuan?</p>
                        <p class="text-sm text-slate-500">Tim kami siap membantu konfigurasi custom dan status pengiriman.</p>
                        <a href="{{ route('pc-builds.builder') }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-primary hover:border-primary/50">
                            Hubungi Support →
                        </a>
                    </div>
                </aside>
            </form>
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="mx-auto flex w-full max-w-6xl flex-col gap-2 px-4 py-6 text-xs text-slate-500 md:flex-row md:items-center md:justify-between">
                <p>© {{ date('Y') }} Rakitan PC Store. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-slate-900">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-slate-900">Bantuan</a>
                    <a href="#" class="hover:text-slate-900">Hubungi Kami</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
