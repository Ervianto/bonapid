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
            $user = DB::table('users')->orderBy('name')->get();

            return DataTables::of($user)
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="<a href="javascript:void(0)" class="btn btn-warning btn-icon-text" id="btnEdit" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-pencil-box"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-trash-can-outline"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['aksi'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.user');
    }

    public function store(Request $request)
    {

        if ($request->action == 'tambah') {

            DB::table('users')->insert([
                'name'     => $request->name,
                'username'     => $request->username,
                'email'     => $request->email,
                'password'     => Hash::make($request->password),
                'role'     => $request->role,
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
}
