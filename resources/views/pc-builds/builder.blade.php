<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart PC Builder • SEBATAS PC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#135bec',
                        'surface': '#0d1424',
                        'card': '#131a2c',
                        'card-hover': '#1b2438',
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Noto Sans', 'sans-serif'],
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
        ::-webkit-scrollbar-track { background: #080d19; }
        ::-webkit-scrollbar-thumb { background: #1f2a41; border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: #304167; }
    </style>
</head>
<body class="bg-surface text-white">
    <div class="min-h-screen bg-gradient-to-b from-surface via-[#080d17] to-[#050910]">
        <!-- Header -->
        <header class="border-b border-white/5 bg-surface/90 backdrop-blur sticky top-0 z-30">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-2xl bg-primary/20 border border-primary/40 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-2xl">memory</span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Sebatas PC</p>
                        <p class="text-lg font-semibold">Smart PC Builder</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-6 text-sm text-slate-300">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                    <a href="{{ route('products.catalog') }}" class="hover:text-white transition">Produk</a>
                    <a class="text-primary font-semibold" href="{{ route('pc-builds.builder') }}">Rakit PC</a>
                </div>
                <div class="flex items-center gap-3">
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
                        <a href="{{ route('account.overview') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-4 py-2 text-sm font-semibold hover:border-primary/50">
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
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex rounded-xl border border-white/10 px-4 py-2 text-sm font-semibold hover:border-primary/50">Masuk</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white shadow-[0_0_20px_rgba(19,91,236,0.35)] hover:bg-blue-600">
                            <span class="material-symbols-outlined text-base">bolt</span>
                            Bergabung
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="mx-auto w-full max-w-7xl px-4 py-8">
            <!-- Breadcrumb -->
            <nav class="text-xs uppercase tracking-[0.4em] text-slate-500 mb-6">Home / Rakit PC / Builder</nav>

            <!-- Summary Bar (Sticky) -->
            <div class="sticky top-[73px] z-20 bg-card/95 backdrop-blur border border-white/5 rounded-2xl p-4 mb-6 shadow-xl">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Total Estimasi</p>
                                <p class="text-3xl font-bold text-white">
                                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="h-12 w-px bg-white/10"></div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Sisa Budget</p>
                                <p class="text-xl font-semibold {{ $remainingBudget > 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                    Rp {{ number_format($remainingBudget, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="h-12 w-px bg-white/10"></div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Tier</p>
                                <p class="text-sm font-semibold text-white">{{ $tier }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" 
                                onclick="saveBuild()"
                                class="px-4 py-2 rounded-xl border border-white/10 text-sm font-semibold hover:border-primary/50 transition">
                            <span class="material-symbols-outlined text-base align-middle mr-1">save</span>
                            Simpan Build
                        </button>
                        <button type="button" 
                                onclick="addToCart()"
                                class="px-4 py-2 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-blue-600 transition shadow-lg">
                            <span class="material-symbols-outlined text-base align-middle mr-1">shopping_cart</span>
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content: Component List -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Core Components Section -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-2xl font-bold flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">construction</span>
                                    Komponen Inti
                                </h2>
                                <p class="text-sm text-slate-400">Komponen wajib untuk melengkapi rakitan PC</p>
                            </div>
                            <span class="px-3 py-1 bg-red-500/20 border border-red-500/30 rounded-full text-xs font-bold text-red-400 uppercase">Wajib</span>
                        </div>

                        <div class="space-y-3">
                            @foreach(['processor', 'motherboard', 'ram', 'storage', 'psu', 'casing'] as $componentType)
                                @php
                                    $detail = $componentDetails[$componentType];
                                    $info = $detail['info'];
                                    $product = $detail['product'] ?? null;
                                    $allocatedBudget = $detail['allocated_budget'];
                                @endphp
                                <div class="rounded-2xl border border-white/10 bg-card p-5 hover:border-primary/40 transition-all">
                                    <div class="flex items-start gap-4">
                                        <div class="size-14 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center flex-shrink-0">
                                            <span class="material-symbols-outlined text-2xl text-primary">{{ $info['icon'] }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex-1">
                                                    <h3 class="font-semibold text-white">{{ $info['label'] }}</h3>
                                                    <p class="text-xs text-slate-400">{{ $info['desc'] }}</p>
                                                    <p class="text-xs text-primary mt-1">Budget: Rp {{ number_format($allocatedBudget, 0, ',', '.') }}</p>
                                                </div>
                                                <button type="button" 
                                                    onclick="openComponentModal('{{ $componentType }}', {{ $allocatedBudget }}, {{ $product ? $product->id : 'null' }})"
                                                    class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-sm font-semibold hover:bg-white/10 hover:border-primary/50 transition">
                                                    <span class="material-symbols-outlined text-base align-middle mr-1">{{ $product ? 'swap_horiz' : 'add' }}</span>
                                                    {{ $product ? 'Ganti' : 'Pilih' }}
                                                </button>
                                            </div>
                                            @if($product)
                                                <div class="mt-3 p-3 rounded-xl bg-gradient-to-r from-primary/10 to-blue-500/10 border border-primary/20">
                                                    <div class="flex items-center gap-3">
                                                        @if($product->image_url)
                                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-14 h-14 object-cover rounded-lg border border-white/10">
                                                        @else
                                                            <div class="w-14 h-14 rounded-lg bg-white/5 flex items-center justify-center border border-white/10">
                                                                <span class="material-symbols-outlined text-slate-500">{{ $info['icon'] }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-semibold text-white truncate">{{ $product->name }}</p>
                                                            <div class="flex items-center gap-2 mt-1">
                                                                <p class="text-base font-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                                                @if($product->rating)
                                                                    <span class="text-xs text-yellow-400">★ {{ number_format($product->rating, 1) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="mt-3 p-3 rounded-xl bg-white/5 border border-dashed border-white/10">
                                                    <p class="text-sm text-slate-400 text-center">
                                                        <span class="material-symbols-outlined text-base align-middle">info</span>
                                                        Tidak ada rekomendasi di budget ini
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Optional Components Section -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-2xl font-bold flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-400">extension</span>
                                    Komponen Tambahan
                                </h2>
                                <p class="text-sm text-slate-400">Komponen opsional berdasarkan kebutuhan dan budget</p>
                            </div>
                            <span class="px-3 py-1 bg-emerald-500/20 border border-emerald-500/30 rounded-full text-xs font-bold text-emerald-400 uppercase">Opsional</span>
                        </div>

                        <div class="space-y-3">
                            @foreach(['gpu', 'cpu_cooler'] as $componentType)
                                @php
                                    $detail = $componentDetails[$componentType];
                                    $info = $detail['info'];
                                    $product = $detail['product'] ?? null;
                                    $allocatedBudget = $detail['allocated_budget'];
                                @endphp
                                <div class="rounded-2xl border border-white/10 bg-card p-5 hover:border-emerald-400/40 transition-all">
                                    <div class="flex items-start gap-4">
                                        <div class="size-14 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center flex-shrink-0">
                                            <span class="material-symbols-outlined text-2xl text-emerald-400">{{ $info['icon'] }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex-1">
                                                    <h3 class="font-semibold text-white">{{ $info['label'] }}</h3>
                                                    <p class="text-xs text-slate-400">{{ $info['desc'] }}</p>
                                                    <p class="text-xs text-emerald-400 mt-1">Budget: Rp {{ number_format($allocatedBudget, 0, ',', '.') }}</p>
                                                </div>
                                                <button type="button" 
                                                    onclick="openComponentModal('{{ $componentType }}', {{ $allocatedBudget }}, {{ $product ? $product->id : 'null' }})"
                                                    class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-sm font-semibold hover:bg-white/10 hover:border-emerald-400/50 transition">
                                                    <span class="material-symbols-outlined text-base align-middle mr-1">{{ $product ? 'swap_horiz' : 'add' }}</span>
                                                    {{ $product ? 'Ganti' : 'Pilih' }}
                                                </button>
                                            </div>
                                            @if($product)
                                                <div class="mt-3 p-3 rounded-xl bg-gradient-to-r from-emerald-500/10 to-teal-500/10 border border-emerald-500/20">
                                                    <div class="flex items-center gap-3">
                                                        @if($product->image_url)
                                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-14 h-14 object-cover rounded-lg border border-white/10">
                                                        @else
                                                            <div class="w-14 h-14 rounded-lg bg-white/5 flex items-center justify-center border border-white/10">
                                                                <span class="material-symbols-outlined text-slate-500">{{ $info['icon'] }}</span>
                                                            </div>
                                                        @endif
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-semibold text-white truncate">{{ $product->name }}</p>
                                                            <div class="flex items-center gap-2 mt-1">
                                                                <p class="text-base font-bold text-emerald-400">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                                                @if($product->rating)
                                                                    <span class="text-xs text-yellow-400">★ {{ number_format($product->rating, 1) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="mt-3 p-3 rounded-xl bg-white/5 border border-dashed border-white/10">
                                                    <p class="text-sm text-slate-400 text-center">
                                                        <span class="material-symbols-outlined text-base align-middle">info</span>
                                                        Tidak ada rekomendasi di budget ini
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Filters & Info -->
                <div class="lg:col-span-1 space-y-4">
                    <!-- Budget Filter -->
                    <div class="rounded-2xl bg-card border border-white/5 p-6 shadow-xl sticky top-[200px]">
                        <h3 class="text-lg font-bold mb-4">Filter & Rekomendasi</h3>
                        
                        <form method="GET" action="{{ route('pc-builds.builder') }}" class="space-y-6">
                            <!-- Budget Slider -->
                            <div>
                                <label class="text-xs uppercase tracking-[0.4em] text-slate-400 mb-2 block">Estimasi Budget</label>
                                <div class="rounded-xl bg-white/5 p-4">
                                    <p class="text-2xl font-bold text-white mb-3" x-data="{ budget: {{ $budget }} }">
                                        Rp <span x-text="new Intl.NumberFormat('id-ID').format(budget)">{{ number_format($budget, 0, ',', '.') }}</span>
                                    </p>
                                    <input 
                                        type="range" 
                                        name="budget" 
                                        min="5000000" 
                                        max="50000000" 
                                        step="500000" 
                                        value="{{ $budget }}" 
                                        class="w-full h-2 rounded-full appearance-none bg-white/10 accent-primary cursor-pointer"
                                        x-data
                                        @input="$el.form.querySelector('p span').innerText = new Intl.NumberFormat('id-ID').format($el.value)"
                                    >
                                    <div class="flex justify-between text-[10px] text-slate-500 mt-2">
                                        <span>5jt</span>
                                        <span>50jt+</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Use Case -->
                            <div>
                                <label class="text-xs uppercase tracking-[0.4em] text-slate-400 mb-2 block">Tujuan Penggunaan</label>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach(['Gaming', 'Office', 'Editing'] as $case)
                                        <button 
                                            type="submit" 
                                            name="use_case" 
                                            value="{{ $case }}"
                                            class="px-4 py-3 rounded-xl border text-sm font-semibold text-left transition
                                                {{ $useCase === $case ? 'border-primary bg-primary/20 text-primary' : 'border-white/10 bg-white/5 hover:border-primary/50 hover:bg-primary/10' }}"
                                        >
                                            <div class="flex items-center gap-2">
                                                @if($case === 'Gaming')
                                                    <span class="material-symbols-outlined text-base">stadia_controller</span>
                                                @elseif($case === 'Office')
                                                    <span class="material-symbols-outlined text-base">work</span>
                                                @else
                                                    <span class="material-symbols-outlined text-base">video_camera_front</span>
                                                @endif
                                                {{ $case }}
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tier Selection -->
                            <div>
                                <label class="text-xs uppercase tracking-[0.4em] text-slate-400 mb-2 block">Strategi Build</label>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach(['Best Performance', 'Best Value', 'Future Proof'] as $tierOption)
                                        <button 
                                            type="submit" 
                                            name="tier" 
                                            value="{{ $tierOption }}"
                                            class="px-4 py-3 rounded-xl border text-sm font-semibold text-left transition
                                                {{ $tier === $tierOption ? 'border-primary bg-primary/20 text-primary' : 'border-white/10 bg-white/5 hover:border-primary/50 hover:bg-primary/10' }}"
                                        >
                                            <div>
                                                <div class="flex items-center gap-2 mb-1">
                                                    @if($tierOption === 'Best Performance')
                                                        <span class="material-symbols-outlined text-base">rocket_launch</span>
                                                    @elseif($tierOption === 'Best Value')
                                                        <span class="material-symbols-outlined text-base">savings</span>
                                                    @else
                                                        <span class="material-symbols-outlined text-base">trending_up</span>
                                                    @endif
                                                    {{ $tierOption }}
                                                </div>
                                                <p class="text-[10px] text-slate-400">
                                                    @if($tierOption === 'Best Performance')
                                                        Performa maksimal saat ini
                                                    @elseif($tierOption === 'Best Value')
                                                        Performa terbaik per rupiah
                                                    @else
                                                        Siap upgrade masa depan
                                                    @endif
                                                </p>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Apply Button -->
                            <button 
                                type="submit" 
                                class="w-full py-3 rounded-xl bg-primary text-white font-semibold hover:bg-blue-600 transition shadow-lg"
                            >
                                <span class="material-symbols-outlined text-base align-middle mr-1">refresh</span>
                                Perbarui Rekomendasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- Modal Pilih Komponen -->
        <div id="componentModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-card border border-white/10 rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-hidden shadow-2xl">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-card/95 backdrop-blur border-b border-white/10 px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 id="modalTitle" class="text-xl font-bold text-white">Pilih Komponen</h2>
                        <p id="modalSubtitle" class="text-sm text-slate-400 mt-1">Budget: Rp 0</p>
                    </div>
                    <button onclick="closeComponentModal()" class="size-10 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                    <div id="modalLoading" class="text-center py-12">
                        <div class="inline-block size-12 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
                        <p class="text-slate-400 mt-4">Memuat produk...</p>
                    </div>

                    <div id="modalContent" class="hidden space-y-3">
                        <!-- Products will be loaded here -->
                    </div>

                    <div id="modalEmpty" class="hidden text-center py-12">
                        <div class="size-20 rounded-full bg-white/5 mx-auto flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-4xl text-slate-500">inventory_2</span>
                        </div>
                        <p class="text-slate-400">Tidak ada produk alternatif tersedia</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let currentComponentType = '';
            let currentBudget = 0;

            function openComponentModal(componentType, budget, currentProductId) {
                currentComponentType = componentType;
                currentBudget = budget;
                
                // Component labels
                const labels = {
                    'processor': 'Processor (CPU)',
                    'gpu': 'Graphics Card (GPU)',
                    'motherboard': 'Motherboard',
                    'ram': 'RAM (Memory)',
                    'storage': 'Storage',
                    'psu': 'Power Supply (PSU)',
                    'casing': 'Casing',
                    'cpu_cooler': 'CPU Cooler'
                };

                // Update modal title
                document.getElementById('modalTitle').textContent = 'Pilih ' + labels[componentType];
                document.getElementById('modalSubtitle').textContent = 'Budget: Rp ' + budget.toLocaleString('id-ID');

                // Show modal
                document.getElementById('componentModal').classList.remove('hidden');
                
                // Show loading
                document.getElementById('modalLoading').classList.remove('hidden');
                document.getElementById('modalContent').classList.add('hidden');
                document.getElementById('modalEmpty').classList.add('hidden');

                // Fetch alternative products
                fetch(`/pc-builds/alternatives?component_type=${componentType}&budget=${budget}&current_product_id=${currentProductId || ''}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('modalLoading').classList.add('hidden');
                        
                        if (data.products && data.products.length > 0) {
                            document.getElementById('modalContent').classList.remove('hidden');
                            renderProducts(data.products);
                        } else {
                            document.getElementById('modalEmpty').classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('modalLoading').classList.add('hidden');
                        document.getElementById('modalEmpty').classList.remove('hidden');
                    });
            }

            function closeComponentModal() {
                document.getElementById('componentModal').classList.add('hidden');
            }

            function renderProducts(products) {
                const container = document.getElementById('modalContent');
                container.innerHTML = products.map(product => {
                    const priceFormatted = new Intl.NumberFormat('id-ID').format(product.price);
                    const rating = product.rating ? `<span class="text-xs text-yellow-400">★ ${product.rating.toFixed(1)}</span>` : '';
                    
                    // Handle image
                    let imageHtml = '';
                    if (product.image) {
                        imageHtml = `<img src="${product.image}" alt="${product.name}" class="w-20 h-20 object-cover rounded-xl border border-white/10" onerror="this.parentElement.innerHTML='<div class=\\'w-20 h-20 rounded-xl bg-white/5 flex items-center justify-center border border-white/10\\'><span class=\\'material-symbols-outlined text-slate-500\\'>image</span></div>'">`;
                    } else {
                        imageHtml = `<div class="w-20 h-20 rounded-xl bg-white/5 flex items-center justify-center border border-white/10"><span class="material-symbols-outlined text-slate-500">image</span></div>`;
                    }
                    
                    // Format specifications
                    let specsHtml = '';
                    if (product.specifications) {
                        specsHtml = `<p class="text-xs text-slate-400 mt-2">${product.specifications}</p>`;
                    } else if (product.description) {
                        specsHtml = `<p class="text-xs text-slate-400 mt-2 line-clamp-2">${product.description}</p>`;
                    }
                    
                    return `
                        <div class="p-4 rounded-2xl border border-white/10 bg-card hover:border-primary/40 hover:bg-card-hover transition-all cursor-pointer group"
                             onclick="selectProduct(${product.id}, '${product.name}', ${product.price})">
                            <div class="flex items-center gap-4">
                                ${imageHtml}
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-white group-hover:text-primary transition truncate">${product.name}</h3>
                                    <div class="flex items-center gap-3 mt-2">
                                        <p class="text-lg font-bold text-primary">Rp ${priceFormatted}</p>
                                        ${rating}
                                    </div>
                                    ${specsHtml}
                                </div>
                                <div class="opacity-0 group-hover:opacity-100 transition">
                                    <span class="material-symbols-outlined text-primary">arrow_forward</span>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            }

            function selectProduct(productId, productName, productPrice) {
                // Close modal
                closeComponentModal();
                
                // Show notification
                alert(`Produk dipilih: ${productName}\nHarga: Rp ${productPrice.toLocaleString('id-ID')}\n\nFitur ini akan segera diintegrasikan dengan sistem build.`);
                
                // TODO: Update build with selected product
                // This will be implemented with AJAX to update the build without page reload
            }

            // Close modal when clicking outside
            document.getElementById('componentModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeComponentModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeComponentModal();
                }
            });

            // Save Build Function
            function saveBuild() {
                const buildData = {
                    build_name: prompt('Nama rakitan PC Anda:', 'My PC Build'),
                    budget: {{ $budget }},
                    use_case: '{{ $useCase }}',
                    tier: '{{ $tier }}',
                    components: {
                        processor: {{ $componentDetails['processor']['product']->id ?? 'null' }},
                        gpu: {{ $componentDetails['gpu']['product']->id ?? 'null' }},
                        motherboard: {{ $componentDetails['motherboard']['product']->id ?? 'null' }},
                        ram: {{ $componentDetails['ram']['product']->id ?? 'null' }},
                        storage: {{ $componentDetails['storage']['product']->id ?? 'null' }},
                        psu: {{ $componentDetails['psu']['product']->id ?? 'null' }},
                        casing: {{ $componentDetails['casing']['product']->id ?? 'null' }},
                        cpu_cooler: {{ $componentDetails['cpu_cooler']['product']->id ?? 'null' }},
                    }
                };

                if (!buildData.build_name) {
                    return; // User cancelled
                }

                @auth
                    // Logged in user
                    fetch('{{ route('pc-builds.save') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(buildData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('✅ ' + data.message + '\n\nLihat di: Account > Rakitan Tersimpan');
                            // Optionally redirect
                            // window.location.href = '{{ route('account.my-builds') }}';
                        } else {
                            alert('❌ Gagal menyimpan build');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('❌ Terjadi kesalahan saat menyimpan build');
                    });
                @else
                    // Guest user
                    alert('⚠️ Silakan login terlebih dahulu untuk menyimpan rakitan PC Anda.');
                    window.location.href = '{{ route('login') }}?redirect=' + encodeURIComponent(window.location.href);
                @endauth
            }

            // Add to Cart Function
            function addToCart() {
                const components = {
                    processor: {{ $componentDetails['processor']['product']->id ?? 'null' }},
                    gpu: {{ $componentDetails['gpu']['product']->id ?? 'null' }},
                    motherboard: {{ $componentDetails['motherboard']['product']->id ?? 'null' }},
                    ram: {{ $componentDetails['ram']['product']->id ?? 'null' }},
                    storage: {{ $componentDetails['storage']['product']->id ?? 'null' }},
                    psu: {{ $componentDetails['psu']['product']->id ?? 'null' }},
                    casing: {{ $componentDetails['casing']['product']->id ?? 'null' }},
                    cpu_cooler: {{ $componentDetails['cpu_cooler']['product']->id ?? 'null' }},
                };

                fetch('{{ route('pc-builds.add-to-cart') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ components })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ ' + data.message + '\n\nTotal item di keranjang: ' + data.cart_count);
                        // Optionally redirect to cart
                        if (confirm('Lihat keranjang sekarang?')) {
                            window.location.href = '{{ route('cart.index') }}';
                        }
                    } else {
                        alert('❌ ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('❌ Terjadi kesalahan saat menambahkan ke keranjang');
                });
            }
        </script>
    </div>
</body>
</html>
