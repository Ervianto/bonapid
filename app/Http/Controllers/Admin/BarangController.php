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
use File;

class BarangController extends Controller
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
            $barang = DB::table('barang')->orderBy('barang_nama')->get();

            return DataTables::of($barang)
                ->addColumn('status', function ($row) {
                    if ($row->barang_status == 0) {
                        $data = '<a href="javascript:void(0)" class="btn btn-success btn-icon-text btn-lg" id="btnTampilkan" data-toggle="modal" data-id="' . $row->barang_id . '"><i class="mdi mdi-lock"></i> Hidden</a>';
                    } else {
                        $data = '<a href="javascript:void(0)" class="btn btn-success btn-icon-text btn-lg" id="btnTampilkan" data-toggle="modal" data-id="' . $row->barang_id . '"><i class="mdi mdi-lock-open"></i> Display</a>';
                    }
                    return $data;
                })
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-info btn-icon-text" id="btnDetail" data-toggle="modal" data-id="' . $row->barang_id . '"><i class="mdi mdi-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-warning btn-icon-text" id="btnEdit" data-toggle="modal" data-id="' . $row->barang_id . '"><i class="mdi mdi-pencil-box"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->barang_id . '"><i class="mdi mdi-trash-can-outline"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['aksi', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.gudang.barang');
    }
    public function indexStok()
    {
        if (request()->ajax()) {
            $barang = DB::table('barang')
                ->orderBy('nama')
                ->get();

            return DataTables::of($barang)
                ->addColumn('stok', function ($row) {
                    $st = '<span class="badge badge-pill badge-danger"> ' . $row->stok . '</span>';
                    return $st;
                })
                ->rawColumns(['stok'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('it.stok-barang');
    }
    public function store(Request $request)
    {
        $file = $request->file('barang_gambar');
        if ($file == "") {
            $nama_file = "";
        } else {
            $file->move(public_path('images'), $file->getClientOriginalName());
            $nama_file = $file->getClientOriginalName();
        }

        if ($request->action == 'tambah') {

            if ($file == "") {
                DB::table('barang')->insert([
                    'barang_nama'     => $request->barang_nama,
                    'barang_kode'     => 'BRG' . str_replace('-', '', $request->barang_tgl) . \Carbon\Carbon::now()->format('Hi'),
                    'barang_tgl'     => $request->barang_tgl,
                    'barang_satuan'     => $request->barang_satuan,
                    'barang_stok'     => $request->barang_stok,
                    'barang_status'     => '0',
                    'barang_gambar'     => $nama_file,
                ]);
            } else {
                DB::table('barang')->insert([
                    'barang_nama'     => $request->barang_nama,
                    'barang_kode'     => 'BRG' . str_replace('-', '', $request->barang_tgl) . \Carbon\Carbon::now()->format('Hi'),
                    'barang_tgl'     => $request->barang_tgl,
                    'barang_satuan'     => $request->barang_satuan,
                    'barang_stok'     => $request->barang_stok,
                    'barang_status'     => '0',
                    'barang_gambar'     => $nama_file,
                ]);
            }

            Alert::success('Sukses', 'Barang Berhasil Ditambah');
            return redirect("/admin/barang");
        } else if ($request->action == 'edit') {

            DB::table('barang')->where('barang_id', $request->barang_id)->update([
                'barang_nama'     => $request->barang_nama,
                'barang_kode'     => 'S' . str_replace('-', '', $request->barang_tgl),
                'barang_tgl'     => $request->barang_tgl,
                'barang_stok'     => $request->barang_stok,
                'barang_satuan'     => $request->barang_satuan,
                'barang_gambar'     => $nama_file,
            ]);

            Alert::success('Sukses', 'Barang Berhasil Diedit');
            return redirect("/admin/barang");
        }
    }

    public function edit($id)
    {
        $barang = DB::table('barang')->where('barang_id', $id)->first();

        return Response::json($barang);
    }

    public function destroy(Request $request)
    {
        $dt = DB::table('barang')->where('barang_id', $request->barang_id1)->first();
        File::delete('images/' . $dt->barang_gambar);

        DB::table('barang')->where('barang_id', $request->barang_id1)->delete();

        Alert::success('Sukses', 'Barang Berhasil Dihapus');

        return redirect("/admin/barang");
    }

    public function tampilkan(Request $request)
    {
        if ($request->status == "display") {
            DB::table('barang')->where('barang_id', $request->barang_id2)->update([
                'barang_status'     => '1'
            ]);
        } else {
            DB::table('barang')->where('barang_id', $request->barang_id2)->update([
                'barang_status'     => '0'
            ]);
        }

        Alert::success('Sukses', 'Barang Berhasil Diupdate Display');

        return redirect("/admin/barang");
    }
}
