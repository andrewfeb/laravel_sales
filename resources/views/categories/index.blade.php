@extends('layouts.main')

@section('title', 'Kategori')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Kategori Produk</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">Daftar Kategori</div>
    <div class="card-body">
        <div class="mb-3">
            <a href="{{ route('category.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus-circle"></i> Tambah
            </a>
        </div>
        <table id="table-categories" class="table table-stripped">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th>Nama Kategori</th>
                    <th width="150px">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Detail Module -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="Detail Category"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    var table = $('#table-categories').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('category.index') }}',
        order: [[1,'asc']],
        columns: [
            {data: 'DT_RowIndex', searchable: false, orderable:false},
            {data: 'category_name'},
            {data: 'action', searchable: false, orderable:false},
        ],
        drawCallback: function(){
            confirmDelete();
        }
    });

    function showDetail(url) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                $('#detailModal').find('.modal-body').html(data);
                $('#detailModal').modal({
                    show: true
                });
            }
        });
    }
</script>    
@endpush