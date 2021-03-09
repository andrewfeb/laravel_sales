<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::join('categories', 'categories.id', 'products.category_id')
                ->select('products.id', 'products.product_code','products.product_name', 'products.stock', 'products.price', 'categories.category_name');
 
            return Datatables::of($products)
                 ->addIndexColumn()
                 ->addColumn('action', function ($product) {
                     return '<a href="'.route('product.edit', [$product->id]).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a> <a href="'.route('product.destroy', [$product->id]).'" class="btn btn-xs btn-danger" data-confirm="Yakin menghapus data ini?"><i class="fa fa-trash"></i> Hapus</a>';
                 })
                 ->toJson();
        }
 
        return view('products.index'); 
    }

    /**
     * Fungsi untuk validasi form
     *
     * @param Request $request
     * @return void
     */
    public function validateForm($request)
    {
        $this->validate($request, [
            'product_code' => 'required|max:5',
            'product_name' => 'required|max:50',
            'category' => 'required',
            'stock' => 'required|numeric',
            'price' => 'required|numeric'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateForm($request);
        try{
            Product::create($request->except('category') + [
                'category_id' => $request->category
            ]);
            $status = [
                'status' => 'success',
                'message' => 'Produk berhasil ditambah'
            ];
        }catch(Exception $e){
            $status = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return redirect('product')->with($status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validateForm($request);
        try{
            $product->update($request->except('category') + [
                'category_id' => $request->category
            ]);
            $status = [
                'status' => 'success',
                'message' => 'Produk berhasil diupdate'
            ];
        }catch(Exception $e){
            $status = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return redirect('product')->with($status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $result = $product->delete();

        if ($result > 0){
            $status = [
                'status' => 'success',
                'message' => 'Produk berhasil dihapus'
            ];
        }else{
            $status = [
                'status' => 'error',
                'message' => 'Produk gagal dihapus'
            ];
        }

        return response()->json($status);
    }
}
