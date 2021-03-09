@extends('layouts.main')

@section('title', 'Tambah Kategori')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Kategori Produk</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">Tambah Kategori</div>
    <div class="card-body">
        <form id="form-category" method="POST" action="{{ route('category.store') }}">
            @csrf
            <div class="form-group">
                <label for="category_name">Nama Kategori</label>
                <input type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name') }}" placeholder="Masukkan nama kategori">
                @error('category_name')
                    <label for="category_name" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-danger" onclick="location.href = '{{ route('category.index') }}'">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection