<!DOCTYPE html>

<html class="dark" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Halaman Beranda Toko PC - Sebatas PC</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&amp;family=Noto+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                        "card-dark": "#1a1a1f",
                        "card-hover": "#222229",
                    },
                    fontFamily: {
                        "display": ["Space Grotesk", "sans-serif"],
                        "body": ["Noto Sans", "sans-serif"],
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
<style>
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #101622;
        }
        ::-webkit-scrollbar-thumb {
            background: #282e39;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #3b4354;
        }
        
        /* Hide scrollbar for horizontal scroll */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display overflow-x-hidden antialiased selection:bg-primary selection:text-white">
@php
    $highlightProduct = $featuredProduct ?? null;
    $highlightProductName = $highlightProduct?->name ?? 'Rakitan Favorit';
    $highlightProductPrice = $highlightProduct?->price ? 'Rp '.number_format($highlightProduct->price, 0, ',', '.') : 'Eksplor Produk';
    $highlightProductUrl = $highlightProduct ? route('products.show', $highlightProduct->slug) : route('products.catalog');
@endphp
<!-- Top Navigation -->
<div class="sticky top-0 z-50 border-b border-white/10 bg-background-dark/80 backdrop-blur-md">
<div class="layout-container flex w-full justify-center">
<div class="flex w-full max-w-[1440px] flex-col px-4 md:px-10 py-3">
<header class="flex items-center justify-between whitespace-nowrap">
<div class="flex items-center gap-8">
<a href="{{ route('home') }}" class="flex items-center gap-3 text-white hover:opacity-80 transition-opacity">
<div class="size-8 flex items-center justify-center text-primary">
<span class="material-symbols-outlined text-4xl">memory</span>
</div>
<h2 class="text-white text-xl font-bold leading-tight tracking-tight hidden md:block">Sebatas PC</h2>
</a>
<div class="hidden lg:flex items-center gap-8">
<a class="text-gray-300 hover:text-white text-sm font-medium transition-colors" href="{{ route('products.catalog') }}">Produk</a>
<a class="text-primary text-sm font-bold transition-colors hover:text-white" href="{{ route('pc-builds.builder') }}">Rakit PC</a>
</div>
</div>
<div class="flex flex-1 justify-end gap-4 md:gap-8 items-center">
<label class="hidden md:flex flex-col min-w-40 h-10 max-w-64 w-full group">
<div class="flex w-full flex-1 items-stretch rounded-lg h-full bg-[#282e39] group-focus-within:ring-2 ring-primary transition-all">
<div class="text-[#9da6b9] flex border-none items-center justify-center pl-3 pr-1">
<span class="material-symbols-outlined text-[20px]">search</span>
</div>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg rounded-l-none text-white focus:outline-0 bg-transparent border-none placeholder:text-[#9da6b9] px-2 text-sm font-normal" placeholder="Cari produk..." value=""/>
</div>
</label>
<div class="flex gap-3">
@auth
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex size-10 cursor-pointer items-center justify-center rounded-lg bg-[#282e39] hover:bg-[#3b4354] transition-colors text-white overflow-hidden">
        @if(auth()->user()->profile_photo_path)
            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
        @else
            <span class="text-sm font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        @endif
    </button>
    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 rounded-lg bg-[#1a1a1f] border border-white/10 shadow-xl py-2 z-50">
        <div class="px-4 py-3 border-b border-white/10">
            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
        </div>
        <a href="{{ route('account.overview') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-[#282e39] hover:text-white transition-colors">
            <span class="material-symbols-outlined text-[18px]">dashboard</span>
            Dashboard
        </a>
        <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-300 hover:bg-[#282e39] hover:text-white transition-colors">
            <span class="material-symbols-outlined text-[18px]">favorite</span>
            Wishlist
        </a>
        <div class="border-t border-white/10 mt-2 pt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-[#282e39] hover:text-red-300 transition-colors w-full text-left">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>
@else
<a href="{{ route('login') }}" class="flex size-10 cursor-pointer items-center justify-center rounded-lg bg-[#282e39] hover:bg-[#3b4354] transition-colors text-white">
<span class="material-symbols-outlined text-[20px]">person</span>
</a>
@endauth
<a href="{{ route('cart.index') }}" class="relative flex size-10 cursor-pointer items-center justify-center rounded-lg bg-[#282e39] hover:bg-[#3b4354] transition-colors text-white">
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
</div>
</div>
</header>
</div>
</div>
</div>
<!-- Main Content -->
<main class="flex min-h-screen flex-col items-center">
<!-- Hero Section -->
<section class="w-full max-w-[1440px] px-4 md:px-10 py-8 md:py-12">
<div class="@container">
<div class="flex flex-col-reverse lg:flex-row gap-8 lg:gap-16 items-center">
<!-- Text Content -->
<div class="flex flex-col gap-6 lg:w-1/2 items-start text-left z-10">
<div class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary border border-primary/20">
<span class="relative flex h-2 w-2">
<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
<span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
</span>
                            Fitur Baru: Smart PC Builder
                        </div>
<h1 class="text-white text-4xl sm:text-5xl lg:text-6xl font-bold leading-[1.1] tracking-tight">
                            Rakit PC Impianmu,<br/>
<span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-400">Performa Maksimal.</span>
</h1>
<p class="text-gray-400 text-lg max-w-lg font-body leading-relaxed">
                            Gunakan fitur Smart PC Builder kami untuk mendapatkan spesifikasi terbaik sesuai budget Anda. Dirakit oleh ahli, bergaransi resmi.
                        </p>
<!-- Trust Signals -->
<div class="mt-4 flex flex-wrap gap-x-8 gap-y-2 text-sm text-gray-400">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-lg">verified</span>
<span>Garansi Resmi</span>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-lg">build</span>
<span>Rakit Gratis</span>
</div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-lg">local_shipping</span>
<span>Pengiriman Aman</span>
</div>
</div>
</div>
<!-- Hero Image -->
<div class="w-full lg:w-1/2 relative group">
<!-- Decorative Glow -->
<div class="absolute -inset-4 bg-primary/20 rounded-full blur-[80px] opacity-50 group-hover:opacity-75 transition-opacity duration-500"></div>
<div class="relative w-full aspect-[4/3] bg-center bg-contain bg-no-repeat rounded-xl z-10 transform transition-transform duration-700 hover:scale-[1.02]" data-alt="High-end gaming PC case with RGB liquid cooling and glass side panel" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBSDkZ71ZtmHciaZP_kMRxdThkn-SQuIp2nCOvkRYf_NACT8SYqJvk9ofDkR_5WOSTN0Dk6AgTw445DlerCwZ-t4TSvjWx47Cvk48PWSOyKZjn8nxAeuYuNB3GZn387H9dn2C2rKtnOGtWeK3BcAfIxUbggqQbRRNvKJ9gY3YJTTnQ7052dNiD6k1Ly1MrFX8Hf3AFjq1-iHTvEpPKyLbasJnsUu3h5vJrjJolmkHWEAA14QYezUjAxay3IlJNr6Ck7KkWI4yHCQKHo");'>
</div>
</div>
</div>
</div>
</section>
<!-- Brands Marquee (Visual separator) -->
<section class="w-full border-y border-white/5 bg-[#0f131a] py-6 mb-16 overflow-hidden">
<div class="layout-container flex justify-center">
<div class="flex gap-12 md:gap-24 opacity-40 grayscale items-center justify-center flex-wrap px-4">
<!-- Text placeholders for logos to keep it simple and clean without external SVGs -->
<span class="text-xl font-bold tracking-widest">NVIDIA</span>
<span class="text-xl font-bold tracking-widest">INTEL</span>
<span class="text-xl font-bold tracking-widest">AMD</span>
<span class="text-xl font-bold tracking-widest">ASUS</span>
<span class="text-xl font-bold tracking-widest">MSI</span>
<span class="text-xl font-bold tracking-widest">CORSAIR</span>
</div>
</div>
</section>
<!-- PC Builder Budget Widget -->
<section class="w-full max-w-[960px] px-4 md:px-10 mb-20">
<div class="relative overflow-hidden rounded-2xl bg-card-dark border border-white/5 p-8 md:p-12 text-center shadow-2xl">
<!-- Background Decoration -->
<div class="absolute top-0 right-0 -mr-16 -mt-16 h-64 w-64 rounded-full bg-primary/10 blur-[60px]"></div>
<div class="absolute bottom-0 left-0 -ml-16 -mb-16 h-64 w-64 rounded-full bg-purple-500/10 blur-[60px]"></div>
<div class="relative z-10 flex flex-col items-center">
<span class="material-symbols-outlined text-4xl text-primary mb-4">tune</span>
<h2 class="text-white text-3xl md:text-4xl font-bold leading-tight mb-2">Tentukan Budget Rakitanmu</h2>
<p class="text-gray-400 mb-8 max-w-lg">Geser slider di bawah untuk menemukan kombinasi produk terbaik sesuai dengan dana yang Anda miliki.</p>
<div class="w-full max-w-2xl bg-[#282e39]/50 rounded-xl p-6 border border-white/5 backdrop-blur-sm">
<div class="flex flex-col gap-6">
<div class="flex items-center justify-between">
<p class="text-gray-300 font-medium">Perkiraan Budget</p>
<div class="bg-primary/20 border border-primary/30 text-primary px-3 py-1 rounded-lg font-mono font-bold" id="budgetDisplay">
                                    Rp 15.000.000
                                </div>
</div>
<!-- Custom Slider UI -->
<div class="relative h-6 w-full flex items-center group">
<input type="range" id="budgetSlider" min="5000000" max="100000000" value="15000000" step="1000000" class="absolute w-full h-2 opacity-0 cursor-pointer z-10">
<div class="absolute w-full h-2 bg-[#3b4354] rounded-full overflow-hidden pointer-events-none">
<div id="sliderProgress" class="h-full w-[10%] bg-gradient-to-r from-primary to-blue-400 transition-all"></div>
</div>
<div id="sliderThumb" class="absolute left-[10%] size-6 bg-white border-2 border-primary rounded-full shadow-lg transform -translate-x-1/2 transition-all pointer-events-none"></div>
</div>
<div class="flex justify-between text-xs text-gray-500 font-mono">
<span>Rp 5 Jt</span>
<span>Rp 100 Jt+</span>
</div>
</div>
</div>
<div class="mt-8">
<a href="{{ route('pc-builds.builder') }}" id="budgetLink" class="flex items-center justify-center gap-2 overflow-hidden rounded-lg h-12 px-8 bg-primary hover:bg-blue-600 text-white text-base font-bold shadow-[0_4px_20px_rgba(19,91,236,0.25)] transition-all hover:scale-105">
<span class="material-symbols-outlined text-[20px]">auto_awesome</span>
<span>Cari Rekomendasi Rakitan</span>
</a>
</div>
<script>
const slider = document.getElementById('budgetSlider');
const display = document.getElementById('budgetDisplay');
const progress = document.getElementById('sliderProgress');
const thumb = document.getElementById('sliderThumb');
const link = document.getElementById('budgetLink');

function formatRupiah(num) {
    return 'Rp ' + (num / 1000000).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + '.000.000';
}

function updateSlider() {
    const value = slider.value;
    const min = slider.min;
    const max = slider.max;
    const percentage = ((value - min) / (max - min)) * 100;
    
    display.textContent = formatRupiah(value);
    progress.style.width = percentage + '%';
    thumb.style.left = percentage + '%';
    link.href = "{{ route('pc-builds.builder') }}?budget=" + value;
}

slider.addEventListener('input', updateSlider);
updateSlider();
</script>
</div>
</div>
</section>
<!-- Product Categories / Grid -->
<section class="w-full max-w-[1440px] px-4 md:px-10 mb-20">
<div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
<div>
<h3 class="text-2xl md:text-3xl font-bold text-white mb-2">Produk Pilihan</h3>
<p class="text-gray-400">Upgrade PC-mu dengan hardware terbaru bulan ini.</p>
</div>
<a class="flex items-center gap-1 text-primary hover:text-white font-medium transition-colors" href="{{ route('products.catalog') }}">
                    Lihat Semua <span class="material-symbols-outlined text-lg">arrow_forward</span>
</a>
</div>

<!-- Horizontal Scroll Container -->
<div class="relative">
    <!-- Scroll Buttons -->
    <button id="scroll-left" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-primary/80 hover:bg-primary text-white p-3 rounded-full shadow-lg transition-all opacity-0 pointer-events-none">
        <span class="material-symbols-outlined">chevron_left</span>
    </button>
    <button id="scroll-right" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-primary/80 hover:bg-primary text-white p-3 rounded-full shadow-lg transition-all">
        <span class="material-symbols-outlined">chevron_right</span>
    </button>
    
    <!-- Scrollable Product Grid -->
    <div id="product-scroll" class="overflow-x-auto scrollbar-hide scroll-smooth pb-4">
        <div class="flex gap-6" style="width: max-content;">
@forelse($featuredProducts as $product)
    @php
        $image = $product->image;
        $isAbsolute = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'));
        $imageUrl = $image ? ($isAbsolute ? $image : asset($image)) : 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80';
        $inWishlist = auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
    @endphp
    
<div class="group bg-card-dark border border-white/5 rounded-xl overflow-hidden hover:border-primary/50 transition-all duration-300 hover:shadow-[0_10px_30px_rgba(0,0,0,0.5)] flex-shrink-0" style="width: 280px;">
<div class="relative w-full aspect-square bg-[#151921] p-6 flex items-center justify-center">
<div class="absolute top-3 right-3 z-10">
@auth
    @if($inWishlist)
        <form method="POST" action="{{ route('wishlist.destroy', \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first()) }}" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-black/40 hover:bg-primary/80 p-2 rounded-full text-rose-400 backdrop-blur-sm transition-colors">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('wishlist.store') }}" class="inline">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="bg-black/40 hover:bg-primary/80 p-2 rounded-full text-white backdrop-blur-sm transition-colors">
                <span class="material-symbols-outlined text-[20px]">favorite</span>
            </button>
        </form>
    @endif
@else
<a href="{{ route('login') }}" class="bg-black/40 hover:bg-primary/80 p-2 rounded-full text-white backdrop-blur-sm transition-colors inline-block">
<span class="material-symbols-outlined text-[20px]">favorite</span>
</a>
@endauth
</div>
<a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-110" loading="eager" />
</a>
</div>
<div class="p-4">
<div class="flex gap-2 mb-3">
<span class="text-[10px] font-bold uppercase tracking-wider bg-primary/20 text-primary px-2 py-1 rounded">{{ $product->category->name ?? 'PRODUK' }}</span>
@if($product->stock > 0)
    <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-400 px-2 py-1 rounded">TERSEDIA</span>
@else
    <span class="text-[10px] font-bold uppercase tracking-wider bg-rose-500/20 text-rose-400 px-2 py-1 rounded">HABIS</span>
@endif
</div>
<a href="{{ route('products.show', $product->slug) }}">
    <h4 class="text-white font-bold text-lg leading-tight mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ $product->name }}</h4>
</a>
<p class="text-2xl font-bold text-white mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
@if($product->stock > 0)
    <form method="POST" action="{{ route('cart.items.store') }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="1">
        <button type="submit" class="w-full py-2.5 rounded-lg border border-white/10 hover:border-primary hover:bg-primary/10 text-white font-medium text-sm transition-all flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
            Tambah ke Keranjang
        </button>
    </form>
@else
    <button disabled class="w-full py-2.5 rounded-lg border border-white/10 bg-white/5 text-slate-500 font-medium text-sm cursor-not-allowed flex items-center justify-center gap-2">
        <span class="material-symbols-outlined text-[18px]">block</span>
        Stok Habis
    </button>
@endif
</div>
</div>
@empty
<div class="w-full text-center py-12">
    <p class="text-slate-400">Belum ada produk tersedia</p>
</div>
@endforelse
        </div>
    </div>
</div>
</section>

</main>
<!-- Footer -->
<footer class="bg-[#0f131a] border-t border-white/5 pt-16 pb-8">
<div class="layout-container flex w-full justify-center">
<div class="flex w-full max-w-[1440px] flex-col px-4 md:px-10">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
<!-- Column 1 -->
<div class="flex flex-col gap-4">
<div class="flex items-center gap-3 text-white">
<span class="material-symbols-outlined text-3xl text-primary">memory</span>
<span class="text-xl font-bold">Sebatas PC</span>
</div>
<p class="text-gray-400 text-sm leading-relaxed">
                            Toko komputer terlengkap dan terpercaya. Spesialis rakit PC gaming dan workstation profesional.
                        </p>
<div class="flex gap-4 mt-2">
<a class="text-gray-400 hover:text-white transition-colors" href="#"><span class="material-symbols-outlined">call</span></a>
<a class="text-gray-400 hover:text-white transition-colors" href="#"><span class="material-symbols-outlined">mail</span></a>
<a class="text-gray-400 hover:text-white transition-colors" href="#"><span class="material-symbols-outlined">pin_drop</span></a>
</div>
</div>
<!-- Column 2 -->
<div class="flex flex-col gap-4">
<h4 class="text-white font-bold text-lg">Newsletter</h4>
<p class="text-gray-400 text-sm">Dapatkan info promo dan rakitan terbaru.</p>
<div class="flex gap-2">
<input class="bg-[#1a1a1f] border border-white/10 rounded-lg px-4 py-2 text-sm text-white w-full focus:ring-1 focus:ring-primary focus:outline-none" placeholder="Email Anda" type="email"/>
<button class="bg-primary hover:bg-blue-600 text-white rounded-lg px-3 py-2 transition-colors">
<span class="material-symbols-outlined text-[20px]">send</span>
</button>
</div>
</div>
</div>
<div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
<p class="text-gray-500 text-sm">© 2024 Sebatas PC. All rights reserved.</p>
<div class="flex gap-6 text-gray-500 text-sm">
<a class="hover:text-white" href="#">Privacy Policy</a>
<a class="hover:text-white" href="#">Terms of Service</a>
</div>
</div>
</div>
</div>
</footer>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-6 right-6 bg-[#1a1a1f] border border-primary/50 rounded-xl px-6 py-4 shadow-2xl transform translate-y-32 opacity-0 transition-all duration-300 z-50">
    <div class="flex items-center gap-3">
        <span class="material-symbols-outlined text-primary text-2xl"></span>
        <p class="text-white font-medium"></p>
    </div>
</div>

<script>
function showToast(message, icon = 'check_circle') {
    const toast = document.getElementById('toast');
    const iconEl = toast.querySelector('.material-symbols-outlined');
    const textEl = toast.querySelector('p');
    
    iconEl.textContent = icon;
    textEl.textContent = message;
    
    toast.classList.remove('translate-y-32', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');
    
    setTimeout(() => {
        toast.classList.add('translate-y-32', 'opacity-0');
        toast.classList.remove('translate-y-0', 'opacity-100');
    }, 3000);
}

// Horizontal scroll for featured products
document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.getElementById('product-scroll');
    const scrollLeftBtn = document.getElementById('scroll-left');
    const scrollRightBtn = document.getElementById('scroll-right');
    
    if (!scrollContainer || !scrollLeftBtn || !scrollRightBtn) return;
    
    function updateScrollButtons() {
        const scrollLeft = scrollContainer.scrollLeft;
        const scrollWidth = scrollContainer.scrollWidth;
        const clientWidth = scrollContainer.clientWidth;
        
        // Show/hide left button
        if (scrollLeft > 0) {
            scrollLeftBtn.classList.remove('opacity-0', 'pointer-events-none');
        } else {
            scrollLeftBtn.classList.add('opacity-0', 'pointer-events-none');
        }
        
        // Show/hide right button
        if (scrollLeft + clientWidth < scrollWidth - 10) {
            scrollRightBtn.classList.remove('opacity-0', 'pointer-events-none');
        } else {
            scrollRightBtn.classList.add('opacity-0', 'pointer-events-none');
        }
    }
    
    scrollLeftBtn.addEventListener('click', function() {
        scrollContainer.scrollBy({ left: -300, behavior: 'smooth' });
    });
    
    scrollRightBtn.addEventListener('click', function() {
        scrollContainer.scrollBy({ left: 300, behavior: 'smooth' });
    });
    
    scrollContainer.addEventListener('scroll', updateScrollButtons);
    
    // Initial check
    updateScrollButtons();
});
</script>
</body></html>
