<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akun Saya • SEBATAS PC</title>
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
    @php
        $formatCurrency = static fn ($value) => 'Rp '.number_format($value ?? 0, 0, ',', '.');
        $membershipSince = $user->created_at
            ? $user->created_at->translatedFormat('d F Y')
            : now()->subYears(1)->translatedFormat('d F Y');

        $progressSteps = [
            ['label' => 'Pesanan Diterima', 'description' => 'Invoice dibuat & dibayar'],
            ['label' => 'Sedang Dirakit', 'description' => 'Tim teknis memasang produk'],
            ['label' => 'Quality Check', 'description' => 'Stress test & optimasi OS'],
            ['label' => 'Dikirim', 'description' => 'Terhubung kurir premium'],
        ];

        $activeOrderProgress = optional($activeOrder)->progress_stage ?? 0;
        $statusStyles = [
            'pending' => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-amber-100 text-amber-600'],
            'paid' => ['label' => 'Pembayaran Terverifikasi', 'class' => 'bg-blue-100 text-blue-600'],
            'processing' => ['label' => 'Sedang Dirakit', 'class' => 'bg-indigo-100 text-indigo-600'],
            'qc' => ['label' => 'Quality Check', 'class' => 'bg-purple-100 text-purple-600'],
            'shipped' => ['label' => 'Dalam Pengiriman', 'class' => 'bg-amber-100 text-amber-600'],
            'delivered' => ['label' => 'Selesai', 'class' => 'bg-emerald-100 text-emerald-600'],
            'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-rose-100 text-rose-600'],
        ];
    @endphp

    <div class="min-h-screen">
        <header class="border-b border-white/40 bg-white/80 backdrop-blur">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-5">
                <div>
                    <p class="text-xs font-semibold tracking-[0.35em] text-slate-400">SEBATAS PC</p>
                        <h1 class="text-2xl font-semibold text-midnight">Halo, {{ $user->name }}</h1>
                        <p class="text-sm text-slate-500">Kelola pesanan, rakitan favorit, dan preferensi akun Anda.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-midnight/30">← Kembali ke Beranda</a>
                        <button class="rounded-2xl bg-midnight px-4 py-2 text-sm font-semibold text-white shadow-glow">Update Profil</button>
                    </div>
                </div>
            </header>

            <main class="mx-auto w-full max-w-6xl px-4 py-10">
                <div class="grid gap-6 lg:grid-cols-4">
                    <div class="rounded-3xl bg-midnight p-6 text-white shadow-glow lg:col-span-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-white/60">Tier Saat Ini</p>
                                <p class="mt-2 text-2xl font-semibold">{{ $tierLabel }}</p>
                                <p class="text-sm text-white/60">Member sejak {{ $membershipSince }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-4 text-right">
                                <p class="text-xs text-white/70">Sebatas Points</p>
                                <p class="text-3xl font-semibold">{{ number_format($loyalty['points']) }}</p>
                                <p class="text-xs text-white/60">{{ $loyalty['nextTierPoints'] }} poin ke {{ $loyalty['nextTier'] }}</p>
                            </div>
                        </div>
                        <div class="mt-6 h-2 rounded-full bg-white/10">
                            @php
                                $progressPercent = $loyalty['points'] >= 20000
                                    ? 100
                                    : max(12, ($loyalty['points'] % 20000) / 20000 * 100);
                            @endphp
                            <div class="h-full rounded-full bg-gradient-to-r from-primary via-blue-500 to-accent" style="width: {{ $progressPercent }}%"></div>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-6 text-sm text-white/80">
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-white/40">Pengeluaran Tahun Ini</p>
                                <p class="text-lg font-semibold">{{ $formatCurrency($loyalty['spendThisYear']) }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-white/40">Voucher Aktif</p>
                                <p class="text-lg font-semibold">3 Kupon</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-white/40">Status Keanggotaan</p>
                                <p class="text-lg font-semibold">Prioritas Support</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-6">
                        <div class="flex items-center gap-3">
                            <div class="flex size-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                                <span class="material-symbols-outlined">bolt</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-midnight">Smart Builder</p>
                                <p class="text-xs text-slate-500">Mulai rakit PC baru sesuai gaya bermain Anda.</p>
                            </div>
                        </div>
                        <a href="{{ route('pc-builds.builder') }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-primary/10 px-4 py-2 text-sm font-semibold text-primary hover:bg-primary/20">
                            Lanjutkan Konfigurasi
                            <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </a>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-amber-50 via-white to-white p-6">
                        <div class="flex items-center gap-3">
                            <div class="flex size-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-500">
                                <span class="material-symbols-outlined">assistant_photo</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-midnight">Dukungan VIP</p>
                                <p class="text-xs text-slate-500">Prioritas langsung WhatsApp & workshop.</p>
                            </div>
                        </div>
                        <button class="mt-4 w-full rounded-2xl border border-amber-200 px-4 py-2 text-sm font-semibold text-amber-600 hover:bg-amber-50">Hubungi Tim</button>
                    </div>
                </div>

                <div class="mt-10 grid gap-6 lg:grid-cols-[minmax(0,1.5fr),minmax(0,0.8fr)]">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Pesanan Aktif</p>
                                @if($activeOrder)
                                    <h2 class="text-2xl font-semibold text-midnight">{{ $activeOrder->order_number }}</h2>
                                    <p class="text-sm text-slate-500">
                                        {{ $statusStyles[$activeOrder->status]['label'] ?? ucfirst($activeOrder->status) }}
                                        @if($activeOrder->estimated_delivery_at)
                                            • Estimasi tiba {{ $activeOrder->estimated_delivery_at->translatedFormat('d M Y') }}
                                        @endif
                                    </p>
                                @else
                                    <h2 class="text-2xl font-semibold text-midnight">Belum ada pesanan aktif</h2>
                                    <p class="text-sm text-slate-500">Checkout rakitan terbaru Anda untuk mulai produksi.</p>
                                @endif
                            </div>
                            @if($activeOrder)
                                <a href="{{ route('account.orders.invoice', $activeOrder) }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-midnight/30">
                                    Lihat Invoice
                                    <span class="material-symbols-outlined text-base">picture_as_pdf</span>
                                </a>
                            @else
                                <span class="inline-flex items-center gap-2 rounded-2xl border border-slate-100 px-4 py-2 text-sm font-semibold text-slate-400">
                                    Lihat Invoice
                                    <span class="material-symbols-outlined text-base">picture_as_pdf</span>
                                </span>
                            @endif
                        </div>
                        <div class="mt-6 space-y-6">
                            @if($activeOrder)
                                @foreach($progressSteps as $index => $step)
                                    @php $active = $index + 1 <= $activeOrderProgress; @endphp
                                    <div class="flex items-start gap-4">
                                        <div class="relative flex flex-col items-center">
                                            <div class="flex size-9 items-center justify-center rounded-2xl border-2 text-sm font-semibold {{ $active ? 'border-midnight bg-midnight text-white' : 'border-slate-200 text-slate-400' }}">
                                                {{ $index + 1 }}
                                            </div>
                                            @if($index < count($progressSteps) - 1)
                                                <span class="mt-1 h-10 w-[2px] {{ $active ? 'bg-midnight/80' : 'bg-slate-200' }}"></span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-midnight">{{ $step['label'] }}</p>
                                            <p class="text-xs text-slate-500">{{ $step['description'] }}</p>
                                            @if($index + 1 === $activeOrderProgress && $activeOrder->estimated_delivery_at)
                                                <span class="mt-2 inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">
                                                    <span class="material-symbols-outlined text-sm">schedule</span>
                                                    Estimasi selesai {{ $activeOrder->estimated_delivery_at->translatedFormat('d M, H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="rounded-2xl border border-dashed border-slate-200 p-6 text-sm text-slate-500">
                                    Pesanan baru akan muncul di sini setelah Anda menyelesaikan checkout.
                                </div>
                            @endif
                        </div>
                    </section>

                    <aside class="space-y-6">
                        <div class="rounded-3xl border border-slate-200 bg-white p-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img src="{{ $avatarUrl }}" alt="{{ $user->name }}" class="size-16 rounded-2xl object-cover">
                                    <span class="absolute -bottom-1 -right-1 inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-semibold text-emerald-600">
                                        <span class="material-symbols-outlined text-xs">verified</span>
                                        Aktif
                                    </span>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-midnight">{{ $user->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                                    <p class="text-xs text-slate-400">Terakhir login {{ now()->format('H:i') }} WIB</p>
                                </div>
                            </div>
                            <div class="mt-4 grid gap-3 text-sm text-slate-600">
                                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                    <span>Autentikasi 2FA</span>
                                    <span class="material-symbols-outlined text-base text-emerald-500">lock</span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                    <span>Metode Pembayaran</span>
                                    <a href="{{ route('account.payments') }}" class="text-xs font-semibold text-primary">Kelola</a>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                    <span>Preferensi Notifikasi</span>
                                    <span class="text-xs text-slate-400">Email + WhatsApp</span>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-primary/10 via-white to-white p-6">
                            <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Alamat Utama</p>
                            @if($defaultAddress)
                                <h3 class="mt-1 text-base font-semibold text-midnight">{{ $defaultAddress->label }}</h3>
                                <p class="mt-2 text-sm text-slate-500">
                                    {{ $defaultAddress->recipient }}<br>
                                    {{ $defaultAddress->line_one }}<br>
                                    @if($defaultAddress->line_two)
                                        {{ $defaultAddress->line_two }}<br>
                                    @endif
                                    {{ $defaultAddress->city }}, {{ $defaultAddress->province }} {{ $defaultAddress->postal_code }}<br>
                                    {{ $defaultAddress->phone }}
                                </p>
                            @else
                                <p class="mt-2 text-sm text-slate-500">Belum ada alamat tersimpan. Tambahkan saat checkout berikutnya.</p>
                            @endif
                            <div class="mt-4 flex gap-2">
                                @if($defaultAddress)
                                    <a href="{{ route('account.addresses', ['highlight' => $defaultAddress->id]) }}" class="flex-1 rounded-2xl border border-slate-200 px-3 py-2 text-center text-sm font-semibold text-slate-600 hover:border-midnight/40">Edit</a>
                                @else
                                    <span class="flex-1 rounded-2xl border border-slate-200 px-3 py-2 text-center text-sm font-semibold text-slate-400">Edit</span>
                                @endif
                                <a href="{{ route('account.addresses') }}" class="flex-1 rounded-2xl bg-midnight px-3 py-2 text-center text-sm font-semibold text-white">Alamat Lain</a>
                            </div>
                        </div>
                    </aside>
                </div>

                <div class="mt-10 grid gap-6 lg:grid-cols-[minmax(0,1.5fr),minmax(0,0.8fr)]">
                    <section class="rounded-3xl border border-slate-200 bg-white p-6">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Riwayat Pesanan</p>
                                <h2 class="text-xl font-semibold text-midnight">Transaksi 12 Bulan Terakhir</h2>
                            </div>
                            <button class="rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">Unduh CSV</button>
                        </div>
                        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-100">
                            <table class="w-full text-sm">
                                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <tr>
                                        <th class="px-5 py-3">Order ID</th>
                                        <th class="px-5 py-3">Tanggal</th>
                                        <th class="px-5 py-3">Total</th>
                                        <th class="px-5 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-600">
                                    @forelse($orderHistory as $order)
                                        @php $statusMeta = $statusStyles[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'bg-slate-100 text-slate-600']; @endphp
                                        <tr class="hover:bg-slate-50/70">
                                            <td class="px-5 py-4 font-semibold text-midnight">{{ $order->order_number }}</td>
                                            <td class="px-5 py-4">{{ $order->created_at->translatedFormat('d M Y') }}</td>
                                            <td class="px-5 py-4 font-semibold">{{ $formatCurrency($order->total) }}</td>
                                            <td class="px-5 py-4">
                                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $statusMeta['class'] }}">
                                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                                    {{ $statusMeta['label'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-5 py-6 text-center text-sm text-slate-500">Belum ada transaksi yang tersimpan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div class="rounded-3xl border border-slate-200 bg-white p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Rakitan Tersimpan</p>
                                    <h2 class="text-lg font-semibold text-midnight">Lanjutkan progres Anda</h2>
                                </div>
                                <button class="text-xs font-semibold text-primary">Lihat Semua</button>
                            </div>
                            <div class="mt-4 space-y-4">
                                @forelse($savedBuilds as $saved)
                                    @php
                                        $build = $saved->pcBuild;
                                        $components = $build ? $build->components : collect();
                                        $componentSummary = $components->pluck('component_type')->implode(' • ');
                                        $buildPrice = $components->sum(function ($component) {
                                            return (optional($component->product)->price ?? 0) * $component->quantity;
                                        });
                                        $labelSource = $build->use_case ?? $build->name ?? 'PC';
                                        $initials = strtoupper(substr($labelSource, 0, 2));
                                    @endphp
                                    <div class="flex gap-3 rounded-2xl border border-slate-100 p-3">
                                        <div class="flex size-16 items-center justify-center rounded-2xl bg-slate-100 text-sm font-semibold text-slate-600">{{ $initials }}</div>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-midnight">{{ $saved->custom_name ?? $build->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $componentSummary ?: 'Produk siap ditentukan' }}</p>
                                            <div class="mt-2 flex items-center justify-between text-xs">
                                                <span class="font-semibold text-midnight">{{ $formatCurrency($buildPrice) }}</span>
                                                <span class="text-slate-400">{{ $saved->progress_percent }}% selesai</span>
                                            </div>
                                            <div class="mt-2 flex items-center justify-between text-xs">
                                                <a href="{{ route('pc-builds.builder') }}" class="text-primary">Lanjutkan →</a>
                                                <span class="text-slate-400">Diupdate {{ optional($saved->updated_at)->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-dashed border-slate-200 p-4 text-center text-sm text-slate-500">
                                        Simpan rakitan favorit Anda dari konfigurator untuk tampil di sini.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-gradient-to-r from-midnight via-slate-900 to-primary/40 p-6 text-white">
                            <p class="text-xs uppercase tracking-[0.35em] text-white/50">Butuh Bantuan Tambahan?</p>
                            <h3 class="mt-2 text-xl font-semibold">Temui Specialist SEBATAS</h3>
                            <p class="mt-2 text-sm text-white/70">Konsultasi langsung untuk upgrade, workspace, hingga kebutuhan enterprise.</p>
                            <div class="mt-4 flex flex-wrap gap-3 text-sm font-semibold">
                                <a href="tel:+6221123456" class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-2">
                                    <span class="material-symbols-outlined text-base">call</span>
                                    Telepon
                                </a>
                                <a href="https://wa.me/6281234567890" class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2 text-midnight">
                                    <span class="material-symbols-outlined text-base">chat</span>
                                    WhatsApp
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
            </main>

            <footer class="border-t border-slate-200 bg-white">
                <div class="mx-auto flex w-full max-w-6xl flex-col gap-3 px-4 py-8 text-xs text-slate-500 md:flex-row md:items-center md:justify-between">
                    <p>© {{ date('Y') }} SEBATAS PC. Crafted for builders.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#" class="hover:text-midnight">Kebijakan Privasi</a>
                        <a href="#" class="hover:text-midnight">Keamanan</a>
                        <a href="#" class="hover:text-midnight">Pusat Bantuan</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
    </html>
