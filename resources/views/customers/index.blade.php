@extends('layouts.main')

@section('title', 'Customer')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Customer</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">Daftar Customer</div>
    <div class="card-body">
        <div class="mb-3">
            <a href="{{ route('customer.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus-circle"></i> Tambah
            </a>
        </div>
        <table id="table-customers" class="table table-stripped">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th>Nama Customer</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th>Email</th>
                    <th>HP</th>
                    <th width="150px">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('script')
<script>
    var table = $('#table-customers').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('customer.index') }}',
        order: [[1,'asc']],
        columns: [
            {data: 'DT_RowIndex', searchable: false, orderable:false},
            {data: 'customer_name'},
            {data: 'address'},
            {data: 'city'},
            {data: 'email'},
            {data: 'hp'},
            {data: 'action', searchable: false, orderable:false},
        ],
        drawCallback: function(){
            confirmDelete();
        }
    });
</script>    
@endpush