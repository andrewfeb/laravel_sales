<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if ($request->ajax()) {
           $categories = Category::select('id', 'category_name');

           return Datatables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($category) {
                    return '<a href="#" class="btn btn-xs btn-warning" data-toggel="modal" onclick="showDetail(&#39;'.route('category.show', [$category->id]).'&#39;)"><i class="fa fa-bars"></i> Detail</a> <a href="'.route('category.edit', [$category->id]).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a> <a href="'.route('category.destroy', [$category->id]).'" class="btn btn-xs btn-danger" data-confirm="Yakin menghapus data ini?"><i class="fa fa-trash"></i> Hapus</a>';
                })
                ->toJson();
       }

       return view('categories.index', compact('categories'));         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'category_name' => 'required|min:5|max:30'
        ],[
            'category_name.required' => 'Nama kategori tidak boleh kosong',
            'category_name.max' => 'Panjang maksimum 30 karakter'
        ]);
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
            Category::create($request->all());
            $status = [
                'status' => 'success',
                'message' => 'Kategory berhasil ditambah'
            ];
        }catch(Exception $e){
            $status = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return redirect('category')->with($status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category->load('products');
        
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validateForm($request);

        try{
            $category->update($request->all());
            $status = [
                'status' => 'success',
                'message' => 'Kategory berhasil diupdate'
            ];
        }catch(Exception $e){
            $status = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return redirect('category')->with($status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $result = $category->delete();

        if ($result > 0){
            $status = [
                'status' => 'success',
                'message' => 'Kategory berhasil dihapus'
            ];
        }else{
            $status = [
                'status' => 'error',
                'message' => 'Kategory gagal dihapus'
            ];
        }

        return response()->json($status);
    }
}
