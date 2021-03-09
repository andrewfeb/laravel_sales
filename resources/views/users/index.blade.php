@extends('layouts.main')

@section('title', 'Users')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">Daftar User</div>
    <div class="card-body">
        <div class="mb-3">
            <a href="{{ route('user.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus-circle"></i> Tambah
            </a>
        </div>
        <table id="table-users" class="table table-stripped">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>HP</th>
                    <th>Level</th>
                    <th width="150px">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('script')
<script>
    var table = $('#table-users').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('user.index') }}',
        order: [[1,'asc']],
        columns: [
            {data: 'DT_RowIndex', searchable: false, orderable:false},
            {data: 'name'},
            {data: 'email'},
            {data: 'hp'},
            {data: 'level'},
            {data: 'action', searchable: false, orderable:false},
        ],
        drawCallback: function(){
            confirmDelete();
        }
    });
</script>    
@endpush