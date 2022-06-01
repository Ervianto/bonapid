<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;
use Illuminate\Support\Facades\Hash;
use App\Models\Province;
use App\Models\City;
use App\Models\AlamatUser;
use Validator;

class AccountController extends Controller
{
    public function signin()
    {
        $provinces = Province::all();
        return view('customer.account.signin', compact('provinces'));
    }

    public function getCities(Request $request)
    {
        $search = $request->search;
        $provinsi = $request->provinsi;
        if($search != ""){
            $cities = City::where('province_id', $provinsi)
                ->where('name', 'like', '%'.$search.'%')
                ->select('city_id as id', 'name')
                ->get();
        }else{
            $cities = City::where('province_id', $provinsi)
                ->select('city_id as id', 'name')
                ->get();
        }
        return response()->json($cities);
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

        $alamat = new AlamatUser();
        $alamat->province_id = $request->province_id;
        $alamat->city_id = $request->city_id;
        $alamat->kode_pos = $request->kode_pos;
        $alamat->alamat = $request->alamat;
        $alamat->save();

        DB::table('users')->insert([
            'name'  => $request->name,
            'username'  => $request->username,
            'telepon'  => $request->telepon,
            'alamat_user_id'  => $alamat->id,
            'email'  => $request->email,
            'password'  => Hash::make($request->password),
            'role'  => 'customer'
        ]);

        Alert::success('Sukses', 'Berhasil Mendaftar Akun');
        return redirect()->back();
    }
}
