@extends('account.layout')

@section('title', 'Ringkasan Akun')

@section('content')
    @php
        $formatCurrency = static fn ($value) => 'Rp '.number_format($value ?? 0, 0, ',', '.');
        $totalOrders = $orderHistory->count();
        $totalBuilds = $savedBuilds->count();
        $points = (int) round(($user->orders()->sum('total') ?? 0) / 1000);
        $vouchers = 2;
        
        $statusStyles = [
            'pending' => ['label' => 'Draft', 'class' => 'bg-yellow-50 text-yellow-700 border-yellow-200'],
            'paid' => ['label' => 'Dibayar', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
            'processing' => ['label' => 'Diproses', 'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
            'shipped' => ['label' => 'Dalam Pengiriman', 'class' => 'bg-purple-50 text-purple-700 border-purple-200'],
            'delivered' => ['label' => 'Selesai', 'class' => 'bg-green-50 text-green-700 border-green-200'],
            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-red-50 text-red-700 border-red-200'],
        ];
    @endphp

    <!-- Profile Card -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-4">
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="size-16 rounded-full object-cover">
                @else
                    <div class="size-16 rounded-full bg-blue-100 flex items-center justify-center text-2xl font-bold text-primary">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                            <span class="material-symbols-outlined text-sm">verified</span>
                            Member Platinum
                        </span>
                        <span class="ml-2">Bergabung sejak {{ $user->created_at->format('d M Y') }}</span>
                    </p>
                </div>
            </div>
            <a href="{{ route('account.edit') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                <span class="material-symbols-outlined text-lg">edit</span>
                Edit Profil
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-4 gap-4 mt-6 pt-6 border-t border-gray-200">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</div>
                <div class="text-sm text-gray-600">Total Pesanan</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">{{ $totalBuilds }}</div>
                <div class="text-sm text-gray-600">Rakitan</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">{{ number_format($points) }}</div>
                <div class="text-sm text-gray-600">Poin Loyalty</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">{{ $vouchers }}</div>
                <div class="text-sm text-gray-600">Voucher</div>
            </div>
        </div>
    </div>

    <!-- Active Order Tracking -->
    @if($activeOrder)
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">local_shipping</span>
                <h3 class="text-lg font-semibold text-gray-900">Lacak Pesanan Aktif</h3>
            </div>
            <a href="#" class="text-sm font-medium text-primary hover:underline">Lihat Detail</a>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4 mb-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-600">Pesanan: <span class="font-semibold text-gray-900">{{ $activeOrder->order_number }}</span></p>
                    <p class="text-sm text-gray-600">Dipesan pada {{ $activeOrder->created_at->format('d M Y') }} | Estimasi tiba {{ $activeOrder->created_at->addDays(7)->format('d M Y') }}</p>
                </div>
                <a href="#" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                    Bedang Diperkirakan
                </a>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="flex items-center justify-between relative">
            <div class="absolute top-5 left-0 right-0 h-0.5 bg-gray-200 z-0"></div>
            <div class="absolute top-5 left-0 h-0.5 bg-primary z-0" style="width: 50%"></div>
            
            @foreach(['Dikonfirmasi', 'Diproses', 'Dirakit', 'Dikirim', 'Selesai'] as $index => $step)
            <div class="flex flex-col items-center relative z-10">
                <div class="size-10 rounded-full {{ $index < 2 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center mb-2">
                    @if($index < 2)
                        <span class="material-symbols-outlined text-lg">check</span>
                    @else
                        <span class="material-symbols-outlined text-lg">{{ $index === 2 ? 'build' : ($index === 3 ? 'local_shipping' : 'check_circle') }}</span>
                    @endif
                </div>
                <p class="text-xs text-gray-600 text-center">{{ $step }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order History -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Pesanan</h3>
                <a href="{{ route('account.payments') }}" class="text-sm font-medium text-primary hover:underline">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase">
                        <tr>
                            <th class="px-4 py-3">ID Pesanan</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orderHistory->take(3) as $order)
                        @php $statusMeta = $statusStyles[$order->status] ?? ['label' => 'Draft', 'class' => 'bg-gray-50 text-gray-700 border-gray-200']; @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">#{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $formatCurrency($order->total) }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusMeta['class'] }}">
                                    {{ $statusMeta['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button class="text-gray-400 hover:text-gray-600">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada pesanan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Address Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Alamat Utama</h3>
                    <button class="text-gray-400 hover:text-gray-600">
                        <span class="material-symbols-outlined">edit</span>
                    </button>
                </div>
                @if($defaultAddress)
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-gray-400">home</span>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900">{{ $defaultAddress->label ?? 'Rumah' }}</p>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $defaultAddress->line_one }}<br>
                            {{ $defaultAddress->city }}, {{ $defaultAddress->province }}<br>
                            {{ $defaultAddress->postal_code }}
                        </p>
                        <p class="text-sm text-gray-500 mt-2">{{ $defaultAddress->phone }}</p>
                    </div>
                </div>
                <button class="mt-4 w-full px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                    + Tambah Alamat Baru
                </button>
                @else
                <p class="text-sm text-gray-500 text-center py-4">Belum ada alamat tersimpan</p>
                <button class="w-full px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                    Tambah Alamat
                </button>
                @endif
            </div>

            <!-- Saved Builds -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Rakitan Tersimpan Terbaru</h3>
                    <a href="#" class="text-sm font-medium text-primary hover:underline">Kelola Rakitan</a>
                </div>
                
                @forelse($savedBuilds->take(2) as $saved)
                @php
                    $build = $saved->pcBuild;
                    $components = $build ? $build->components : collect();
                    $buildPrice = $components->sum(fn($c) => (optional($c->product)->price ?? 0) * $c->quantity);
                @endphp
                <div class="flex gap-3 mb-4 p-3 border border-gray-200 rounded-lg hover:border-primary transition-colors">
                    <div class="size-16 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <img src="https://via.placeholder.com/64" alt="Build" class="w-12 h-12 object-contain">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-900 truncate">{{ $saved->custom_name ?? $build->name ?? 'PC Build' }}</h4>
                        <p class="text-xs text-gray-500">{{ $components->count() }} produk</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $formatCurrency($buildPrice) }}</p>
                    </div>
                    <div class="flex flex-col items-end justify-between">
                        <a href="#" class="text-primary hover:text-blue-700">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </a>
                        <a href="#" class="px-3 py-1 bg-primary text-white text-xs font-medium rounded hover:bg-blue-700">
                            Beli Sekarang
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada rakitan tersimpan</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
