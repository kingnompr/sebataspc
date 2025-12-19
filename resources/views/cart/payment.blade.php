<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Sebatas PC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#135bec',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">S</span>
                    </div>
                    <span class="font-bold text-xl">Sebatas PC</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Pembayaran</h1>
            <p class="text-gray-600 mt-1">Nomor Pesanan: {{ $orderNumber }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Details Section -->
            <div class="lg:col-span-2">
                <!-- Shipping Information -->
                <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengiriman</h2>
                    <div class="space-y-2 text-sm">
                        <p class="text-gray-700">
                            <span class="font-medium">Nama:</span> 
                            {{ $checkoutData['first_name'] }} {{ $checkoutData['last_name'] }}
                        </p>
                        <p class="text-gray-700">
                            <span class="font-medium">Alamat:</span> 
                            {{ $checkoutData['address'] }}
                        </p>
                        <p class="text-gray-700">
                            <span class="font-medium">Kota:</span> 
                            {{ $checkoutData['city'] }}
                        </p>
                        <p class="text-gray-700">
                            <span class="font-medium">Kode Pos:</span> 
                            {{ $checkoutData['postal_code'] }}
                        </p>
                        <p class="text-gray-700">
                            <span class="font-medium">Telepon:</span> 
                            {{ $checkoutData['phone'] }}
                        </p>
                    </div>
                </div>

                <!-- Payment Method Details -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
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
                                        <p class="mt-3 text-xs text-gray-500">
                                            * Pembayaran akan otomatis terverifikasi dalam 5-10 menit setelah transfer berhasil
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
                                    <p class="text-sm text-gray-600 mb-4">Masukkan nomor {{ $walletName }} Anda untuk melanjutkan pembayaran</p>
                                    
                                    <form action="{{ route('checkout.confirmation') }}" method="GET" class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Nomor Telepon {{ $walletName }}
                                            </label>
                                            <input 
                                                type="tel" 
                                                name="wallet_number" 
                                                pattern="[0-9]*" 
                                                inputmode="numeric"
                                                maxlength="15"
                                                placeholder="08xxxxxxxxxx" 
                                                required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                            >
                                            <p class="mt-1 text-xs text-gray-500">Masukkan nomor telepon yang terdaftar di {{ $walletName }}</p>
                                        </div>

                                        <div class="bg-white border border-purple-300 rounded-lg p-4">
                                            <p class="text-sm text-gray-600 mb-1">Total Pembayaran:</p>
                                            <p class="text-2xl font-bold text-primary">Rp {{ number_format($summary['total'], 0, ',', '.') }}</p>
                                        </div>

                                        <div class="text-sm text-gray-600">
                                            <p class="font-medium mb-2">Langkah selanjutnya:</p>
                                            <ol class="list-decimal list-inside space-y-1">
                                                <li>Masukkan nomor {{ $walletName }} Anda di atas</li>
                                                <li>Klik tombol "Lanjutkan ke {{ $walletName }}"</li>
                                                <li>Buka aplikasi {{ $walletName }} untuk konfirmasi pembayaran</li>
                                                <li>Masukkan PIN {{ $walletName }} Anda</li>
                                                <li>Pembayaran selesai</li>
                                            </ol>
                                        </div>

                                        <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition font-medium">
                                            Lanjutkan ke {{ $walletName }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons for COD and Bank Transfer -->
                @if($checkoutData['payment_method'] === 'cod' || in_array($checkoutData['payment_method'], ['bank_mandiri', 'bank_bca', 'bank_bri']))
                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('checkout.show') }}" class="flex-1 text-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Kembali
                        </a>
                        <a href="{{ route('checkout.confirmation') }}" class="flex-1 text-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Konfirmasi Pesanan
                        </a>
                    </div>
                @else
                    <div class="mt-6">
                        <a href="{{ route('checkout.show') }}" class="block text-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Kembali ke Checkout
                        </a>
                    </div>
                @endif
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border p-6 sticky top-4">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                    
                    <!-- Products -->
                    <div class="space-y-3 mb-4">
                        @foreach($cart->items as $item)
                            <div class="flex gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded flex-shrink-0 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $item->product->name ?? 'Produk tidak ditemukan' }}
                                    </p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity ?? 0 }}</p>
                                    <p class="text-sm font-medium text-gray-900 mt-1">
                                        Rp {{ number_format(($item->product->price ?? 0) * ($item->quantity ?? 0), 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Pengiriman</span>
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
                    </div>

                    <div class="border-t mt-4 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900">Total</span>
                            <span class="text-xl font-bold text-primary">
                                Rp {{ number_format($summary['total'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Shipping Method -->
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Metode Pengiriman</p>
                        <p class="text-sm text-gray-900 capitalize">
                            {{ str_replace('_', ' ', str_replace('-', ' ', $checkoutData['shipping_method'])) }}
                        </p>
                    </div>

                    <!-- Payment Method -->
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 uppercase font-medium mb-1">Metode Pembayaran</p>
                        <p class="text-sm text-gray-900">
                            @if($checkoutData['payment_method'] === 'cod')
                                Bayar di Tempat (COD)
                            @elseif($checkoutData['payment_method'] === 'bank_mandiri')
                                Transfer Bank Mandiri
                            @elseif($checkoutData['payment_method'] === 'bank_bca')
                                Transfer Bank BCA
                            @elseif($checkoutData['payment_method'] === 'bank_bri')
                                Transfer Bank BRI
                            @elseif($checkoutData['payment_method'] === 'dana')
                                E-Wallet DANA
                            @elseif($checkoutData['payment_method'] === 'gopay')
                                E-Wallet GoPay
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyVA() {
            const vaNumber = "{{ $virtualAccount }}";
            navigator.clipboard.writeText(vaNumber).then(() => {
                alert('Nomor Virtual Account berhasil disalin!');
            });
        }
    </script>
</body>
</html>
