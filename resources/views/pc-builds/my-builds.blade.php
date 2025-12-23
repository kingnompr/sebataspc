@extends('account.layout')

@section('title', 'Rakitan Tersimpan')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Rakitan Tersimpan</h1>
    <p class="mt-2 text-gray-600 dark:text-gray-400">
        Build PC yang telah Anda simpan dari Smart PC Builder
    </p>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 rounded-lg">
        {{ session('success') }}
    </div>
@endif

        @if($builds->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full mb-6">
                    <span class="material-symbols-outlined text-5xl text-gray-400">computer</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    Belum Ada Rakitan Tersimpan
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Mulai buat PC impian Anda dengan Smart PC Builder
                </p>
                <a href="{{ route('pc-builds.builder') }}" 
                   class="inline-flex items-center px-6 py-3 bg-primary hover:bg-blue-600 text-white font-semibold rounded-lg transition">
                    <span class="material-symbols-outlined mr-2">add_circle</span>
                    Mulai Rakit PC
                </a>
            </div>
        @else
            <!-- Builds Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($builds as $build)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition">
                        <!-- Build Header -->
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1">
                                        {{ $build->build_name }}
                                    </h3>
                                    <div class="flex items-center gap-2 text-sm">
                                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded text-xs font-medium">
                                            {{ ucfirst($build->use_case) }}
                                        </span>
                                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded text-xs font-medium">
                                            {{ str_replace('_', ' ', ucfirst($build->tier)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                                <span>Budget: Rp {{ number_format($build->budget, 0, ',', '.') }}</span>
                                <span>{{ $build->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Components Summary -->
                        <div class="p-6">
                            <div class="space-y-2 mb-4">
                                @php
                                    $componentLabels = [
                                        'processor' => 'CPU',
                                        'gpu' => 'GPU',
                                        'motherboard' => 'Motherboard',
                                        'ram' => 'RAM',
                                        'storage' => 'Storage',
                                        'psu' => 'PSU',
                                        'casing' => 'Casing',
                                        'cpu_cooler' => 'Cooler',
                                    ];
                                    $componentCount = 0;
                                    foreach($build->components as $key => $value) {
                                        if($value) $componentCount++;
                                    }
                                @endphp
                                
                                <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                    <span class="material-symbols-outlined text-base mr-2 text-gray-400">inventory_2</span>
                                    <span>{{ $componentCount }} komponen</span>
                                </div>
                                
                                <div class="flex items-center text-sm font-semibold text-gray-900 dark:text-white">
                                    <span class="material-symbols-outlined text-base mr-2 text-primary">payments</span>
                                    <span>Rp {{ number_format($build->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('pc-builds.builder') }}?load={{ $build->id }}" 
                                   class="flex-1 px-4 py-2 bg-primary hover:bg-blue-600 text-white text-sm font-semibold rounded-lg text-center transition">
                                    <span class="material-symbols-outlined text-sm align-middle mr-1">edit</span>
                                    Edit
                                </a>
                                
                                <form action="{{ route('account.my-builds.delete', $build) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus rakitan ini?')"
                                      class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full px-4 py-2 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 text-sm font-semibold rounded-lg transition">
                                        <span class="material-symbols-outlined text-sm align-middle mr-1">delete</span>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
        <div class="mt-8">
            {{ $builds->links() }}
        </div>
    @endif
@endsection
