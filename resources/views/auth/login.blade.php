@extends('layouts.auth')

@section('title', 'Masuk - Sebatas PC')

@section('content')
    <div class="flex border-b border-gray-200 mb-8">
        <span class="flex-1 pb-4 border-b-[3px] border-primary text-primary font-bold text-base transition-colors cursor-pointer">Masuk</span>
        <a href="{{ route('register') }}" class="flex-1 pb-4 border-b-[3px] border-transparent text-gray-500 hover:text-gray-700 font-bold text-base transition-colors">Daftar</a>
    </div>

    <div class="mb-8">
        <h1 class="text-gray-900 text-3xl font-bold mb-2">Selamat Datang Kembali</h1>
        <p class="text-gray-500">Masuk untuk mengakses rakitan PC impian Anda yang tersimpan.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-600">
            <ul class="list-disc space-y-1 pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
        @csrf
        <div class="flex flex-col gap-2">
            <label class="text-gray-900 text-sm font-medium">Email atau Nama Pengguna</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full h-12 px-4 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder:text-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" placeholder="user@example.com"/>
        </div>

        <div class="flex flex-col gap-2">
            <div class="flex justify-between items-center">
                <label class="text-gray-900 text-sm font-medium">Kata Sandi</label>
                <a class="text-primary hover:text-blue-600 text-sm font-medium transition-colors" href="#">Lupa kata sandi?</a>
            </div>
            <input id="password" name="password" type="password" required class="w-full h-12 px-4 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder:text-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" placeholder="Masukkan kata sandi"/>
        </div>

        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="remember" class="size-4 rounded border-gray-300 text-primary focus:ring-primary" />
            Ingat saya di perangkat ini
        </label>

        <button type="submit" class="w-full h-12 bg-primary hover:bg-blue-700 text-white font-bold rounded-lg mt-2 transition-colors flex items-center justify-center gap-2 group">
            <span>Masuk Sekarang</span>
            <span class="material-symbols-outlined text-[20px] transition-transform group-hover:translate-x-1">arrow_forward</span>
        </button>

        <div class="relative flex py-2 items-center">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink mx-4 text-gray-400 text-sm">Atau masuk dengan</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <button type="button" class="flex items-center justify-center h-12 border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors gap-3">
                <img alt="Google Logo" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCcd9RdPRWnQx9AwMxE1Zum0r9xtW-na2fOsq-MGIUWvaPgjpHJkmJq57cp7sAHVtNfDdrTcEjKHLCYtbHZ9qcygGshGnbYrHUDoDyzENQ7LRxwU9FVxE6L_xlKA0RAKHiAM9oXUft7MXY1Fr98jQI9iAt3YgHKbUmTResQ2pk0J02FMVTb2Nvrq7_3A-n0GVcE615_ilaPaOwJTBnmr6Rt1Y3sNMxoDVnhqxOnHFK3jLoNkIu8xGWXHhd3TyV4Ms5fpeCiIvEjcFTo"/>
                <span class="text-gray-700 font-medium text-sm">Google</span>
            </button>
            <button type="button" class="flex items-center justify-center h-12 border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors gap-3">
                <img alt="Facebook Logo" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDbd0WQ4vy72JnYtfGAKTZZARseTLMXejWQHHg9ZPBvHEZaIY6JwzlMdka6ey0TxWM5wwmnwAyBlSxRUXWosu32d4A2NV8_PSb3VcDaBT6hSA0JlqnSrWN_KIbSPletTRjESGOVEbD-CbyreTqniT9ttFYgNna4Vf5v0G7BL4tyl1BNNbwX34q3Ug6Q25Rz-dZ5GipQjgoPvTaZCZbEs0JkLpo9EO3kPmSuxlnVR5tsBOWfhGHU9xRXrr_4gBBl-Bwcq1Jst7B0LgZ4"/>
                <span class="text-gray-700 font-medium text-sm">Facebook</span>
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="text-gray-500 text-sm">
                Belum punya akun? 
                <a class="text-primary font-bold hover:underline" href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </div>
    </form>
@endsection
