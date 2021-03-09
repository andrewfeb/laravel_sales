@extends('layouts.main')

@section('title', 'Order')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Penjualan</li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('order.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="customer">Customer</label>
                    <select class="select2 form-control @error('customer') is-invalid @enderror" name="customer" data-allow-clear="true"
                    data-placeholder="Pilih customer">
                        <option></option>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                        @endforeach
                    </select>
                    @error('customer')
                        <label class="invalid-feedback" for="customer">{{ $message }}</label>
                    @enderror
                </div>
                <div class="customer_detail">
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <div class="info-box-content">
                        <div class="text-right">
                            <span class="text-muted">{{now()}}</span>
                            <h1 class="display-4 total">0</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <input type="text" name="product" class="form-control" placeholder="Kode Produk">
            </div>
            <div class="col-md-1">
                <input type="number" name="qty" min="1" class="form-control" value="1" placeholder="qty">
            </div>
            <div class="col-md-2">
                <button type="button" id="btn_add" class="btn btn-primary">Tambah</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                @error('total')
                    <label class="text-danger" for="total"><small><strong>{{ $message }}</strong></small></label>
                @enderror
                {{session()->forget('order')}}
                <table id="table-cart" class="table order-detail">
                    <thead>
                        <tr>
                            <th width="200px">Kode Produk</th>
                            <th>Nama Produk</th>
                            <th width="100px">Qty</th>
                            <th width="200px">SubTotal</th>
                            <th width="10px"></th>
                        </tr>
                    </thead>
                    <tbody class="cart_detail">
                        @if(Session::has('order'))
                        @foreach (session('order') as $order)
                            <tr>
                                <td>{{ $order['product_code'] }}</td>
                                <td>{{ $order['product_name'] }}</td>
                                <td>{{ $order['qty'] }}</td>
                                <td class="subtotal">{{ $order['total'] }}</td>
                                <td><button type="button" class="btn btn-outline-danger btn-sm remove" title="Hapus" onclick="removeCart(this);"><i class="far fa-trash-alt"></i></button></td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right">Total</td>
                            <td width="200px" colspan="2"><input type="text" name="total" class="form-control text-right" readonly>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="bnt_print">Proses</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    calculate();
    $('.select2').select2({
        width: '100%',
        theme: 'bootstrap4'
    }).on('select2:select', function(e){
        $.ajax({
            type: 'GET',
            url: '{{ route('order.getCustomer')}}',
            data: {'customer': e.params.data.id},
            dataType: 'JSON',
            success: function(data){
                let dataCustomer = `<address>
                    ${data.address}<br/>
                    ${data.city}<br/>
                    ${data.email}<br/>
                    ${data.hp}<br/>
                </address><input type="hidden" name="email" value="${data.email}">`;
                $('.customer_detail').html(dataCustomer);
            }
        })
    });

    function removeCart(element){
        let row = element.parentNode.parentNode;
        row.parentNode.removeChild(row);

        let table = document.querySelector('.order-detail').getElementsByTagName('tbody')[0];
        if (table.rows.length == 1) {
            document.querySelectorAll('button.remove').forEach(element => {
                element.readonly = true;
            });
        }
    }

    $('#btn_add').on('click', function(){
        let tableOrder = document.querySelector('.order-detail').getElementsByTagName('tbody')[0];
        let lastId = tableOrder.rows.length;
        $.ajax({
            type: 'GET',
            url: '{{ route('order.getProduct') }}',
            data: {'product': $('input[name="product"]').val(), 'qty': $('input[name="qty"]').val()},
            dataType: 'JSON',
            success: function(data) {
                $('input[name="product"]').val('');
                $('input[name="qty"]').val(1);
                if (data.order.length != 0){
                    if (!data.outOfStock){
                        let content = '';
                        let total_product = ($('input[name="total_product"]').val() == "") ? 0 :  $('input[name="total_product"]').val();
                        for(let i in data.order){
                            content += `
                                <tr><td>${data.order[i].product_code}</td>
                                <td>${data.order[i].product_name}</td>
                                <td>${data.order[i].qty}</td>
                                <td class="subtotal">${data.order[i].total}</td>
                                <td>
                                <button type="button" class="btn btn-outline-danger btn-sm remove" title="Hapus" onclick="removeCart(this);"><i class="far fa-trash-alt"></i></button>
                                </td></tr>`;
                            total_product += 1;
                        }
                        $('.cart_detail').html(content);
                        calculate();
                    }else{
                        sweetAlert('error', 'Stok Produk tidak mencukupi');
                    }

                }else{
                    sweetAlert('error', 'Produk tidak ada');
                }
            }
        })
    });

    function calculate(){
        let subtotal = 0;
        
        $('#table-cart tbody tr').each(function(){
            subtotal += parseInt($(this).find('.subtotal').text());
        });
        $('input[name="total"]').attr('readonly', false);
        $('input[name="total"]').val(subtotal);
        $('input[name="total"]').attr('readonly', true);
        $('.total').text(subtotal);
    }
    
</script>
@endpush
