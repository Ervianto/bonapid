<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;
use Illuminate\Support\Facades\Hash;
use App\Models\Province;
use App\Models\City;
use App\Models\User;
use App\Models\AlamatUser;
use Validator;

class AccountController extends Controller
{

    public function index()
    {
        $provinces = Province::all();
        $user = User::join('alamat_user as alamat', 'alamat.id', '=', 'users.alamat_user_id')
            ->where('users.id', \Auth::user()->id)
            ->select('users.*', 'alamat.province_id', 'alamat.city_id', 'alamat.kode_pos', 'alamat.alamat')
            ->first();
        $cities = City::where('province_id', $user->province_id)
            ->select('city_id as id', 'name')
            ->get();
        return view('customer.account.index', compact('user', 'provinces', 'cities'));
    }

    public function updateAkun(Request $request)
    {
        $current_password = $request->current_password;
        $password_baru = $request->password;
        $password_lama = $request->password_confirmation;
        $user = User::find(\Auth::user()->id);
        if (Hash::check($current_password, $user->password)) {
            if ($password_baru != "") {
                if ($password_baru != $password_lama) {
                    Alert::error('Gagal', 'Password Baru dengan Konfirmasi Password Tidak Sama');
                    return redirect()->back();
                }
            } else {
                $user->password = Hash::make($password_baru);
            }
        } else {
            Alert::error('Gagal', 'Password anda tidak cocok dengan password anda login');
            return redirect()->back();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->username = $request->username;
        $user->save();

        $alamat = AlamatUser::find($user->alamat_user_id);
        $alamat->province_id = $alamat->province_id;
        $alamat->city_id = $alamat->city_id;
        $alamat->kode_pos = $alamat->kode_pos;
        $alamat->alamat = $alamat->alamat;
        $alamat->save();
        Alert::success('Sukses', 'Berhasil mengubah data user');
        return redirect()->back();
    }

    public function signin()
    {
        $provinces = Province::all();
        return view('customer.account.signin', compact('provinces'));
    }

    public function getCities(Request $request)
    {
        $search = $request->search;
        $provinsi = $request->provinsi;
        if ($search != "") {
            $cities = City::where('province_id', $provinsi)
                ->where('name', 'like', '%' . $search . '%')
                ->select('city_id as id', 'name')
                ->get();
        } else {
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
            'role'  => 'customer',
            'status'    => '0'
        ]);

        Alert::success('Sukses', 'Berhasil Mendaftar Akun');
        return redirect()->back();
    }
}
