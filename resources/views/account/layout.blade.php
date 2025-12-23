<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Akun Saya') • Sebatas PC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD@400,0,0&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header Navbar -->
    <header class="border-b border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="size-8 rounded bg-primary flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-xl">computer</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900">Sebatas PC</span>
                </div>
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">Home</a>
                    <a href="{{ route('pc-builds.builder') }}" class="text-gray-600 hover:text-gray-900">Rakit PC</a>
                    <a href="{{ route('products.catalog') }}" class="text-gray-600 hover:text-gray-900">Produk</a>
                    <a href="{{ route('help.index') }}" class="text-gray-600 hover:text-gray-900">Bantuan</a>
                </nav>
                <div class="flex items-center gap-2">
                    <div class="relative hidden lg:block">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                        <input type="text" placeholder="Cari produk..." class="w-48 pl-10 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-gray-900">
                        <span class="material-symbols-outlined">shopping_cart</span>
                        <span class="absolute top-0 right-0 size-4 bg-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center">0</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="bg-gray-50 border-b border-gray-200">
        <div class="mx-auto max-w-7xl px-4 py-3">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-gray-900">Beranda</a>
                <span>/</span>
                <span class="text-gray-900 font-medium">Akun Saya</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-4 py-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Akun Saya</h1>
            <p class="text-gray-600 mt-1">Kelola profil, pesanan, dan rakitan PC impian Anda yang tersimpan.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar Navigation -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <a href="{{ route('account.overview') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('account.overview') ? 'bg-blue-50 text-primary font-medium border-l-4 border-primary' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                        <span class="material-symbols-outlined text-xl">dashboard</span>
                        Ringkasan Akun
                    </a>
                    <a href="{{ route('account.payments') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('account.payments') ? 'bg-blue-50 text-primary font-medium border-l-4 border-primary' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                        <span class="material-symbols-outlined text-xl">shopping_bag</span>
                        Pesanan Saya
                    </a>
                    <a href="{{ route('account.my-builds') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('account.my-builds') ? 'bg-blue-50 text-primary font-medium border-l-4 border-primary' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                        <span class="material-symbols-outlined text-xl">memory</span>
                        Rakitan Tersimpan
                    </a>
                    <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('account.addresses') ? 'bg-blue-50 text-primary font-medium border-l-4 border-primary' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                        <span class="material-symbols-outlined text-xl">home</span>
                        Alamat Saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 border-l-4 border-transparent">
                            <span class="material-symbols-outlined text-xl">logout</span>
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="lg:col-span-3 space-y-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white mt-12">
        <div class="mx-auto max-w-7xl px-4 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-600">
                <p>© {{ date('Y') }} Sebatas PC. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-gray-900">Privacy Policy</a>
                    <a href="#" class="hover:text-gray-900">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
