<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard • SEBATAS PC')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#135bec',
                        'background-dark': '#0b1020',
                        'card-dark': '#121627',
                        'card-hover': '#1e2236',
                    },
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Noto Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        glow: '0 0 35px rgba(19,91,236,0.35)',
                    },
                },
            },
        };
    </script>
    <style>
        body {
            font-family: 'Space Grotesk', 'Noto Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0b1020;
        }
        ::-webkit-scrollbar-thumb {
            background: #1d2335;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2c3451;
        }
    </style>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-background-dark text-white antialiased">
    <div class="min-h-screen bg-[#050915] text-white">
        @yield('content')
    </div>
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>
