<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'Laravel') }} | Invoice</title>
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h3 class="mb-3">{{ config('app.name', 'Laravel') }}</H3>
        <div class="row mb-3">
            <div class="col-md-6">
            <strong>Customer</strong><br/>
            {{ $order->customer->customer_name }}<br/>
            {{ $order->customer->address }}<br/>
            {{ $order->customer->city }}<br/>
            {{ $order->customer->email }}<br/>
            {{ $order->customer->hp }}<br/>
            </div>
            <div class="col-md-6">
                <p class="text-right">{{ $order->order_date }}</p>
            </div>
        </div>
        <table class="table table-stripped">
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>SubTotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product_id }}</td>
                    <td>{{ $detail->product->product_name }}</td>
                    <td class="text-right">{{ $detail->qty }}</td>
                    <td class="text-right">{{ $detail->total }}</td>
                </tr>
                @endforeach                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Total</td>
                    <td class="text-right">{{ $order->total_price }}</td>
                </tr>
            </tfoot>
        </table>
        <div class="mt-5 text-right">
            <span><strong>Kasir</strong></span><br/>
            <span>{{ $order->user->name }}</span>
            
        </div>
    </div>
</body>
</html>