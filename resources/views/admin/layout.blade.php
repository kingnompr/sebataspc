<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Admin Dashboard') - Sebatas PC</title>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet"/>
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Theme Configuration -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "primary-hover": "#0f4bc4",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1e293b",
                        "text-main": "#111318",
                        "text-secondary": "#616f89",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: { 
                        "DEFAULT": "0.25rem", 
                        "lg": "0.5rem", 
                        "xl": "0.75rem", 
                        "full": "9999px" 
                    },
                },
            },
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-text-main dark:text-white h-screen flex overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-surface-light dark:bg-surface-dark border-r border-gray-200 dark:border-gray-800 flex flex-col hidden md:flex z-20">
        <div class="p-6 flex items-center gap-3">
            <div class="bg-primary/10 p-2 rounded-lg">
                <span class="material-symbols-outlined text-primary text-3xl">computer</span>
            </div>
            <div>
                <h1 class="font-bold text-lg tracking-tight text-slate-900 dark:text-white">Sebatas PC</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Admin Dashboard</p>
            </div>
        </div>
        
        <nav class="flex-1 overflow-y-auto px-4 py-2 space-y-1">
            <!-- Dashboard -->
            <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->is('admin') || request()->is('admin/dashboard') ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800 hover:text-primary' }} group transition-colors" href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined">grid_view</span>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            
            <!-- Products -->
            <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->is('admin/products*') ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800 hover:text-primary' }} transition-colors" href="{{ route('admin.products.index') }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="text-sm font-medium">Produk</span>
            </a>
            
            <!-- Orders -->
            <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->is('admin/orders*') ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800 hover:text-primary' }} transition-colors" href="{{ route('admin.orders.index') }}">
                <span class="material-symbols-outlined">shopping_cart</span>
                <span class="text-sm font-medium">Pesanan</span>
                @if($stats['pending_orders'] ?? 0 > 0)
                    <span class="ml-auto bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">{{ $stats['pending_orders'] }}</span>
                @endif
            </a>
            
            <!-- Users -->
            <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->is('admin/users*') ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800 hover:text-primary' }} transition-colors" href="{{ route('admin.users.index') }}">
                <span class="material-symbols-outlined">group</span>
                <span class="text-sm font-medium">Pengguna</span>
            </a>
            
            <!-- Reports -->
            <a class="flex items-center gap-3 px-3 py-3 rounded-lg {{ request()->is('admin/reports*') ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-gray-800 hover:text-primary' }} transition-colors" href="{{ route('admin.reports.index') }}">
                <span class="material-symbols-outlined">bar_chart</span>
                <span class="text-sm font-medium">Laporan</span>
            </a>
            
            <div class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-800">
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="text-sm font-medium">Keluar</span>
                    </button>
                </form>
            </div>
        </nav>
        
        <div class="p-4 border-t border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="bg-primary rounded-full size-10 flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex flex-col">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Super Admin</p>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        <!-- Top Navigation Bar -->
        <header class="bg-surface-light dark:bg-surface-dark border-b border-gray-200 dark:border-gray-800 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 shrink-0">
            <button class="md:hidden text-slate-500 hover:text-primary">
                <span class="material-symbols-outlined">menu</span>
            </button>
            
            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-lg ml-4">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400">search</span>
                    </div>
                    <input class="block w-full pl-10 pr-3 py-2 border-none rounded-lg leading-5 bg-background-light dark:bg-gray-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary sm:text-sm" placeholder="Search orders, products, or users..." type="text"/>
                </div>
            </div>
            
            <!-- Right Actions -->
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-slate-500 hover:text-primary hover:bg-slate-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border-2 border-white dark:border-gray-800"></span>
                </button>
            </div>
        </header>
        
        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto space-y-6">
                <!-- Page Heading -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">@yield('page-description', 'Welcome back, here is what is happening today.')</p>
                    </div>
                    @yield('page-actions')
                </div>
                
                <!-- Main Content -->
                @yield('content')
            </div>
        </div>
    </main>
    
    @stack('scripts')
</body>
</html>
