@extends('admin.layout')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        
        @include('admin.products.form', ['product' => null])
        
        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-100">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Simpan Produk
            </button>
        </div>
    </form>
</div>
@endsection
