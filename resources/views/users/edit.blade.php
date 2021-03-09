@extends('layouts.main')

@section('title', 'Edit User')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">User</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">Edit User</div>
    <div class="card-body">
        <form id="form-user" method="POST" action="{{ route('user.update', [$user->id]) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name }}" placeholder="Masukkan nama lengkap">
                @error('name')
                    <label for="name" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ??$user->email }}" placeholder="Masukkan email">
                @error('email')
                    <label for="email" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="hp">HP</label>
                <input type="text" class="form-control @error('hp') is-invalid @enderror" name="hp" value="{{ old('hp') ??$user->hp }}" placeholder="Masukkan no hp">
                @error('hp')
                    <label for="hp" class="invalid-feedback">{{ $message }}</label>
                @enderror
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select name="level" class="select2 form-control">
                    <option value="user" {{ ($user->level == 'user') ? 'selected' : ''}}>User</option>
                    <option value="admin" {{ ($user->level == 'admin') ? 'selected' : ''}}>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-danger" onclick="location.href = '{{ route('user.index') }}'">Batal</button>
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
        theme: 'bootstrap4',
        minimumResultsForSearch: -1
    });
</script>
@endpush