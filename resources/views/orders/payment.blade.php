<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Pesanan {{ $orderNumber }} • SEBATAS PC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD@400,0,0&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#135bec',
                    },
                },
            },
        };

        function copyVA() {
            const vaNumber = '{{ $virtualAccount }}';
            navigator.clipboard.writeText(vaNumber).then(() => {
                alert('Nomor Virtual Account berhasil disalin!');
            });
        }
    </script>
    <style>
        body { font-family: 'Space Grotesk', 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen">
        <header class="border-b border-gray-200 bg-white">
            <div class="mx-auto max-w-5xl px-4 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold tracking-[0.35em] text-gray-400">SEBATAS PC</p>
                        <h1 class="text-2xl font-semibold">Pembayaran Pesanan</h1>
                        <p class="text-sm text-gray-500">No. Pesanan: <span class="font-semibold text-primary">{{ $orderNumber }}</span></p>
                    </div>
                    <a href="{{ route('account.payments') }}" class="inline-flex items-center gap-2 rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        ← Kembali ke Pesanan
                    </a>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-4 py-10">
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Payment Details -->
                <div class="lg:col-span-2">
                    <div class="rounded-2xl border border-gray-200 bg-white p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pembayaran</h2>

                        @if($checkoutData['payment_method'] === 'cod')
                            <!-- Cash on Delivery -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 mb-2">Bayar di Tempat (COD)</h3>
                                        <p class="text-sm text-gray-600 mb-4">Siapkan uang tunai saat paket Anda tiba</p>
                                        <div class="bg-white border border-blue-300 rounded-lg p-4">
                                            <p class="text-sm text-gray-600 mb-1">Total yang harus dibayar:</p>
                                            <p class="text-3xl font-bold text-primary">Rp {{ number_format($summary['total'], 0, ',', '.') }}</p>
                                        </div>
                                        <div class="mt-4 text-sm text-gray-600">
                                            <p class="font-medium mb-2">Catatan:</p>
                                            <ul class="list-disc list-inside space-y-1">
                                                <li>Siapkan uang pas untuk mempermudah transaksi</li>
                                                <li>Periksa paket sebelum melakukan pembayaran</li>
                                                <li>Pastikan kondisi produk sesuai pesanan</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @elseif(in_array($checkoutData['payment_method'], ['bank_mandiri', 'bank_bca', 'bank_bri']))
                            <!-- Bank Transfer -->
                            @php
                                $bankName = match($checkoutData['payment_method']) {
                                    'bank_mandiri' => 'Bank Mandiri',
                                    'bank_bca' => 'Bank BCA',
                                    'bank_bri' => 'Bank BRI',
                                };
                            @endphp
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 mb-2">Transfer Bank - {{ $bankName }}</h3>
                                        <p class="text-sm text-gray-600 mb-4">Gunakan nomor Virtual Account berikut untuk melakukan pembayaran</p>
                                        
                                        <div class="bg-white border border-green-300 rounded-lg p-4 mb-4">
                                            <p class="text-sm text-gray-600 mb-1">Nomor Virtual Account:</p>
                                            <div class="flex items-center justify-between">
                                                <p class="text-2xl font-bold text-gray-900 tracking-wider">{{ $virtualAccount }}</p>
                                                <button onclick="copyVA()" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                                                    Salin
                                                </button>
                                            </div>
                                        </div>

                                        <div class="bg-white border border-green-300 rounded-lg p-4 mb-4">
                                            <p class="text-sm text-gray-600 mb-1">Total Transfer:</p>
                                            <p class="text-2xl font-bold text-primary">Rp {{ number_format($summary['total'], 0, ',', '.') }}</p>
                                        </div>

                                        <div class="text-sm text-gray-600">
                                            <p class="font-medium mb-2">Cara Transfer:</p>
                                            <ol class="list-decimal list-inside space-y-1">
                                                <li>Buka aplikasi mobile banking atau internet banking {{ $bankName }}</li>
                                                <li>Pilih menu Transfer ke Virtual Account</li>
                                                <li>Masukkan nomor Virtual Account di atas</li>
                                                <li>Masukkan nominal Rp {{ number_format($summary['total'], 0, ',', '.') }}</li>
                                                <li>Konfirmasi dan selesaikan pembayaran</li>
                                            </ol>
                                            <p class="mt-3 text-xs bg-yellow-100 border border-yellow-300 rounded p-2 text-yellow-800">
                                                <strong>Penting:</strong> Setelah transfer, pembayaran Anda akan diverifikasi otomatis. Status pesanan akan berubah menjadi "Sudah Dibayar" setelah verifikasi selesai (biasanya 5-15 menit).
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @elseif(in_array($checkoutData['payment_method'], ['dana', 'gopay']))
                            <!-- E-Wallet -->
                            @php
                                $walletName = match($checkoutData['payment_method']) {
                                    'dana' => 'DANA',
                                    'gopay' => 'GoPay',
                                };
                            @endphp
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 mb-2">E-Wallet - {{ $walletName }}</h3>
                                        <p class="text-sm text-gray-600 mb-4">Lakukan pembayaran melalui aplikasi {{ $walletName }}</p>

                                        <div class="bg-white border border-purple-300 rounded-lg p-4 mb-4">
                                            <p class="text-sm text-gray-600 mb-1">Total Pembayaran:</p>
                                            <p class="text-2xl font-bold text-primary">Rp {{ number_format($summary['total'], 0, ',', '.') }}</p>
                                        </div>

                                        <div class="text-sm text-gray-600">
                                            <p class="font-medium mb-2">Cara Pembayaran:</p>
                                            <ol class="list-decimal list-inside space-y-1">
                                                <li>Buka aplikasi {{ $walletName }} di HP Anda</li>
                                                <li>Scan QR Code atau masukkan nomor merchant</li>
                                                <li>Masukkan nominal Rp {{ number_format($summary['total'], 0, ',', '.') }}</li>
                                                <li>Konfirmasi dan masukkan PIN {{ $walletName }}</li>
                                                <li>Pembayaran selesai</li>
                                            </ol>
                                            <p class="mt-3 text-xs bg-yellow-100 border border-yellow-300 rounded p-2 text-yellow-800">
                                                <strong>Penting:</strong> Setelah pembayaran berhasil, status pesanan akan otomatis berubah menjadi "Sudah Dibayar" dalam beberapa menit.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Refresh Status Button -->
                        <div class="mt-6 flex gap-3">
                            <a href="{{ route('account.payments') }}" class="flex-1 text-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                Kembali
                            </a>
                            <button onclick="window.location.reload()" class="flex-1 px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                Cek Status Pembayaran
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 sticky top-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                        
                        <!-- Products -->
                        <div class="space-y-3 mb-4 max-h-96 overflow-y-auto">
                            @foreach($order->items as $item)
                                <div class="flex gap-3">
                                    <div class="w-16 h-16 bg-gray-100 rounded flex-shrink-0 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-gray-400">computer</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $item->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Summary -->
                        <div class="border-t pt-4 space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkir</span>
                                <span>Rp {{ number_format($summary['shipping'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Asuransi</span>
                                <span>Rp {{ number_format($summary['insurance'], 0, ',', '.') }}</span>
                            </div>
                            @if($summary['discount'] > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Diskon</span>
                                    <span>-Rp {{ number_format($summary['discount'], 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t">
                                <span>Total</span>
                                <span class="text-primary">Rp {{ number_format($summary['total'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mt-4 pt-4 border-t">
                            <p class="text-xs text-gray-500 mb-1">Metode Pembayaran</p>
                            <p class="text-sm font-semibold text-gray-900">
                                @if($checkoutData['payment_method'] === 'cod')
                                    Cash on Delivery (COD)
                                @elseif($checkoutData['payment_method'] === 'bank_mandiri')
                                    Transfer Bank Mandiri
                                @elseif($checkoutData['payment_method'] === 'bank_bca')
                                    Transfer Bank BCA
                                @elseif($checkoutData['payment_method'] === 'bank_bri')
                                    Transfer Bank BRI
                                @elseif($checkoutData['payment_method'] === 'dana')
                                    DANA E-Wallet
                                @elseif($checkoutData['payment_method'] === 'gopay')
                                    GoPay E-Wallet
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
