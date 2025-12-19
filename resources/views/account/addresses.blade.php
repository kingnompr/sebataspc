<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alamat Pengiriman • SEBATAS PC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD@400,0,0&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <style>
        body { font-family: 'Space Grotesk', 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="mx-auto flex w-full max-w-5xl items-center justify-between px-4 py-5">
                <div>
                    <p class="text-xs font-semibold tracking-[0.35em] text-slate-400">SEBATAS PC</p>
                    <h1 class="text-2xl font-semibold">Alamat Pengiriman & Penagihan</h1>
                    <p class="text-sm text-slate-500">Kelola alamat favorit untuk mempercepat checkout.</p>
                </div>
                <a href="{{ route('account.overview') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">← Kembali ke Akun</a>
            </div>
        </header>

        <main class="mx-auto w-full max-w-5xl px-4 py-10">
            <div class="rounded-3xl border border-slate-200 bg-white p-6">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Alamat Tersimpan</p>
                        <h2 class="text-xl font-semibold text-slate-900">{{ $addresses->count() }} alamat aktif</h2>
                    </div>
                    <button onclick="document.getElementById('addAddressModal').classList.remove('hidden')" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        <span class="material-symbols-outlined text-base">add</span>
                        Tambah Alamat
                    </button>
                </div>

                <div class="mt-6 grid gap-4">
                    @forelse($addresses as $address)
                        @php
                            $isDefault = (bool) $address->is_default;
                            $highlight = request('highlight') == $address->id;
                        @endphp
                        <div class="rounded-2xl border {{ $isDefault ? 'border-blue-300 bg-blue-50/40' : 'border-slate-100 bg-white' }} p-5 shadow-sm">
                            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">{{ $address->label }}</p>
                                    <p class="text-xs text-slate-500">{{ $address->recipient }} • {{ $address->phone }}</p>
                                </div>
                                <div class="flex flex-wrap gap-2 text-xs font-semibold">
                                    @if($isDefault)
                                        <span class="rounded-full bg-white/80 px-3 py-1 text-blue-600">Alamat Utama</span>
                                    @endif
                                    @if($highlight)
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-emerald-600">Dipilih</span>
                                    @endif
                                    <button class="rounded-2xl border border-slate-200 px-3 py-1 text-slate-600">Edit</button>
                                    <button class="rounded-2xl border border-slate-200 px-3 py-1 text-slate-600">Jadikan Utama</button>
                                </div>
                            </div>
                            <p class="mt-4 text-sm text-slate-600">
                                {{ $address->line_one }} @if($address->line_two)<br>{{ $address->line_two }}@endif<br>
                                {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                            </p>
                        </div>
                    @empty
                        <p class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">Belum ada alamat tersimpan.</p>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <!-- Add Address Modal -->
    <div id="addAddressModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-slate-900">Tambah Alamat Baru</h2>
                <button onclick="document.getElementById('addAddressModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form method="POST" action="{{ route('account.addresses.store') }}" class="p-6 space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Label -->
                    <div class="md:col-span-2">
                        <label for="label" class="block text-sm font-medium text-slate-700 mb-2">Label Alamat</label>
                        <input 
                            type="text" 
                            name="label" 
                            id="label" 
                            placeholder="Rumah, Kantor, Kos, dll"
                            required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Recipient Name -->
                    <div>
                        <label for="recipient" class="block text-sm font-medium text-slate-700 mb-2">Nama Penerima</label>
                        <input 
                            type="text" 
                            name="recipient" 
                            id="recipient" 
                            required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon</label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            pattern="[0-9]*"
                            inputmode="numeric"
                            maxlength="15"
                            required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Address Line 1 -->
                    <div class="md:col-span-2">
                        <label for="line_one" class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap</label>
                        <input 
                            type="text" 
                            name="line_one" 
                            id="line_one" 
                            placeholder="Jalan, RT/RW, Kelurahan"
                            required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Address Line 2 -->
                    <div class="md:col-span-2">
                        <label for="line_two" class="block text-sm font-medium text-slate-700 mb-2">Detail Alamat (Opsional)</label>
                        <input 
                            type="text" 
                            name="line_two" 
                            id="line_two" 
                            placeholder="Blok, Nomor Rumah, Patokan"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-slate-700 mb-2">Kota/Kabupaten</label>
                        <input 
                            type="text" 
                            name="city" 
                            id="city" 
                            required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Province -->
                    <div>
                        <label for="province" class="block text-sm font-medium text-slate-700 mb-2">Provinsi</label>
                        <input 
                            type="text" 
                            name="province" 
                            id="province" 
                            required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-slate-700 mb-2">Kode Pos</label>
                        <input 
                            type="text" 
                            name="postal_code" 
                            id="postal_code" 
                            pattern="[0-9]*"
                            inputmode="numeric"
                            maxlength="5"
                            required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Is Default -->
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_default" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700">Jadikan sebagai alamat utama</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
                    <button type="submit" class="px-6 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 font-medium">
                        Simpan Alamat
                    </button>
                    <button type="button" onclick="document.getElementById('addAddressModal').classList.add('hidden')" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 font-medium">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
