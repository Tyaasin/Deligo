<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'user'      => User::get(),
            'content'   => 'admin.user.index'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = collect(['admin', 'kasir', 'pelanggan']);

        $data = [
            'role'   => $role,
            'content'   => 'admin.user.create'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required',
            'email'  => 'required|email|unique:users',
            'role'  => 'required|in:admin,kasir,pelanggan',
            'password'  => 'required',
            're_password'  => 'required|same:password',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        Alert::success('Succes', 'Data telah ditambahkan!!');
        return redirect('/admin/user')->with('success', 'Data telah ditambahkan!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = collect(['admin', 'kasir', 'pelanggan']);

        $data = [
            'role'      => $role,
            'user'      => User::find($id),
            'content'   => 'admin.user.edit'
        ];
        return view('admin.layouts.wrapper', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->validate([
            'name'  => 'required',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,kasir,pelanggan',
            're_password'  => 'same:password',
        ]);

        if ($request->password != '') {
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password']  = $user->password;
        }

        $user->update($data);
        Alert::success('Succes', 'Data telah diedit!!');
        return redirect('/admin/user')->with('success', 'Data telah diedit!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        $user->delete();
        Alert::success('Succes', 'Data telah dihapus!!');
        return redirect('/admin/user')->with('success', 'Data telah dihapus!!');
    }
}
