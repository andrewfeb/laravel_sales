<div class="form-group row">
    <label for="category_name" class="col-sm-2 col-form-label"><strong>Nama Kategori</strong></label>
    <div class="col-sm-10">
        <input type="text" disabled class="form-control-plaintext" value="{{ $category->category_name }}">
    </div>
</div>
<div class="form-group row">
    <label for="created_at" class="col-sm-2 col-form-label"><strong>Created at</strong></label>
    <div class="col-sm-10">
        <input type="text" disabled class="form-control-plaintext" value="{{ $category->created_at }}">
    </div>
</div>
<div class="form-group row">
    <label for="updated_at" class="col-sm-2 col-form-label"><strong>Updated at</strong></label>
    <div class="col-sm-10">
        <input type="text" disabled class="form-control-plaintext" value="{{ $category->updated_at }}">
    </div>
</div>
<div class="form-group">
    <table class="table">
        <thead>
            <tr>
                <th style="width:5px">No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th class="w-25">Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($category->products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->product_code }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
