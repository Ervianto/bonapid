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
use Illuminate\Support\Str;

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
            $produk = DB::table('produk')
                ->select('produk.*', 'kategori.nama_kategori')
                ->join('kategori', 'kategori.id', '=', 'produk.kategori_id')
                ->orderBy('nama_produk')->get();

            return DataTables::of($produk)
                ->addColumn('status', function ($row) {
                    if ($row->status == 0) {
                        $data = '<a href="javascript:void(0)" class="btn btn-success btn-icon-text btn-lg" id="btnTampilkan" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-lock"></i> Hidden</a>';
                    } else {
                        $data = '<a href="javascript:void(0)" class="btn btn-success btn-icon-text btn-lg" id="btnTampilkan" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-lock-open"></i> Display</a>';
                    }
                    return $data;
                })
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-info btn-icon-text" id="btnDetail" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-warning btn-icon-text" id="btnEdit" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-pencil-box"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-trash-can-outline"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['aksi', 'status'])
                ->addIndexColumn()
                ->make(true);
        }

        $kategori = DB::table('kategori')->orderBy('nama_kategori')->get();

        return view('admin.barang.barang', [
            'kategori'  =>  $kategori
        ]);
    }

    public function indexStok()
    {
        if (request()->ajax()) {
            $produk = DB::table('produk')
                ->join('kategori', 'kategori.id', '=', 'produk.kategori_id')
                ->orderBy('nama_produk')
                ->get();

            return DataTables::of($produk)
                ->addColumn('stok_produk', function ($row) {
                    $st = '<span class="badge badge-pill badge-danger"> ' . $row->stok_produk . '</span>';
                    return $st;
                })
                ->rawColumns(['stok_produk'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.barang.stok');
    }
    public function store(Request $request)
    {
        $file = $request->file('foto_produk');
        if ($file == "") {
            $nama_file = "";
        } else {
            $file->move(public_path('foto/produk'), $file->getClientOriginalName());
            $nama_file = $file->getClientOriginalName();
        }

        if ($request->action == 'tambah') {

            DB::table('produk')->insert([
                'nama_produk'     => $request->nama_produk,
                'kode_produk'     => 'BRG' . \Carbon\Carbon::now()->format('Hi') . Str::random(3),
                'harga_produk'     => $request->harga_produk,
                'kategori_id'     => $request->kategori_id,
                'variasi_produk'     => $request->variasi_produk,
                'ukuran_produk'     => $request->ukuran_produk,
                'berat_produk'     => $request->berat_produk,
                'deskripsi_produk'     => $request->deskripsi_produk,
                'status'     => '0',
                'stok_produk'     => '0',
                'foto_produk'     => $nama_file,
                'created_at'    => \Carbon\Carbon::now()
            ]);

            Alert::success('Sukses', 'Barang Berhasil Ditambah');
            return redirect("/admin/barang");
        } else if ($request->action == 'edit') {

            DB::table('produk')->where('id', $request->id)->update([
                'nama_produk'     => $request->nama_produk,
                'harga_produk'     => $request->harga_produk,
                'kategori_id'     => $request->kategori_id,
                'variasi_produk'     => $request->variasi_produk,
                'ukuran_produk'     => $request->ukuran_produk,
                'berat_produk'     => $request->berat_produk,
                'deskripsi_produk'     => $request->deskripsi_produk,
                'foto_produk'     => $nama_file,
                'updated_at'    => \Carbon\Carbon::now()
            ]);

            Alert::success('Sukses', 'Barang Berhasil Diedit');
            return redirect("/admin/barang");
        }
    }

    public function edit($id)
    {
        $produk = DB::table('produk')
            ->join('kategori', 'kategori.id', '=', 'produk.kategori_id')
            ->where('produk.id', $id)->first();

        return Response::json($produk);
    }

    public function destroy(Request $request)
    {
        $dt = DB::table('produk')->where('id', $request->id1)->first();
        File::delete('foto/produk/' . $dt->foto_produk);

        DB::table('produk')->where('id', $request->id1)->delete();

        Alert::success('Sukses', 'Barang Berhasil Dihapus');

        return redirect("/admin/barang");
    }

    public function tampilkan(Request $request)
    {
        if ($request->status == "display") {
            DB::table('produk')->where('id', $request->id2)->update([
                'status'     => '1'
            ]);
        } else {
            DB::table('produk')->where('id', $request->id2)->update([
                'status'     => '0'
            ]);
        }

        Alert::success('Sukses', 'Barang Berhasil Diupdate Display');

        return redirect("/admin/barang");
    }
}
