@extends('layouts.main')

@section('title', 'Tambah Produk')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">Tambah Produk</div>
    <div class="card-body">
        <form id="form-product" method="POST" action="{{ route('product.store') }}">
            @csrf
            <div class="form-group">
                <label for="product_code">Kode Produk</label>
                <input type="text" class="form-control @error('product_code') is-invalid @enderror" name="product_code" value="{{ old('product_code') }}" placeholder="Masukkan kode produk">
                @error('product_code')
                    <label for="product_code" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="product_name">Nama Produk</label>
                <input type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{ old('product_name') }}" placeholder="Masukkan nama produk">
                @error('product_name')
                    <label for="product_name" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="category">Kategori</label>
                <select class="select2 form-control @error('category') is-invalid @enderror" name="category" data-allow-clear="true"
                    data-placeholder="Pilih kategori">
                    <option></option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    @endforeach
                </select>
                @error('category')
                    <label for="category" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock') }}" placeholder="Masukkan stock">
                @error('stock')
                    <label for="stock" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" min="0" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" placeholder="Masukkan harga produk">
                @error('price')
                    <label for="price" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-danger" onclick="location.href = '{{ route('product.index') }}'">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    $('.select2').select2({
        width: '100%',
        theme: 'bootstrap4'
    });
</script>
@endpush