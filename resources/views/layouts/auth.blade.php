<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk / Daftar - Sebatas PC')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Space Grotesk", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
        }
    </style>
</head>
<body class="font-display bg-background-light text-gray-900 flex flex-col min-h-screen transition-colors duration-200">
    <header class="sticky top-0 z-50 flex items-center justify-between whitespace-nowrap border-b border-solid border-gray-200 bg-white/90 backdrop-blur-md px-10 py-3">
        <div class="flex items-center gap-4 text-gray-900">
            <div class="size-8 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined !text-[32px]">computer</span>
            </div>
            <h2 class="text-gray-900 text-xl font-bold leading-tight tracking-[-0.015em]">Sebatas PC</h2>
        </div>
        <div class="flex flex-1 justify-end gap-8">
            <div class="hidden md:flex items-center gap-9">
                <a class="text-gray-700 hover:text-primary transition-colors text-sm font-medium leading-normal" href="{{ route('home') }}">Home</a>
                <a class="text-gray-700 hover:text-primary transition-colors text-sm font-medium leading-normal" href="{{ route('help.index') }}">Bantuan</a>
            </div>
        </div>
    </header>

    <div class="flex-1 flex items-center justify-center p-4 md:p-10">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-[1100px] overflow-hidden flex flex-col lg:flex-row min-h-[600px] border border-gray-100">
            <div class="hidden lg:flex lg:w-1/2 bg-gray-900 relative overflow-hidden group">
                <img alt="Custom built gaming PC with RGB lighting" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD8q2C9QSbYTwC-gqySS5-G_U_xGJB309cjtGiLfuH0l-pBSvN_po4PcMEZgKUJO9mrZcrzZmKHLhjqMWgZR7yiXJXZW2wamENkJrP1Tb7tHjK5LGhBec2vK9JqM4t-DM2hUuX3I_u7b20jB7dp1Rk9hEHlwjpB-Bp_h7tvgvYPBJL2Thwte_sG5FDF0rxzoWboQ4y0tKXtgo4g_KQqkjccbSxigZHK-NhB0oGOZcA3qLUZofuzjeA4eOzFa5trCay-sAbFn9Jlzjj8"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                <div class="relative z-10 mt-auto p-10 flex flex-col gap-4 text-white">
                    <div class="inline-flex items-center justify-center size-12 rounded-full bg-primary/20 backdrop-blur-sm mb-2 border border-primary/30">
                        <span class="material-symbols-outlined text-primary">memory</span>
                    </div>
                    <h3 class="text-3xl font-bold leading-tight">Rakit performa tanpa batas.</h3>
                    <p class="text-gray-300 text-lg leading-relaxed">Bergabunglah dengan komunitas builder PC terbesar. Simpan rakitan impianmu dan dapatkan rekomendasi harga terbaik.</p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center bg-white">
                @yield('content')
            </div>
        </div>

        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/5 rounded-full blur-[100px]"></div>
            <div class="absolute top-[40%] -right-[10%] w-[30%] h-[30%] bg-blue-400/5 rounded-full blur-[100px]"></div>
        </div>
    </div>
</body>
</html>
