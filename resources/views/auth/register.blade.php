@extends('layouts.auth')

@section('title', 'Daftar • SEBATAS PC')

@section('content')
    <div class="space-y-8">
        <div class="flex items-center gap-10 text-base font-bold">
            <a href="{{ route('login') }}" class="flex-1 pb-4 border-b-[3px] border-transparent text-gray-500 hover:text-blue-600">Masuk</a>
            <span class="flex-1 pb-4 border-b-[3px] border-blue-600 text-blue-600">Daftar</span>
        </div>
        <div class="space-y-2">
            <h1 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h1>
            <p class="text-sm text-gray-500">Simpan konfigurasi rakitan dan nikmati rekomendasi personal.</p>
        </div>

        @if ($errors->any())
            <div class="rounded-3xl border border-red-200 bg-red-50 p-4 text-xs text-red-600">
                <ul class="list-disc space-y-1 pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5 text-sm">
            @csrf
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-gray-900">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required placeholder="Nama Anda" class="h-12 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm font-medium text-gray-900 placeholder:text-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-gray-900">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="nama@domain.com" class="h-12 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm font-medium text-gray-900 placeholder:text-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-gray-900">Password</label>
                <input id="password" name="password" type="password" required placeholder="Minimal 8 karakter" class="h-12 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm font-medium text-gray-900 placeholder:text-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-gray-900">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Ulangi password" class="h-12 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm font-medium text-gray-900 placeholder:text-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600">
            </div>
            <div class="rounded-lg bg-slate-50 px-4 py-3 text-xs text-gray-500">
                Dengan mendaftar, Anda menyetujui <a href="#" class="font-semibold text-blue-600">Syarat & Ketentuan</a> serta <a href="#" class="font-semibold text-blue-600">Kebijakan Privasi</a> kami.
            </div>
            <button type="submit" class="group w-full h-12 rounded-lg bg-blue-600 text-sm font-bold text-white transition hover:bg-blue-700 inline-flex items-center justify-center gap-2">
                <span>Daftar Sekarang</span>
                <span class="material-symbols-outlined text-[20px] transition-transform group-hover:translate-x-1">arrow_forward</span>
            </button>
        </form>

        <p class="text-center text-sm text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline"> Masuk</a>
        </p>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
@endsection
