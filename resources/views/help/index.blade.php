<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pusat Bantuan & FAQ • Sebatas PC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        body {
            font-family: 'Space Grotesk', system-ui, -apple-system, sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-white text-gray-900">
    <!-- Header -->
    <header class="border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="size-8 rounded bg-primary flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-xl">computer</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900">Sebatas PC</span>
                </div>
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">Home</a>
                    <a href="{{ route('pc-builds.builder') }}" class="text-gray-600 hover:text-gray-900">Rakit PC</a>
                    <a href="{{ route('products.catalog') }}" class="text-gray-600 hover:text-gray-900">Produk</a>
                    <a href="{{ route('home') }}#promo" class="text-gray-600 hover:text-gray-900">Promo</a>
                    <a href="{{ route('help.index') }}" class="text-primary font-semibold">Bantuan</a>
                </nav>
                <div class="flex items-center gap-3">
                    <div class="hidden lg:flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-50 px-3 py-2">
                        <span class="material-symbols-outlined text-gray-400 text-lg">search</span>
                        <input type="text" placeholder="Search components..." class="bg-transparent border-none text-sm text-gray-700 placeholder:text-gray-400 focus:outline-none w-40">
                    </div>
                    @auth
                        <a href="{{ route('account.overview') }}" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            Login
                        </a>
                    @endauth
                    <a href="{{ route('cart.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Cart
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 to-blue-700 py-16 text-white">
        <div class="mx-auto max-w-4xl px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Pusat Bantuan & FAQ</h1>
            <p class="text-lg text-blue-100 mb-8">
                Temukan jawaban cepat seputar rakitan PC, garansi, pengiriman, dan pembayaran<br>
                di sini. Kami siap membantu Anda membangun PC impian.
            </p>
            <form action="{{ route('help.index') }}" method="GET" class="flex items-center gap-3 max-w-2xl mx-auto">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                    <input 
                        type="text" 
                        name="q"
                        placeholder="Ketik pertanyaan Anda (misal: garansi, pengiriman...)" 
                        class="w-full h-14 pl-12 pr-4 rounded-xl border-0 text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-white"
                    >
                </div>
                <button type="submit" class="h-14 px-8 rounded-xl bg-white text-primary font-semibold hover:bg-blue-50 transition-colors">
                    Cari
                </button>
            </form>
        </div>
    </section>

    <!-- Tabs Section -->
    <section class="border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4">
            <nav class="flex gap-8 overflow-x-auto">
                <button class="border-b-2 border-primary py-4 text-sm font-semibold text-primary whitespace-nowrap">
                    Semua Topik
                </button>
                <button class="border-b-2 border-transparent py-4 text-sm font-medium text-gray-500 hover:text-gray-900 whitespace-nowrap">
                    Produk & Rakit PC
                </button>
                <button class="border-b-2 border-transparent py-4 text-sm font-medium text-gray-500 hover:text-gray-900 whitespace-nowrap">
                    Pemesanan
                </button>
                <button class="border-b-2 border-transparent py-4 text-sm font-medium text-gray-500 hover:text-gray-900 whitespace-nowrap">
                    Pengiriman
                </button>
                <button class="border-b-2 border-transparent py-4 text-sm font-medium text-gray-500 hover:text-gray-900 whitespace-nowrap">
                    Garansi & Retur
                </button>
            </nav>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
        <div class="mx-auto max-w-4xl px-4">
            <h2 class="text-3xl font-bold mb-8">Pertanyaan Populer</h2>
            <div class="space-y-4">
                @foreach($faqs as $index => $faq)
                    <div class="rounded-lg border border-gray-200 bg-white overflow-hidden">
                        <button 
                            type="button"
                            onclick="toggleFaq({{ $index }})"
                            class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 transition-colors"
                        >
                            <span class="font-semibold text-gray-900">{{ $faq['question'] }}</span>
                            <span id="icon-{{ $index }}" class="material-symbols-outlined text-gray-400 transition-transform">
                                expand_more
                            </span>
                        </button>
                        <div id="answer-{{ $index }}" class="hidden px-6 pb-4 text-gray-600 text-sm leading-relaxed">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-12 bg-blue-50">
        <div class="mx-auto max-w-4xl px-4 text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Masih butuh bantuan?</h3>
            <p class="text-gray-600 mb-6">Tim spesialis PC kami siap menjawab pertanyaan teknis Anda.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="mailto:support@sebataspc.com" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-50">
                    <span class="material-symbols-outlined text-lg">mail</span>
                    Email Support
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 rounded-lg bg-green-500 px-6 py-3 text-sm font-semibold text-white hover:bg-green-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    Chat WhatsApp
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white py-8">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-600">
                <p>© 2025 Sebatas PC. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-gray-900">Privacy Policy</a>
                    <a href="#" class="hover:text-gray-900">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleFaq(index) {
            const answer = document.getElementById('answer-' + index);
            const icon = document.getElementById('icon-' + index);
            
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</body>
</html>
