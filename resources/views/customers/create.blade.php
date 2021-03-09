@extends('layouts.main')

@section('title', 'Tambah Customer')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Customer</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">Tambah Customer</div>
    <div class="card-body">
        <form id="form-customer" method="POST" action="{{ route('customer.store') }}">
            @csrf
            <div class="form-group">
                <label for="customer_name">Nama Customer</label>
                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name" value="{{ old('customer_name') }}" placeholder="Masukkan nama customer">
                @error('customer_name')
                    <label for="customer_name" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Masukkan alamat">{{ old('address') }}</textarea>
                @error('address')
                    <label for="address" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="city">Kota</label>
                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" placeholder="Masukkan kota">
                @error('city')
                    <label for="city" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukkan email">
                @error('email')
                    <label for="email" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="hp">HP</label>
                <input type="text" min="0" class="form-control @error('hp') is-invalid @enderror" name="hp" value="{{ old('hp') }}" placeholder="Masukkan hno hp">
                @error('hp')
                    <label for="hp" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-danger" onclick="location.href = '{{ route('customer.index') }}'">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection