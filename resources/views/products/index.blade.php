@extends('layouts.main')

@section('title', 'Produk')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">Daftar Produk</div>
    <div class="card-body">
        <div class="mb-3">
            <a href="{{ route('product.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus-circle"></i> Tambah
            </a>
        </div>
        <table id="table-products" class="table table-stripped">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Stock</th>
                    <th>Harga</th>
                    <th width="150px">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('script')
<script>
    var table = $('#table-products').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('product.index') }}',
        order: [[1,'asc']],
        columns: [
            {data: 'DT_RowIndex', searchable: false, orderable:false},
            {data: 'product_code'},
            {data: 'product_name'},
            {data: 'category_name'},
            {data: 'stock'},
            {data: 'price'},
            {data: 'action', searchable: false, orderable:false},
        ],
        drawCallback: function(){
            confirmDelete();
        }
    });
</script>    
@endpush