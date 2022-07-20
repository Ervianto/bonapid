<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Response;
use Validator;
use Illuminate\Support\Facades\Auth;
use PDF;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application Barang.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (request()->ajax()) {
            $user = DB::table('users')
                ->select('users.*', 'alamat_user.alamat')
                ->join('alamat_user', 'alamat_user.id', '=', 'users.alamat_user_id')
                // ->join('cities', 'cities.city_id', '=', 'alamat_user.city_id')
                // ->join('provinces', 'provinces.province_id', '=', 'alamat_user.province_id')
                ->orderBy('users.name')
                ->get();

            return DataTables::of($user)
                ->addColumn('status', function ($row) {
                    if ($row->status == '1') {
                        $data = '<input type="checkbox" id="cbStatus" class="checkbox status" data-id="' . $row->id . '" checked> Aktif';
                    } else {
                        $data = '<input type="checkbox" id="cbStatus" class="checkbox status" data-id="' . $row->id . '"> Aktif';
                    }
                    return $data;
                })
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-info btn-icon-text" id="btnDetail" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-eye"></i></a>
                            <a href="<a href="javascript:void(0)" class="btn btn-warning btn-icon-text" id="btnEdit" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-pencil-box"></i></a>
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-trash-can-outline"></i></a>
                                <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['aksi', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        $city = DB::table('cities')->orderBy('name')->get();
        $province = DB::table('provinces')->orderBy('name')->get();

        return view('admin.master.user', [
            'city'  => $city,
            'province'  => $province,
        ]);
    }

    public function indexProfile()
    {
        return view('admin.profile.edit');
    }

    public function store(Request $request)
    {

        if ($request->action == 'tambah') {

            $lastId = DB::table('alamat')->insertGetId([
                'province_id'   => $request->province_id,
                'city_id'       => $request->city_id,
                'kode_pos'      => $request->kode_pos,
                'alamat'        => $request->alamat
            ]);

            DB::table('users')->insert([
                'name'     => $request->name,
                'username'     => $request->username,
                'email'     => $request->email,
                'password'     => Hash::make($request->password),
                'role'     => $request->role,
                'telepon'     => $request->telepon,
                'alamat_user_id'    => $lastId,
                'status'    => '0'
            ]);

            Alert::success('Sukses', 'User Berhasil Ditambah');
            return redirect("/admin/user");
        } else if ($request->action == 'edit') {

            if ($request->password == "") {
                DB::table('users')->where('id', $request->id)->update([
                    'name'     => $request->name,
                    'username'     => $request->username,
                    'email'     => $request->email,
                    'role'     => $request->role,
                ]);
            } else {
                DB::table('users')->where('id', $request->id)->update([
                    'name'     => $request->name,
                    'username'     => $request->username,
                    'email'     => $request->email,
                    'password'     => Hash::make($request->password),
                    'role'     => $request->role,
                ]);
            }

            Alert::success('Sukses', 'User Berhasil Diedit');
            return redirect("/admin/user");
        }
    }

    public function edit($id)
    {
        $users = DB::table('users')->where('id', $id)->first();

        return Response::json($users);
    }

    public function destroy(Request $request)
    {
        DB::table('users')->where('id', $request->id1)->delete();

        Alert::success('Sukses', 'User Berhasil Dihapus');

        return redirect("/admin/user");
    }

    public function validasi(Request $request)
    {
        if ($request->status == "0") {
            DB::table('users')->where('id', $request->id)->update([
                'status'     => '1'
            ]);
        } else {
            DB::table('users')->where('id', $request->id)->update([
                'status'     => '0'
            ]);
        }

        return redirect("/admin/user");
    }

    public function updateProfile(Request $request)
    {
        if ($request->password == "") {
            DB::table('users')->where('id', $request->id)->update([
                'name'     => $request->name,
                'username'     => $request->username,
                'email'     => $request->email,
            ]);
        } else {
            DB::table('users')->where('id', $request->id)->update([
                'name'     => $request->name,
                'username'     => $request->username,
                'email'     => $request->email,
                'password'     => Hash::make($request->password),
            ]);
        }

        Alert::success('Sukses', 'Profile Berhasil Diupdate');
        return redirect()->back();
    }

    public function editProfile()
    {
        $users = DB::table('users')->where('id', Auth::user()->id)->first();

        return Response::json($users);
    }
}
