<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select('id', 'name', 'email', 'hp', 'level');
 
            return Datatables::of($users)
                 ->addIndexColumn()
                 ->addColumn('action', function ($user) {
                     return '<a href="'.route('user.edit', [$user->id]).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a> <a href="'.route('user.destroy', [$user->id]).'" class="btn btn-xs btn-danger" data-confirm="Yakin menghapus data ini?"><i class="fa fa-trash"></i> Hapus</a>';
                 })
                 ->toJson();
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Fungsi untuk validasi form
     *
     * @param Request $request
     * @return void
     */
    public function validateForm($request, $id = null)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'password' => 'required|max:16',
                'email' => 'required|max:65|email|unique:users,email',
            ];
        }else{
            $rules = [
                'email' => 'required|max:65|email|unique:users,email,'.$id,
            ];
        }
        $this->validate($request, [
            'name' => 'required|between:5,65',
            'hp' => 'required|digits_between:10,15'
        ] + $rules,[
            'name.required' => 'Nama user harus diisi',
            'name.between' => 'Panjang minimum 5 karakter dan maksimal 65 karakter',
            'hp.required' => 'HP harus diisi',
            'hp.digits_between' => 'HP harus angkad dengan panjang antara 10 - 15 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Panjang maksimal 65 karakter',
            'email.unique' => 'Email telah digunakan',
            'password.required' => 'Password harus diisi',
            'password.max' => 'Panjang maksimum 16 karakter'
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
            User::create($request->except('password') + [
                'password' => Hash::make($request->input('password'))
            ]);
            $status = [
                'status' => 'success',
                'message' => 'User berhasil ditambah'
            ];
        }catch(Exception $e){
            $status = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return redirect('user')->with($status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validateForm($request, $user->id);
        try{
            $user->update($request->except('password'));
            $status = [
                'status' => 'success',
                'message' => 'User berhasil diupdate'
            ];
        }catch(Exception $e){
            $status = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return redirect('user')->with($status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $result = $user->delete();

        if ($result > 0){
            $status = [
                'status' => 'success',
                'message' => 'User berhasil dihapus'
            ];
        }else{
            $status = [
                'status' => 'error',
                'message' => 'User gagal dihapus'
            ];
        }

        return response()->json($status);
    }
}
