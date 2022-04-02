<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;
use Illuminate\Support\Facades\Hash;
use Validator;

class AccountController extends Controller
{
    public function signin()
    {
        return view('customer.account.signin');
    }

    public function signup(Request $request)
    {

        $rules = [
            'name'                   => 'required|unique:users,name',
            'email'                 => 'required|unique:users,email',
            'username'                 => 'required|unique:users,username',
            'telepon'                 => 'required|unique:users,telepon'
        ];

        $messages = [
            'name.unique'              => 'Nama Lengkap Sudah Terdaftar',
            'name.required'            => 'Nama Lengkap Wajib Diisi',
            'email.unique'            => 'Email Sudah Terdaftar',
            'email.required'            => 'Email Wajib Diisi',
            'username.unique'            => 'Username Sudah Terdaftar',
            'username.required'            => 'Username Wajib Diisi',
            'telepon.unique'            => 'No. Telepon Sudah Terdaftar',
            'telepon.required'            => 'No. Telepon Wajib Diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        DB::table('users')->insert([
            'name'  => $request->name,
            'username'  => $request->username,
            'telepon'  => $request->telepon,
            'alamat'  => $request->alamat,
            'email'  => $request->email,
            'password'  => Hash::make($request->password),
            'role'  => 'customer'
        ]);

        Alert::success('Sukses', 'Berhasil Mendaftar Akun');
        return redirect()->back();
    }
}
