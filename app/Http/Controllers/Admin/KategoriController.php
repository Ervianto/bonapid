<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Response;
use Validator;
use Illuminate\Support\Facades\Auth;
use PDF;
use Yajra\Datatables\Datatables;
use File;
use Illuminate\Support\Str;

class KategoriController extends Controller
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
            $kategori = DB::table('kategori')
                ->orderBy('nama_kategori')->get();

            return DataTables::of($kategori)
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-warning btn-icon-text" id="btnEdit" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-pencil-box"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-trash-can-outline"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['aksi'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.master.kategori');
    }

    public function store(Request $request)
    {
        if ($request->action == 'tambah') {

            DB::table('kategori')->insert([
                'nama_kategori'     => $request->nama_kategori,
                'created_at'    => \Carbon\Carbon::now()
            ]);

            Alert::success('Sukses', 'Kategori Berhasil Ditambah');
            return redirect("/admin/kategori");
        } else if ($request->action == 'edit') {

            DB::table('kategori')->where('id', $request->id)->update([
                'nama_kategori'     => $request->nama_kategori,
                'updated_at'    => \Carbon\Carbon::now()
            ]);

            Alert::success('Sukses', 'Kategori Berhasil Diedit');
            return redirect("/admin/kategori");
        }
    }

    public function edit($id)
    {
        $kategori = DB::table('kategori')
            ->where('id', $id)->first();

        return Response::json($kategori);
    }

    public function destroy(Request $request)
    {
        DB::table('kategori')->where('id', $request->id1)->delete();

        Alert::success('Sukses', 'Kategori Berhasil Dihapus');

        return redirect("/admin/kategori");
    }
}
