<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Produk • SEBATAS PC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#135bec',
                        surface: '#050915',
                        card: '#11182a',
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Noto Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        glow: '0 0 25px rgba(19,91,236,0.25)',
                    },
                },
            },
        };
    </script>
    <style>
        body {
            font-family: 'Space Grotesk', 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #050915; }
        ::-webkit-scrollbar-thumb { background: #1d2540; border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: #2c3657; }
    </style>
</head>
<body class="bg-surface text-white">
    <div class="min-h-screen bg-gradient-to-b from-surface via-[#070d1c] to-[#03060e]">
        <header class="border-b border-white/5 bg-surface/80 backdrop-blur">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4 md:px-0">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-2xl bg-primary/20 border border-primary/40 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-2xl">memory</span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Sebatas PC</p>
                        <p class="text-lg font-semibold">PC Master • Katalog</p>
                    </div>
                </div>
                <nav class="hidden md:flex items-center gap-6 text-sm text-slate-300">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                    <a href="{{ route('pc-builds.builder') }}" class="hover:text-white transition">Rakit PC</a>
                    <a class="text-primary font-semibold" href="{{ route('products.catalog') }}">Produk</a>
                </nav>
                <div class="flex items-center gap-3 text-sm">
                    <a href="{{ route('cart.index') }}" class="relative flex size-10 cursor-pointer items-center justify-center rounded-xl border border-white/10 hover:border-primary/50 text-slate-300 hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
                        @php
                            $cart = App\Models\Cart::where('session_id', session()->getId())
                                ->orWhere('user_id', auth()->id())
                                ->first();
                            $cartCount = $cart ? $cart->items()->sum('quantity') : 0;
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold">{{ $cartCount }}</span>
                        @endif
                    </a>
                    @auth
                        <a href="{{ route('account.overview') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-4 py-2 text-slate-300 hover:border-primary/50">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="size-6 rounded-full object-cover">
                            @else
                                <div class="size-6 rounded-full bg-primary/20 flex items-center justify-center text-xs font-bold text-primary">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            Profil
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-2 rounded-xl border border-white/10 px-4 py-2 text-slate-300 hover:border-primary/50">
                            <span class="material-symbols-outlined text-base">person</span>
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 font-semibold text-white shadow-glow hover:bg-blue-600">
                            <span class="material-symbols-outlined text-base">bolt</span>
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        @php
            use Illuminate\Support\Str;
            $formatCurrency = static fn ($value) => 'Rp '.number_format($value ?? 0, 0, ',', '.');
            $quickCategories = $categories->take(4);
            $baseQuery = request()->except('page');
            $categoryResetQuery = $baseQuery;
            unset($categoryResetQuery['categories']);
            $gridQuery = array_merge($baseQuery, ['view' => 'grid']);
            $listQuery = array_merge($baseQuery, ['view' => 'list']);
        @endphp

        <main class="mx-auto w-full max-w-6xl px-4 py-10 md:px-0">
            <div class="mb-8 flex flex-col gap-2">
                <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Home / Produk</p>
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h1 class="text-3xl font-semibold">Katalog Produk</h1>
                        <p class="text-sm text-slate-400">Jelajahi ribuan produk berkualitas untuk build impianmu.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('products.catalog', $categoryResetQuery) }}" class="rounded-full border px-4 py-2 text-xs font-semibold tracking-wide @if(!$selectedCategories) border-primary bg-primary/10 text-white @else border-white/10 text-slate-300 hover:border-primary/30 @endif">Semua</a>
                        @foreach($quickCategories as $category)
                            @php
                                $isActive = in_array($category->id, $selectedCategories ?? []);
                                $currentCategories = $selectedCategories ?? [];
                                $nextCategories = $isActive
                                    ? array_values(array_diff($currentCategories, [$category->id]))
                                    : array_values(array_unique(array_merge($currentCategories, [$category->id])));

                                $query = $baseQuery;
                                if (empty($nextCategories)) {
                                    unset($query['categories']);
                                } else {
                                    $query['categories'] = $nextCategories;
                                }
                            @endphp
                            <a href="{{ route('products.catalog', $query) }}" class="rounded-full border px-4 py-2 text-xs font-semibold tracking-wide @if($isActive) border-primary bg-primary/10 text-white @else border-white/10 text-slate-300 hover:border-primary/30 @endif">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-[300px,1fr]">
                <aside>
                    <form method="GET" action="{{ route('products.catalog') }}" id="filtersForm" class="space-y-6 rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl">
                        <input type="hidden" name="view" value="{{ $viewMode }}">
                        <div>
                            <label for="search" class="text-xs uppercase tracking-[0.4em] text-slate-500">Filter nama produk</label>
                            <div class="mt-2 flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-3 py-2">
                                <span class="material-symbols-outlined text-base text-slate-400">search</span>
                                <input type="text" id="search" name="search" value="{{ $search }}" placeholder="Cari produk..." class="w-full bg-transparent text-sm focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between text-xs uppercase tracking-[0.4em] text-slate-500">
                                <span>Rentang Harga</span>
                                <a href="{{ route('products.catalog') }}" class="text-primary">Reset</a>
                            </div>
                            <div class="mt-3 space-y-3 rounded-2xl border border-white/10 bg-white/5 p-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1">
                                        <label class="text-[11px] uppercase tracking-[0.3em] text-slate-500">Min</label>
                                        <input type="number" name="price_min" value="{{ (int) $priceMin }}" min="0" class="mt-1 w-full rounded-xl border border-white/10 bg-transparent px-3 py-2 text-sm">
                                    </div>
                                    <div class="flex-1">
                                        <label class="text-[11px] uppercase tracking-[0.3em] text-slate-500">Max</label>
                                        <input type="number" name="price_max" value="{{ (int) $priceMax }}" min="0" class="mt-1 w-full rounded-xl border border-white/10 bg-transparent px-3 py-2 text-sm">
                                    </div>
                                </div>
                                <p class="text-[11px] text-slate-500">Rentang data: {{ $formatCurrency($priceStats->min_price ?? 0) }} - {{ $formatCurrency($priceStats->max_price ?? 0) }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Kategori</p>
                            <div class="mt-3 space-y-2 max-h-64 overflow-y-auto pr-2">
                                @foreach($categories as $category)
                                    @php $isChecked = in_array($category->id, $selectedCategories ?? []); @endphp
                                    <label class="flex items-center justify-between rounded-2xl border border-white/5 bg-white/5 px-4 py-2 text-sm text-slate-300 hover:border-primary/30">
                                        <div class="flex items-center gap-3">
                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" @if($isChecked) checked @endif class="size-4 rounded border-white/20 bg-transparent text-primary">
                                            <span>{{ $category->name }}</span>
                                        </div>
                                        <span class="text-xs text-slate-500">{{ $category->products_count }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Urutkan</p>
                            <select name="sort" class="mt-2 w-full rounded-2xl border border-white/10 bg-white/5 px-3 py-2 text-sm text-white">
                                <option value="relevance" @selected($sort === 'relevance')>Paling relevan</option>
                                <option value="latest" @selected($sort === 'latest')>Terbaru</option>
                                <option value="price-asc" @selected($sort === 'price-asc')>Harga terendah</option>
                                <option value="price-desc" @selected($sort === 'price-desc')>Harga tertinggi</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full rounded-2xl bg-primary py-3 text-sm font-semibold text-white shadow-glow hover:bg-blue-600">Terapkan Filter</button>
                    </form>
                </aside>

                <section class="space-y-6">
                    <div class="flex flex-col gap-4 rounded-3xl border border-white/5 bg-card/80 p-5 shadow-2xl md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Menampilkan</p>
                            <p class="text-sm text-slate-300">{{ $products->count() }} dari {{ $products->total() }} produk</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                            <a href="{{ route('products.catalog', $gridQuery) }}" class="rounded-full border px-4 py-2 transition @if($viewMode === 'grid') border-primary bg-primary/10 text-primary @else border-white/10 text-slate-300 hover:border-primary/40 @endif">Grid</a>
                            <a href="{{ route('products.catalog', $listQuery) }}" class="rounded-full border px-4 py-2 transition @if($viewMode === 'list') border-primary bg-primary/10 text-primary @else border-white/10 text-slate-300 hover:border-primary/40 @endif">List</a>
                            <a href="{{ route('products.catalog', array_merge($baseQuery, ['sort' => 'latest'])) }}" class="rounded-full border border-white/10 px-4 py-2 text-slate-300 hover:border-primary/40">Terbaru</a>
                        </div>
                    </div>

                    @if($products->isEmpty())
                        <div class="rounded-3xl border border-dashed border-white/10 p-10 text-center text-slate-400">
                            Produk tidak ditemukan. Sesuaikan filter untuk hasil lainnya.
                        </div>
                    @elseif($viewMode === 'list')
                        <div class="space-y-4">
                            @foreach($products as $product)
                                @php
                                    $image = $product->image;
                                    $isAbsolute = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));
                                    $imageUrl = $image ? ($isAbsolute ? $image : asset(ltrim($image, '/'))) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80';
                                @endphp
                                <article class="group flex gap-4 rounded-3xl border border-white/5 bg-[#0c1324] p-4 transition hover:border-primary/40 hover:shadow-glow">
                                    <div class="relative w-40 flex-shrink-0 overflow-hidden rounded-2xl bg-[#0a0f1f]">
                                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-full bg-black/60 px-3 py-1 text-[10px] font-semibold uppercase tracking-widest text-white">
                                            <span>{{ $product->category->name ?? 'Produk' }}</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-1 flex-col justify-between">
                                        <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold leading-tight">{{ $product->name }}</h3>
                                                <p class="text-sm text-slate-400">{{ Str::limit($product->description, 140) }}</p>
                                            </div>
                                            <p class="text-2xl font-bold text-white md:text-right">{{ $formatCurrency($product->price) }}</p>
                                        </div>
                                        <div class="mt-4 flex flex-wrap gap-2">
                                            <a href="{{ route('products.show', $product->slug) }}" class="flex-1 rounded-2xl border border-white/10 px-4 py-2 text-center text-sm font-semibold text-white hover:border-primary/40">Detail produk</a>
                                            @auth
                                                @php
                                                    $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                                                @endphp
                                                @if($inWishlist)
                                                    <form method="POST" action="{{ route('wishlist.destroy', \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first()) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-rose-500/50 bg-rose-500/10 px-4 py-2 text-sm font-semibold text-rose-400 hover:border-rose-500">
                                                            <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">favorite</span>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('wishlist.store') }}">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-white/10 px-4 py-2 text-sm font-semibold text-white hover:border-primary/40">
                                                            <span class="material-symbols-outlined text-base">favorite</span>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-2xl border border-white/10 px-4 py-2 text-sm font-semibold text-white hover:border-primary/40">
                                                    <span class="material-symbols-outlined text-base">favorite</span>
                                                </a>
                                            @endauth
                                            <form method="POST" action="{{ route('cart.items.store') }}" class="flex">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-glow hover:bg-blue-600">
                                                    <span class="material-symbols-outlined text-base">add_shopping_cart</span>
                                                    Tambah
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach($products as $product)
                                @php
                                    $image = $product->image;
                                    $isAbsolute = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));
                                    $imageUrl = $image ? ($isAbsolute ? $image : asset(ltrim($image, '/'))) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80';
                                @endphp
                                <article class="group flex flex-col rounded-3xl border border-white/5 bg-[#0c1324] p-4 transition hover:border-primary/40 hover:shadow-glow">
                                    <div class="relative w-full overflow-hidden rounded-2xl bg-[#0a0f1f]">
                                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="h-48 w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-full bg-black/60 px-3 py-1 text-[10px] font-semibold uppercase tracking-widest text-white">
                                            <span>{{ $product->category->name ?? 'Produk' }}</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-1 flex-col justify-between pt-4">
                                        <div class="space-y-2">
                                            <h3 class="text-lg font-semibold leading-tight">{{ $product->name }}</h3>
                                            <p class="text-xs text-slate-400">{{ Str::limit($product->description, 80) }}</p>
                                            <p class="text-2xl font-bold">{{ $formatCurrency($product->price) }}</p>
                                        </div>
                                        <div class="mt-4 flex items-center gap-2">
                                            <a href="{{ route('products.show', $product->slug) }}" class="flex-1 rounded-2xl border border-white/10 py-2 text-center text-sm font-semibold text-white hover:border-primary/40">Detail</a>
                                            @auth
                                                @php
                                                    $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                                                @endphp
                                                @if($inWishlist)
                                                    <form method="POST" action="{{ route('wishlist.destroy', \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first()) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="flex size-10 items-center justify-center rounded-2xl border border-rose-500/50 bg-rose-500/10 text-rose-400 hover:border-rose-500">
                                                            <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">favorite</span>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('wishlist.store') }}">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <button type="submit" class="flex size-10 items-center justify-center rounded-2xl border border-white/10 text-white hover:border-primary/40">
                                                            <span class="material-symbols-outlined text-base">favorite</span>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="flex size-10 items-center justify-center rounded-2xl border border-white/10 text-white hover:border-primary/40">
                                                    <span class="material-symbols-outlined text-base">favorite</span>
                                                </a>
                                            @endauth
                                            <form method="POST" action="{{ route('cart.items.store') }}" class="flex">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="flex size-10 items-center justify-center rounded-2xl bg-primary text-white shadow-glow hover:bg-blue-600">
                                                    <span class="material-symbols-outlined text-base">shopping_cart</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif

                    @if ($products->hasPages())
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ $products->previousPageUrl() ?? '#' }}" class="rounded-2xl border border-white/10 px-3 py-2 text-sm text-slate-300 @if(!$products->previousPageUrl()) opacity-40 pointer-events-none @endif">Prev</a>
                            @for ($page = 1; $page <= $products->lastPage(); $page++)
                                <a href="{{ $products->url($page) }}" class="rounded-2xl px-3 py-2 text-sm font-semibold @if($page === $products->currentPage()) bg-primary text-white shadow-glow @else border border-white/10 text-slate-300 hover:border-primary/40 @endif">{{ $page }}</a>
                                @if($page === $products->currentPage() + 2 && $page < $products->lastPage())
                                    <span class="px-2 text-slate-500">...</span>
                                    @php $page = $products->lastPage() - 1; @endphp
                                @endif
                            @endfor
                            <a href="{{ $products->nextPageUrl() ?? '#' }}" class="rounded-2xl border border-white/10 px-3 py-2 text-sm text-slate-300 @if(!$products->nextPageUrl()) opacity-40 pointer-events-none @endif">Next</a>
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </div>
</body>
</html>
