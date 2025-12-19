<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Daftar Keinginan Saya - Sebatas PC</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "accent": "#1e293b",
                    },
                    fontFamily: {
                        "display": ["Space Grotesk", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #334155; }
    </style>
</head>
<body class="bg-[#0a0f1a] text-white font-body antialiased">
    @php
        $categories = \App\Models\Category::all();
        $activeCategory = request('category');
    @endphp

    <!-- Header -->
    <div class="sticky top-0 z-50 border-b border-white/10 bg-[#0a0f1a]/80 backdrop-blur-md">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <header class="flex items-center justify-between py-3">
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-4xl text-primary">memory</span>
                        <h2 class="hidden text-xl font-bold md:block">Sebatas PC</h2>
                    </a>
                    <nav class="hidden items-center gap-6 lg:flex">
                        <a href="{{ route('products.catalog') }}" class="text-sm font-medium text-slate-300 transition-colors hover:text-white">Produk</a>
                        <a href="{{ route('pc-builds.catalog') }}" class="text-sm font-medium text-slate-300 transition-colors hover:text-white">Rakit PC</a>
                        <a href="{{ route('pc-builds.builder') }}" class="text-sm font-medium text-primary transition-colors hover:text-white">PC Builder Pro</a>
                        <a href="{{ route('help.index') }}" class="text-sm font-medium text-slate-300 transition-colors hover:text-white">Bantuan</a>
                    </nav>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('cart.index') }}" class="relative">
                        <span class="material-symbols-outlined text-2xl text-slate-300 hover:text-white">shopping_cart</span>
                        @auth
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->first()?->items()->count() ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary text-xs font-semibold">{{ $cartCount }}</span>
                            @endif
                        @endauth
                    </a>
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 rounded-full bg-white/5 px-3 py-1.5 text-sm font-medium hover:bg-white/10">
                                <span class="material-symbols-outlined text-lg">person</span>
                                <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                                <span class="material-symbols-outlined text-lg">expand_more</span>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 rounded-xl border border-white/10 bg-accent p-2 shadow-xl">
                                <a href="{{ route('account.overview') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-white/5">
                                    <span class="material-symbols-outlined text-lg">account_circle</span>
                                    Akun Saya
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-white/5">
                                    <span class="material-symbols-outlined text-lg">favorite</span>
                                    Daftar Keinginan
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-white/5">
                                        <span class="material-symbols-outlined text-lg">logout</span>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold hover:bg-primary/90">Masuk</a>
                    @endauth
                </div>
            </header>
        </div>
    </div>

    <!-- Main Content -->
    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold">Daftar Keinginan Saya</h1>
                <p class="mt-1 text-sm text-slate-400">{{ $wishlists->count() }} Item tersimpan</p>
            </div>
            <div class="flex flex-wrap gap-3">
                @if($wishlists->isNotEmpty())
                    <form method="POST" action="{{ route('wishlist.clear') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus semua item dari daftar keinginan?')" class="flex items-center gap-2 rounded-lg border border-white/10 px-4 py-2 text-sm font-medium hover:bg-white/5">
                            <span class="material-symbols-outlined text-lg">delete</span>
                            Hapus Semua
                        </button>
                    </form>
                    <form method="POST" action="{{ route('wishlist.add-all-to-cart') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-semibold hover:bg-primary/90">
                            <span class="material-symbols-outlined text-lg">shopping_cart</span>
                            Tambahkan Semua
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-4">
                <p class="text-sm text-emerald-400">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 rounded-xl border border-rose-500/20 bg-rose-500/10 p-4">
                <p class="text-sm text-rose-400">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Category Filters -->
        <div class="mb-6 flex flex-wrap gap-3">
            <a href="{{ route('wishlist.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium {{ !$activeCategory ? 'bg-primary text-white' : 'bg-accent text-slate-300 hover:bg-white/5' }}">
                Semua
            </a>
            @foreach($categories as $category)
                <a href="{{ route('wishlist.index', ['category' => $category->id]) }}" class="rounded-lg px-4 py-2 text-sm font-medium {{ $activeCategory == $category->id ? 'bg-primary text-white' : 'bg-accent text-slate-300 hover:bg-white/5' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Wishlist Grid -->
        @if($wishlists->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <span class="material-symbols-outlined mb-4 text-6xl text-slate-600">favorite_border</span>
                <h3 class="mb-2 text-xl font-semibold">Daftar Keinginan Kosong</h3>
                <p class="mb-6 text-slate-400">Belum ada produk yang Anda simpan</p>
                <a href="{{ route('products.catalog') }}" class="rounded-lg bg-primary px-6 py-3 font-semibold hover:bg-primary/90">
                    Jelajahi Produk
                </a>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($wishlists as $wishlist)
                    @php
                        $product = $wishlist->product;
                        $isAvailable = $product->stock > 0;
                        $stockBadge = $product->stock > 10 ? 'Tersedia' : ($product->stock > 0 ? 'Stok Menipis' : 'Habis');
                        $stockClass = $product->stock > 10 ? 'bg-emerald-500/20 text-emerald-400' : ($product->stock > 0 ? 'bg-amber-500/20 text-amber-400' : 'bg-slate-500/20 text-slate-400');
                    @endphp
                    
                    <div class="group relative rounded-2xl border border-white/10 bg-accent p-4 transition-all hover:border-primary/50">
                        <!-- Stock Badge -->
                        <span class="absolute left-4 top-4 z-10 rounded-lg px-2 py-1 text-xs font-semibold {{ $stockClass }}">
                            {{ $stockBadge }}
                        </span>

                        <!-- Product Image -->
                        <a href="{{ route('products.show', $product->slug) }}" class="mb-4 block aspect-square overflow-hidden rounded-xl bg-white/5">
                            <img src="{{ $product->image ?? 'https://images.unsplash.com/photo-1591799265444-d66432b91588?auto=format&fit=crop&w=400' }}" 
                                 alt="{{ $product->name }}" 
                                 class="h-full w-full object-cover transition-transform group-hover:scale-105"/>
                        </a>

                        <!-- Product Info -->
                        <div class="mb-4">
                            <p class="mb-1 text-xs font-medium uppercase text-primary">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            <a href="{{ route('products.show', $product->slug) }}" class="mb-2 line-clamp-2 text-sm font-semibold hover:text-primary">
                                {{ $product->name }}
                            </a>
                            <div class="flex items-baseline gap-2">
                                <p class="text-lg font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                @if($product->original_price && $product->original_price > $product->price)
                                    <p class="text-xs text-slate-500 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            @if($isAvailable)
                                <form method="POST" action="{{ route('cart.items.store') }}" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-semibold hover:bg-primary/90">
                                        <span class="material-symbols-outlined text-lg">shopping_cart</span>
                                        Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-white/5 px-4 py-2 text-sm font-semibold text-slate-500 cursor-not-allowed">
                                    <span class="material-symbols-outlined text-lg">notifications</span>
                                    Ingatkan Saya
                                </button>
                            @endif
                            
                            <form method="POST" action="{{ route('wishlist.destroy', $wishlist) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-white/10 p-2 hover:border-rose-500 hover:bg-rose-500/10">
                                    <span class="material-symbols-outlined text-lg text-rose-400">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="mt-16 border-t border-white/10 bg-accent py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center text-sm text-slate-400">
                <p>&copy; 2025 Sebatas PC. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
