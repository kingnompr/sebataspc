<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rakit PC Impian • SEBATAS PC</title>
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
        <header class="border-b border-white/5 bg-surface/90 backdrop-blur">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4 md:px-0">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-2xl bg-primary/20 border border-primary/40 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-2xl">memory</span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-400">Sebatas PC</p>
                        <p class="text-lg font-semibold">RakitPC Configurator</p>
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

        <main class="mx-auto w-full max-w-6xl px-4 py-10 md:px-0">
            <nav class="text-xs uppercase tracking-[0.4em] text-slate-500">Home / Rakit PC / Builder</nav>
            
            <div class="mt-6 grid gap-6 lg:grid-cols-[320px,1fr]">
                <div class="rounded-3xl bg-card border border-white/5 p-6 shadow-2xl">
                    <h2 class="text-2xl font-bold">Rakit PC Impianmu</h2>
                    <p class="mt-1 text-sm text-slate-400">Masukkan budget dan tujuan penggunaan, kami carikan kombinasi produk terbaik.</p>
                    <form method="GET" action="{{ route('pc-builds.builder') }}" class="mt-8 space-y-8" id="builder-form">
                        <div>
                            <p class="text-xs uppercase tracking-[0.5em] text-slate-500">1. Anggaran Maksimal</p>
                            <div class="mt-3 rounded-2xl bg-white/5 p-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-400">Budget Saat Ini</span>
                                    <span id="budgetDisplay" class="font-semibold">Rp {{ number_format($budget, 0, ',', '.') }}</span>
                                </div>
                                <input type="range" id="budgetSlider" name="budget" min="5000000" max="50000000" step="500000" value="{{ $budget }}" class="mt-4 h-2 w-full cursor-pointer appearance-none rounded-full bg-[#1f2a41] accent-primary">
                                <div class="mt-2 flex items-center justify-between text-[11px] text-slate-500">
                                    <span>Rp 5jt</span>
                                    <span>Rp 50jt+</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.5em] text-slate-500">2. Tujuan Penggunaan</p>
                            <div class="mt-3 grid grid-cols-2 gap-3">
                                @foreach($useCases as $case)
                                    @php $isActive = $case === $selectedUseCase; @endphp
                                    <label class="cursor-pointer rounded-2xl border px-3 py-4 text-left text-sm font-semibold transition @if($isActive) border-primary bg-primary/10 text-white @else border-white/10 bg-white/5 text-slate-300 hover:border-primary/30 @endif">
                                        <input type="radio" name="use_case" value="{{ $case }}" class="sr-only" @if($isActive) checked @endif>
                                        <span class="material-symbols-outlined text-base mr-1 align-middle">stadia_controller</span>
                                        {{ $case }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @foreach($customSelections as $componentId => $productId)
                            <input type="hidden" name="custom[{{ $componentId }}]" value="{{ $productId }}">
                        @endforeach

                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-[0_4px_20px_rgba(19,91,236,0.35)] hover:bg-blue-600">
                            <span class="material-symbols-outlined text-base">autorenew</span>
                            Perbarui Rekomendasi
                        </button>
                    </form>
                </div>

                <section class="space-y-6">
                    <div class="rounded-3xl border border-white/5 bg-card p-6 shadow-2xl">
                        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Estimasi Total Harga</p>
                                <h3 class="mt-2 text-4xl font-semibold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</h3>
                                <p class="mt-2 text-sm text-emerald-400">Sesuai Budget (sisa Rp {{ number_format($remainingBudget, 0, ',', '.') }})</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-slate-300">
                                <p class="flex items-center gap-2 text-white"><span class="material-symbols-outlined text-primary">military_tech</span> Performa Gaming (1080p)</p>
                                <div class="mt-4 space-y-2">
                                    @foreach($benchmarks as $benchmark)
                                        <div>
                                            <div class="flex items-center justify-between text-xs">
                                                <span>{{ $benchmark['title'] }}</span>
                                                <span class="text-primary font-semibold">{{ $benchmark['fps'] }} FPS</span>
                                            </div>
                                            <div class="mt-1 h-2 rounded-full bg-white/10">
                                                <div class="h-full rounded-full bg-gradient-to-r from-primary to-cyan-400" style="width: {{ min(100, ($benchmark['fps'] / 300) * 100) }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold">Rekomendasi Spesifikasi</h4>
                        <a href="{{ route('pc-builds.builder') }}" class="text-sm text-primary hover:underline">Reset</a>
                    </div>

                    @if ($build)
                        <div class="space-y-4">
                            @foreach ($build->components as $component)
                                @php
                                    $product = $component->product;
                                    $image = $product?->image;
                                    $isAbsolute = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));
                                    $imageUrl = $image ? ($isAbsolute ? $image : asset(ltrim($image, '/'))) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80';
                                    $alternatives = $componentAlternatives[$component->id] ?? collect();
                                @endphp
                                <article class="rounded-3xl border border-white/5 bg-card p-4 transition hover:border-primary/40">
                                    <div class="flex gap-4">
                                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-2xl bg-black/30">
                                            <img src="{{ $imageUrl }}" alt="{{ $product->name ?? 'Produk' }}" class="h-full w-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-[11px] uppercase tracking-[0.4em] text-primary">{{ $component->component_type }}</p>
                                            <div class="flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
                                                <div>
                                                    <h5 class="text-lg font-semibold text-white">{{ $product->name ?? 'Produk belum dipilih' }}</h5>
                                                    <p class="text-sm text-slate-400">{{ \Illuminate\Support\Str::limit($product->description ?? 'Segera tambahkan deskripsi produk.', 90) }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-base font-semibold text-white">Rp {{ number_format(optional($product)->price ?? 0, 0, ',', '.') }}</p>
                                                    <p class="text-xs text-slate-500">Qty {{ $component->quantity }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" data-modal-open="modal-component-{{ $component->id }}" class="flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 text-slate-400 hover:border-primary hover:text-primary">
                                            <span class="material-symbols-outlined text-base">autorenew</span>
                                        </button>
                                    </div>
                                </article>

                                @if($alternatives->isNotEmpty())
                                    <div id="modal-component-{{ $component->id }}" class="modal fixed inset-0 z-40 hidden items-center justify-center bg-black/60 px-4 py-10">
                                        <div class="relative w-full max-w-2xl rounded-3xl border border-white/10 bg-card p-6 shadow-2xl">
                                            <button type="button" data-modal-close class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-full border border-white/10 text-slate-400 hover:text-white">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                            <h5 class="text-xl font-semibold text-white">Pilih {{ $component->component_type }} Alternatif</h5>
                                            <p class="text-sm text-slate-400">Produk lain dengan kategori serupa.</p>
                                            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                                @foreach($alternatives as $alternative)
                                                    <form method="GET" action="{{ route('pc-builds.builder') }}" class="rounded-2xl border border-white/5 bg-white/5 p-4 hover:border-primary/40">
                                                        <div class="flex items-center gap-3">
                                                            <div class="h-14 w-14 overflow-hidden rounded-2xl bg-black/30">
                                                                @php
                                                                    $altImage = $alternative->image;
                                                                    $altAbs = $altImage && (str_starts_with($altImage, 'http://') || str_starts_with($altImage, 'https://'));
                                                                    $altImageUrl = $altImage ? ($altAbs ? $altImage : asset(ltrim($altImage, '/'))) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80';
                                                                @endphp
                                                                <img src="{{ $altImageUrl }}" alt="{{ $alternative->name }}" class="h-full w-full object-cover">
                                                            </div>
                                                            <div>
                                                                <h6 class="text-sm font-semibold text-white">{{ $alternative->name }}</h6>
                                                                <p class="text-xs text-slate-400">Rp {{ number_format($alternative->price, 0, ',', '.') }}</p>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="budget" value="{{ $budget }}">
                                                        <input type="hidden" name="use_case" value="{{ $selectedUseCase }}">
                                                        @foreach($customSelections as $compId => $productId)
                                                            @if($compId !== $component->id)
                                                                <input type="hidden" name="custom[{{ $compId }}]" value="{{ $productId }}">
                                                            @endif
                                                        @endforeach
                                                        <input type="hidden" name="custom[{{ $component->id }}]" value="{{ $alternative->id }}">
                                                        <button type="submit" class="mt-4 w-full rounded-2xl bg-primary py-2 text-sm font-semibold text-white hover:bg-blue-600">Pilih Produk</button>
                                                    </form>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-3xl border border-dashed border-white/10 p-8 text-center text-slate-400">
                            Belum ada rekomendasi yang cocok dengan filter ini.
                        </div>
                    @endif

                    <div class="flex flex-col gap-3 rounded-3xl border border-white/5 bg-card/80 p-6 shadow-2xl md:flex-row md:items-center md:justify-between">
                        <button type="button" class="flex items-center justify-center gap-2 rounded-2xl border border-white/10 px-5 py-3 text-sm font-semibold text-white hover:border-primary/40">
                            <span class="material-symbols-outlined text-base">share</span>
                            Bagikan Build
                        </button>
                        <a href="{{ route('cart.index') }}" class="flex flex-1 items-center justify-center gap-2 rounded-2xl bg-primary px-5 py-3 text-center text-sm font-semibold text-white shadow-[0_4px_20px_rgba(19,91,236,0.25)] hover:bg-blue-600">
                            <span class="material-symbols-outlined text-base">shopping_cart_checkout</span>
                            Beli Semua Produk
                        </a>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        const slider = document.getElementById('budgetSlider');
        const display = document.getElementById('budgetDisplay');
        if (slider && display) {
            const format = new Intl.NumberFormat('id-ID');
            const updateBudget = () => {
                display.textContent = `Rp ${format.format(slider.value)}`;
            };
            slider.addEventListener('input', updateBudget);
            updateBudget();
        }

        const modalButtons = document.querySelectorAll('[data-modal-open]');
        const closeButtons = () => document.querySelectorAll('[data-modal-close]');

        modalButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-modal-open');
                const modal = document.getElementById(targetId);
                if (modal) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
            });
        });

        document.addEventListener('click', (event) => {
            if (event.target.matches('[data-modal-close]') || event.target.closest('[data-modal-close]')) {
                const modal = event.target.closest('.modal');
                if (modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            }
        });

        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('modal')) {
                event.target.classList.add('hidden');
                event.target.classList.remove('flex');
            }
        });
    </script>
</body>
</html>
