@extends('admin.layout')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk: ' . $product->name)

@section('content')
<div class="max-w-4xl">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        @include('admin.products.form', ['product' => $product])
        
        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-100">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update Produk
            </button>
        </div>
    </form>
</div>
@endsection
