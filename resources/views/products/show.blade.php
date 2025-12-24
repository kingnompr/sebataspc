<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} • SEBATAS PC</title>
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
                        card: '#0c1222',
                        accent: '#1e1f3b',
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Noto Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        glow: '0 0 35px rgba(19,91,236,0.3)',
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Space Grotesk', 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #1c294a; border-radius: 999px; }
        ::-webkit-scrollbar-track { background: #050915; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-surface text-white">
    <div class="min-h-screen bg-gradient-to-b from-surface via-[#060c19] to-[#01030a]">
        <header class="border-b border-white/5 bg-surface/80 backdrop-blur">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4 md:px-0">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-2xl border border-primary/40 bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">memory</span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Sebatas PC</p>
                        <p class="text-lg font-semibold">PC Master • Detail</p>
                    </div>
                </div>
                <nav class="hidden items-center gap-6 text-sm text-slate-300 md:flex">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                    <a href="{{ route('products.catalog') }}" class="hover:text-white transition">Produk</a>
                    <a href="{{ route('pc-builds.builder') }}" class="hover:text-white transition">Rakit PC</a>
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
                        <a href="{{ route('login') }}" class="hidden items-center gap-2 rounded-xl border border-white/10 px-4 py-2 text-slate-300 hover:border-primary/50 sm:inline-flex">
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
            $monthlyInstallment = $product->price ? $product->price / 12 : 0;
            $stockLabel = $product->stock > 0 ? 'Stok Tersedia' : 'Stok Habis';
            $stockColor = $product->stock > 0 ? 'text-emerald-400' : 'text-rose-400';

            $rawGallery = collect($product->gallery ?? []);
            if ($rawGallery->isEmpty() && $product->image) {
                $rawGallery = collect([$product->image]);
            }
            if ($rawGallery->isEmpty()) {
                $rawGallery = collect([
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
                ]);
            }
            $gallery = $rawGallery->map(function ($image) {
                if (! $image) {
                    return null;
                }
                $isAbsolute = str_starts_with($image, 'http://') || str_starts_with($image, 'https://');
                return $isAbsolute ? $image : asset($image);
            })->filter()->values();
            $activeImage = $gallery->first();

            // Ensure specifications is parsed properly (accessor guarantees array)
            $specs = collect($product->specifications ?? []);
            $specHighlights = $specs->take(4);
        @endphp

        <main class="mx-auto w-full max-w-6xl px-4 py-10 md:px-0">
            <div class="mb-6 text-xs uppercase tracking-[0.4em] text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.catalog') }}" class="hover:text-white">Produk</a>
                <span class="mx-2">/</span>
                <span class="text-white">{{ $product->name }}</span>
            </div>

            <section class="grid gap-8 lg:grid-cols-[minmax(0,1.1fr),minmax(0,0.9fr)]">
                <div class="space-y-4">
                    <div class="rounded-3xl border border-white/5 bg-card/80 p-4 shadow-2xl">
                        <div class="relative overflow-hidden rounded-2xl bg-black/40">
                            <img id="productHeroImage" src="{{ $activeImage }}" alt="{{ $product->name }}" class="h-[420px] w-full object-cover">
                            <span class="absolute left-4 top-4 rounded-full bg-primary px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em]">{{ $product->is_featured ? 'Best Seller' : 'Premium' }}</span>
                        </div>
                        <div class="mt-4 flex gap-3 overflow-x-auto">
                            @foreach($gallery as $image)
                                <button type="button" data-image="{{ $image }}" class="thumbnail-button rounded-2xl border border-white/5 bg-black/40 p-1 transition hover:border-primary/50">
                                    <img src="{{ $image }}" alt="{{ $product->name }}" class="h-20 w-20 rounded-xl object-cover">
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl">
                        <div class="flex items-center gap-6 border-b border-white/5 pb-4">
                            <button class="text-sm font-semibold text-primary">Spesifikasi Teknis</button>
                            <button class="text-sm text-slate-500">Deskripsi</button>
                            <button class="text-sm text-slate-500">Ulasan ({{ $totalReviews }})</button>
                        </div>
                        <div id="specs" class="mt-6 grid gap-4 lg:grid-cols-2">
                            @forelse($specs as $key => $value)
                                @php
                                    // Format key label
                                    $label = match($key) {
                                        'socket' => 'Socket',
                                        'chipset' => 'Chipset',
                                        'memory_type' => 'Tipe Memory',
                                        'memory_speed' => 'Kecepatan Memory',
                                        'memory_slots' => 'Slot Memory',
                                        'interface' => 'Interface',
                                        'capacity' => 'Kapasitas',
                                        'tdp' => 'TDP',
                                        'wattage' => 'Watt',
                                        'efficiency_rating' => 'Rating Efisiensi',
                                        'efficiency' => 'Efisiensi',
                                        'form_factor' => 'Form Factor',
                                        'length' => 'Panjang',
                                        'height' => 'Tinggi',
                                        'rgb_support' => 'RGB Support',
                                        'rgb' => 'RGB',
                                        'type' => 'Tipe',
                                        'generation' => 'Generasi',
                                        'use_case' => 'Penggunaan',
                                        'tier' => 'Tier',
                                        'cores' => 'Cores / Thread',
                                        'base_clock' => 'Base Clock',
                                        'boost_clock' => 'Boost Clock',
                                        'igpu' => 'Integrated GPU',
                                        'vram' => 'VRAM',
                                        'power_draw' => 'TDP',
                                        'max_memory' => 'Max Memory',
                                        'pcie_slots' => 'PCIe Slots',
                                        'speed' => 'Kecepatan',
                                        'timing' => 'Timing',
                                        'read_speed' => 'Read Speed',
                                        'write_speed' => 'Write Speed',
                                        'endurance' => 'Endurance (TBW)',
                                        'modularity' => 'Modularity',
                                        'fans_included' => 'Fans Included',
                                        'max_gpu_length' => 'Max GPU Length',
                                        'max_cpu_cooler_height' => 'Max CPU Cooler Height',
                                        'radiator_size' => 'Radiator',
                                        'noise_level' => 'Noise Level',
                                        'compatibility' => 'Kompatibilitas',
                                        'sequential_read' => 'Sequential Read',
                                        'sequential_write' => 'Sequential Write',
                                        'gpu_clearance' => 'GPU Clearance',
                                        'cooling_support' => 'Cooling Support',
                                        'front_io' => 'Front I/O',
                                        'fans' => 'Fans',
                                        'socket_support' => 'Socket Support',
                                        default => Str::of($key)->replace('_', ' ')->title()
                                    };
                                    
                                    // Skip internal fields
                                    if (in_array($key, ['created_at', 'updated_at', 'id'])) {
                                        continue;
                                    }
                                    
                                    // Format value if it's an array or object
                                    if (is_array($value)) {
                                        $displayValue = implode(', ', $value);
                                    } elseif (is_bool($value)) {
                                        $displayValue = $value ? 'Ya' : 'Tidak';
                                    } elseif (is_null($value)) {
                                        $displayValue = '-';
                                    } else {
                                        $displayValue = $value;
                                    }
                                @endphp
                                <div class="rounded-2xl border border-white/5 bg-accent/40 p-4">
                                    <p class="text-xs uppercase tracking-[0.3em] text-slate-500">{{ $label }}</p>
                                    <p class="mt-2 text-sm font-medium text-slate-200">{{ $displayValue }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400">Belum ada detail spesifikasi untuk produk ini.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-[2fr,1fr]">
                        <div class="rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl">
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Deskripsi Lengkap</p>
                            <p class="mt-3 text-sm leading-relaxed text-slate-300">{{ $product->description }}</p>
                        </div>
                        <div class="rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl">
                            <div class="flex items-center gap-3">
                                <div>
                                    <p class="text-4xl font-bold">{{ number_format($avgRating, 1) }}</p>
                                    <p class="text-xs text-slate-400">Berdasarkan {{ $totalReviews }} ulasan</p>
                                </div>
                                <div class="flex gap-0.5 text-primary">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="material-symbols-outlined text-xl {{ $i <= round($avgRating) ? '' : 'opacity-30' }}">star</span>
                                    @endfor
                                </div>
                            </div>
                            <div class="mt-4 space-y-2">
                                @foreach($ratingDistribution as $stars => $data)
                                    <div class="flex items-center gap-2 text-xs text-slate-400">
                                        <span>{{ $stars }} ★</span>
                                        <div class="h-2 flex-1 overflow-hidden rounded-full bg-white/10">
                                            <div class="h-full bg-primary" style="width: {{ $data['percentage'] }}%"></div>
                                        </div>
                                        <span>{{ $data['percentage'] }}%</span>
                                    </div>
                                @endforeach
                            </div>
                            @auth
                                @if(!$userHasReviewed)
                                    <a href="#review-form" class="mt-4 inline-flex items-center gap-2 rounded-2xl border border-white/10 px-4 py-2 text-sm font-semibold text-white hover:border-primary/40">Tulis ulasan</a>
                                @else
                                    <p class="mt-4 text-xs text-slate-500">Anda sudah memberikan ulasan</p>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="mt-4 inline-flex items-center gap-2 rounded-2xl border border-white/10 px-4 py-2 text-sm font-semibold text-white hover:border-primary/40">Login untuk ulasan</a>
                            @endauth
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="mt-10 rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl" id="reviews-section">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-semibold">Ulasan Terbaru</h3>
                            <div class="flex gap-3">
                                <select onchange="window.location.href='?rating='+this.value+'&sort={{ request('sort', 'latest') }}&verified={{ request('verified', '0') }}'" class="rounded-lg border border-white/10 bg-transparent px-4 py-2 text-sm text-white">
                                    <option value="">Semua Rating</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                                    @endfor
                                </select>
                                <select onchange="window.location.href='?rating={{ request('rating', '') }}&sort='+this.value+'&verified={{ request('verified', '0') }}'" class="rounded-lg border border-white/10 bg-transparent px-4 py-2 text-sm text-white">
                                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Rating Tertinggi</option>
                                    <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Rating Terendah</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                </select>
                                <label class="flex items-center gap-2 rounded-lg border border-white/10 bg-transparent px-4 py-2 text-sm text-white cursor-pointer hover:border-primary/40 transition-colors">
                                    <input type="checkbox" onchange="window.location.href='?rating={{ request('rating', '') }}&sort={{ request('sort', 'latest') }}&verified='+(this.checked ? '1' : '0')" {{ request('verified') == '1' ? 'checked' : '' }} class="rounded border-white/20 bg-white/5 text-primary focus:ring-primary">
                                    <span>Pembelian Terverifikasi</span>
                                </label>
                            </div>
                        </div>

                        <!-- Review Form -->
                        @auth
                            @if($userCanReview)
                            <div class="mb-8 rounded-2xl border border-primary/20 bg-primary/5 p-4">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-primary text-2xl">rate_review</span>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-white">Anda telah membeli produk ini!</p>
                                        <p class="text-xs text-slate-400 mt-1">Bagikan pengalaman Anda dengan memberikan ulasan</p>
                                    </div>
                                    <a href="#review-form" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600 transition-colors">
                                        Tulis Ulasan
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if(!$userHasReviewed)
                            <div id="review-form" class="mb-8 rounded-2xl border border-white/5 bg-accent/20 p-6">
                                <h4 class="text-lg font-semibold mb-4">Tulis Ulasan Anda</h4>
                                
                                @if(session('success'))
                                    <div class="mb-4 rounded-lg border border-green-500/20 bg-green-500/10 p-3 text-sm text-green-400">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="mb-4 rounded-lg border border-red-500/20 bg-red-500/10 p-3 text-sm text-red-400">
                                        <ul class="list-disc pl-4">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('products.reviews.store', $product) }}" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Beri Rating</label>
                                        <div class="flex gap-2" id="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" onclick="setRating({{ $i }})" class="rating-star text-3xl text-slate-600 hover:text-primary transition-colors">
                                                    <span class="material-symbols-outlined">star</span>
                                                </button>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Detail Ulasan (Opsional)</label>
                                        <textarea name="comment" rows="4" placeholder="Bagikan pengalaman Anda menggunakan produk ini..." class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">{{ old('comment') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Tambahkan Foto (Opsional)</label>
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-center w-full">
                                                <label for="review-images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-white/20 rounded-2xl cursor-pointer bg-white/5 hover:bg-white/10 transition-colors">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                        <span class="material-symbols-outlined text-4xl text-slate-400 mb-2">add_photo_alternate</span>
                                                        <p class="mb-1 text-sm text-slate-400"><span class="font-semibold">Klik untuk upload</span> atau drag & drop</p>
                                                        <p class="text-xs text-slate-500">PNG, JPG, WEBP (Maks. 5MB per foto, maks. 5 foto)</p>
                                                    </div>
                                                    <input id="review-images" name="images[]" type="file" accept="image/jpeg,image/jpg,image/png,image/webp" multiple class="hidden" onchange="previewImages(event)" />
                                                </label>
                                            </div>
                                            <div id="image-preview" class="grid grid-cols-3 gap-3 hidden">
                                                <!-- Preview images will be inserted here -->
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white hover:bg-blue-600 transition-colors">
                                        Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                            @endif
                        @endauth

                        <!-- Reviews List -->
                        <div class="space-y-4">
                            @forelse($reviews as $review)
                                <div class="rounded-2xl border border-white/5 bg-white/5 p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start gap-3">
                                            <div class="size-10 rounded-full bg-primary/20 flex items-center justify-center text-sm font-bold text-primary">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-white">{{ $review->user->name }}</p>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <div class="flex gap-0.5 text-primary">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <span class="material-symbols-outlined text-sm {{ $i <= $review->rating ? '' : 'opacity-30' }}">star</span>
                                                        @endfor
                                                    </div>
                                                    @if($review->is_verified_purchase)
                                                        <span class="inline-flex items-center gap-1 rounded-full bg-green-500/10 px-2 py-0.5 text-xs text-green-400">
                                                            <span class="material-symbols-outlined text-xs">verified</span>
                                                            Pembelian Terverifikasi
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-xs text-slate-500">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($review->comment)
                                        <p class="mt-3 text-sm text-slate-300 leading-relaxed">{{ $review->comment }}</p>
                                    @endif
                                    
                                    @if($review->images && count($review->images) > 0)
                                        <div class="mt-4 grid grid-cols-4 gap-2">
                                            @foreach($review->images as $image)
                                                <div class="relative aspect-square overflow-hidden rounded-lg border border-white/10 bg-black/20 cursor-pointer group" onclick="openImageModal('{{ asset($image) }}')">
                                                    <img src="{{ asset($image) }}" alt="Review photo" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-white text-2xl">zoom_in</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-white/10 p-8 text-center">
                                    <p class="text-slate-400">Belum ada ulasan untuk produk ini.</p>
                                    @auth
                                        @if(!$userHasReviewed)
                                            <p class="mt-2 text-sm text-slate-500">Jadilah yang pertama memberikan ulasan!</p>
                                        @endif
                                    @endauth
                                </div>
                            @endforelse
                        </div>

                        @if($reviews->hasPages())
                            <div class="mt-6">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl">
                        <div class="flex flex-col gap-3">
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Pre-built Highlight</p>
                            <h1 class="text-3xl font-semibold leading-tight">{{ $product->name }}</h1>
                            <div class="flex flex-wrap items-center gap-3 text-sm text-slate-400">
                                <div class="flex items-center gap-1 text-amber-400">
                                    <span class="material-symbols-outlined text-base">grade</span>
                                    <span>{{ number_format($avgRating, 1) }} • {{ $totalReviews }} ulasan</span>
                                </div>
                                <span class="text-slate-600">|</span>
                                <div class="flex items-center gap-1 {{ $stockColor }}">
                                    <span class="material-symbols-outlined text-base">check_circle</span>
                                    <span>{{ $stockLabel }}</span>
                                </div>
                            </div>
                            <p class="text-sm text-slate-400">{{ Str::limit($product->description, 140) }}</p>
                        </div>

                        <div class="mt-6 space-y-2">
                            <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Harga</p>
                            <p class="text-3xl font-bold">{{ $formatCurrency($product->price) }}</p>
                            <p class="text-sm text-slate-400">Cicilan 0% mulai dari {{ $formatCurrency($monthlyInstallment) }} / bulan</p>
                        </div>

                        <div class="mt-6 grid gap-3 sm:grid-cols-2">
                            @foreach($specHighlights as $key => $value)
                                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm">
                                    <p class="text-[11px] uppercase tracking-[0.3em] text-slate-500">{{ Str::of($key)->replace('_', ' ')->title() }}</p>
                                    <p class="mt-1 text-white">{{ $value }}</p>
                                </div>
                            @endforeach
                        </div>

                        <form method="POST" action="{{ route('cart.items.store') }}" class="mt-6 space-y-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div>
                                <label class="text-xs uppercase tracking-[0.4em] text-slate-500">Jumlah</label>
                                <div class="mt-2 flex items-center gap-2 rounded-2xl border border-white/10 bg-black/20 px-3 py-2">
                                    <button type="button" data-step="-1" class="quantity-step rounded-2xl bg-white/5 px-3 py-1 text-lg">-</button>
                                    <input type="number" name="quantity" id="quantityInput" value="1" min="1" max="{{ max(1, (int) ($product->stock ?? 1)) }}" class="w-16 border-0 bg-transparent text-center text-lg font-semibold">
                                    <button type="button" data-step="1" class="quantity-step rounded-2xl bg-white/5 px-3 py-1 text-lg">+</button>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3">
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-glow hover:bg-blue-600">
                                    <span class="material-symbols-outlined text-base">shopping_cart_checkout</span>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </form>

                        @auth
                            @php
                                $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                    ->where('product_id', $product->id)
                                    ->exists();
                            @endphp
                            @if($inWishlist)
                                <form method="POST" action="{{ route('wishlist.destroy', \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first()) }}" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-rose-500/50 bg-rose-500/10 px-6 py-3 text-sm font-semibold text-rose-400 hover:border-rose-500">
                                        <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1;">favorite</span>
                                        Hapus dari Wishlist
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('wishlist.store') }}" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-white/10 px-6 py-3 text-sm font-semibold text-white hover:border-primary/40">
                                        <span class="material-symbols-outlined text-base">favorite</span>
                                        Simpan ke Wishlist
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-white/10 px-6 py-3 text-sm font-semibold text-white hover:border-primary/40">
                                <span class="material-symbols-outlined text-base">favorite</span>
                                Simpan ke Wishlist
                            </a>
                        @endauth

                        <div class="mt-6 grid gap-3 border-t border-white/5 pt-6 text-sm text-slate-400">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-base text-primary">local_shipping</span>
                                Gratis ongkir ekspres ke seluruh Indonesia*
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-base text-primary">verified</span>
                                3 Tahun Garansi Resmi + dukungan rakit
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-base text-primary">support_agent</span>
                                Tim concierge siap bantu konfigurasi custom
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl">
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Dukungan & Layanan</p>
                        <ul class="mt-4 space-y-3 text-sm text-slate-300">
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">headset_mic</span>
                                Konsultasi build gratis sebelum membeli
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">verified_user</span>
                                Pengujian burn-in 48 jam sebelum dikirim
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">assignment_return</span>
                                Garansi ganti unit 14 hari jika bermasalah
                            </li>
                        </ul>
                        <a href="{{ route('pc-builds.builder') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary">
                            <span class="material-symbols-outlined text-base">add_circle</span>
                            Konsultasikan build custom
                        </a>
                    </div>
                </div>
            </section>

            <section class="mt-12 rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Produk Terkait</p>
                        <h2 class="text-2xl font-semibold">Rekomendasi lain untukmu</h2>
                    </div>
                    <a href="{{ route('products.catalog') }}" class="text-sm font-semibold text-primary">Lihat Semua →</a>
                </div>
                <div class="mt-6 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    @forelse($related as $item)
                        @php
                            $image = $item->image;
                            $isAbsolute = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));
                            $imageUrl = $image ? ($isAbsolute ? $image : asset($image)) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80';
                        @endphp
                        <article class="rounded-2xl border border-white/5 bg-[#0d1527] p-4 transition hover:border-primary/40">
                            <div class="relative overflow-hidden rounded-2xl">
                                <img src="{{ $imageUrl }}" alt="{{ $item->name }}" class="h-40 w-full object-cover">
                                <span class="absolute left-3 top-3 rounded-full bg-black/60 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.3em]">{{ $item->category->name ?? 'Produk' }}</span>
                            </div>
                            <div class="mt-4 space-y-2">
                                <h3 class="text-base font-semibold leading-tight">{{ $item->name }}</h3>
                                <p class="text-xs text-slate-500">{{ Str::limit($item->description, 70) }}</p>
                                <p class="text-lg font-bold">{{ $formatCurrency($item->price) }}</p>
                            </div>
                            <div class="mt-4 flex items-center gap-2">
                                <a href="{{ route('products.show', $item->slug) }}" class="flex-1 rounded-2xl border border-white/10 px-4 py-2 text-center text-sm font-semibold text-white hover:border-primary/40">Detail</a>
                                <form method="POST" action="{{ route('cart.items.store') }}" class="flex">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="flex size-10 items-center justify-center rounded-2xl bg-primary text-white shadow-glow hover:bg-blue-600">
                                        <span class="material-symbols-outlined text-base">add_shopping_cart</span>
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-slate-400">Belum ada rekomendasi lain saat ini.</p>
                    @endforelse
                </div>
            </section>
        </main>

        <footer class="mt-16 border-t border-white/5 bg-surface/60">
            <div class="mx-auto w-full max-w-6xl px-4 py-10 md:px-0">
                <div class="grid gap-6 text-sm text-slate-400 md:grid-cols-4">
                    <div>
                        <h3 class="text-white">SEBATAS PC</h3>
                        <p class="mt-2">Destinasi rakit PC gaming profesional dan workstation kreator.</p>
                    </div>
                    <div>
                        <p class="text-white">Layanan</p>
                        <ul class="mt-2 space-y-1">
                            <li>Rakit PC Custom</li>
                            <li>Konsultasi Gratis</li>
                            <li>Garansi Resmi</li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-white">Perusahaan</p>
                        <ul class="mt-2 space-y-1">
                            <li>Tentang Kami</li>
                            <li>Karir</li>
                            <li>Hubungi Kami</li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-white">Newsletter</p>
                        <form class="mt-3 flex rounded-2xl border border-white/10 p-1">
                            <input type="email" placeholder="Email Anda" class="flex-1 bg-transparent px-3 text-sm focus:outline-none">
                            <button type="button" class="rounded-2xl bg-primary px-4 py-2 text-sm font-semibold text-white">→</button>
                        </form>
                    </div>
                </div>
                <p class="mt-6 text-center text-xs text-slate-600">© {{ date('Y') }} SEBATAS PC. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script>
        const hero = document.getElementById('productHeroImage');
        document.querySelectorAll('.thumbnail-button').forEach((button) => {
            button.addEventListener('click', () => {
                const image = button.getAttribute('data-image');
                if (image && hero) {
                    hero.src = image;
                }
            });
        });

        document.querySelectorAll('.quantity-step').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById('quantityInput');
                if (!input) return;
                const step = Number(button.getAttribute('data-step')) || 1;
                const min = Number(input.getAttribute('min')) || 1;
                const max = Number(input.getAttribute('max')) || 99;
                let value = Number(input.value) || 1;
                value = Math.min(Math.max(value + step, min), max);
                input.value = value;
            });
        });

        // Rating stars functionality
        function setRating(rating) {
            document.getElementById('rating-input').value = rating;
            const stars = document.querySelectorAll('.rating-star');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-slate-600');
                    star.classList.add('text-primary');
                } else {
                    star.classList.remove('text-primary');
                    star.classList.add('text-slate-600');
                }
            });
        }

        // Initialize rating from old input if exists
        const oldRating = document.getElementById('rating-input')?.value;
        if (oldRating) {
            setRating(parseInt(oldRating));
        }

        // Image preview functionality
        function previewImages(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('image-preview');
            
            if (files.length > 0) {
                previewContainer.classList.remove('hidden');
                previewContainer.innerHTML = '';
                
                // Limit to 5 images
                const maxFiles = Math.min(files.length, 5);
                
                for (let i = 0; i < maxFiles; i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative aspect-square overflow-hidden rounded-lg border border-white/10';
                        div.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" class="h-full w-full object-cover">
                            <button type="button" onclick="removePreview(this)" class="absolute top-1 right-1 rounded-full bg-red-500 p-1 text-white hover:bg-red-600">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </button>
                        `;
                        previewContainer.appendChild(div);
                    };
                    
                    reader.readAsDataURL(file);
                }
                
                if (files.length > 5) {
                    alert('Maksimal 5 foto. Foto pertama yang dipilih akan digunakan.');
                }
            }
        }

        function removePreview(button) {
            const previewContainer = document.getElementById('image-preview');
            button.parentElement.remove();
            
            if (previewContainer.children.length === 0) {
                previewContainer.classList.add('hidden');
                document.getElementById('review-images').value = '';
            }
        }

        // Image modal functionality
        function openImageModal(imageSrc) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4';
            modal.onclick = function() { modal.remove(); };
            
            modal.innerHTML = `
                <div class="relative max-w-5xl max-h-[90vh]">
                    <button onclick="this.parentElement.parentElement.remove()" class="absolute -top-12 right-0 rounded-full bg-white/10 p-2 text-white hover:bg-white/20">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                    <img src="${imageSrc}" alt="Review photo" class="max-h-[85vh] w-auto rounded-2xl">
                </div>
            `;
            
            document.body.appendChild(modal);
        }
    </script>
</body>
</html>
