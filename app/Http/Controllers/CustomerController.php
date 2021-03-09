<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = Customer::select('id', 'customer_name','address', 'city', 'email', 'hp');
 
            return Datatables::of($customers)
                 ->addIndexColumn()
                 ->addColumn('action', function ($customer) {
                     return '<a href="'.route('customer.edit', [$customer->id]).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a> <a href="'.route('customer.destroy', [$customer->id]).'" class="btn btn-xs btn-danger" data-confirm="Yakin menghapus data ini?"><i class="fa fa-trash"></i> Hapus</a>';
                 })
                 ->toJson();
        }
 
        return view('customers.index'); 
    }

    /**
     * Fungsi untuk validasi form
     *
     * @param Request $request
     * @return void
     */
    public function validateForm($request, $id = null)
    {
        if($request->isMethod('post')){
            $rules = [
                'email' => 'required|email|unique:customers,email'    
            ];
        }else{
            $rules = [
                'email' => 'required|email|unique:customers,email,'.$id    
            ];
        }

        $this->validate($request, [
            'customer_name' => 'required|max:65',
            'address' => 'required|max:125',
            'city' => 'required|max:30',
            'hp' => 'required|digits_between:10,15'
        ] + $rules);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
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
            Customer::create($request->all());
            $status = [
                'status' => 'success',
                'message' => 'Customer berhasil ditambah'
            ];
        }catch(Exception $e){
            $status = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return redirect('customer')->with($status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $this->validateForm($request, $customer->id);
        try{
            $customer->update($request->all());
            $status = [
                'status' => 'success',
                'message' => 'Customer berhasil diupdate'
            ];
        }catch(Exception $e){
            $status = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return redirect('customer')->with($status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $result = $customer->delete();

        if ($result > 0){
            $status = [
                'status' => 'success',
                'message' => 'Customer berhasil dihapus'
            ];
        }else{
            $status = [
                'status' => 'error',
                'message' => 'Customer gagal dihapus'
            ];
        }

        return response()->json($status);
    }
}
