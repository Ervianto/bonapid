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

class TransaksiController extends Controller
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
            $transaksi = DB::table('transaksi')
                ->select('transaksi.*', 'users.name', 'pm.status')
                ->join('users', 'users.id', '=', 'transaksi.user_id')
                ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
                ->orderByDesc('transaksi.created_at')->get();

            return DataTables::of($transaksi)
                ->addColumn('status_pembayaran', function ($row) {
                    if ($row->status == "settlement") {
                        $data = 'SUDAH TERBAYAR';
                    } else {
                        $data = 'MENUNGGU DIBAYAR';
                    }
                    return $data;
                })
                ->addColumn('status_trx', function ($row) {
                    if ($row->status_transaksi == "0") {
                        $data = 'BELUM';
                    } else {
                        $data = 'SELESAI';
                    }
                    return $data;
                })
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-info btn-icon-text" id="btnDetail" data-toggle="modal" data-id="' . $row->kode . '"><i class="mdi mdi-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->kode . '"><i class="mdi mdi-trash-can-outline"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['aksi', 'status_pembayaran', 'status_trx'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.transaksi.transaksi');
    }

    public function indexStok()
    {
        if (request()->ajax()) {
            $produk = DB::table('produk')
                ->select('produk.*', 'kategori.nama_kategori')
                ->join('kategori', 'kategori.id', '=', 'produk.kategori_id')
                ->orderBy('nama_produk')
                ->get();

            return DataTables::of($produk)
                ->addColumn('stok', function ($row) {
                    $st = '<span class="badge badge-pill badge-danger"> ' . $row->stok_produk . '</span>';
                    return $st;
                })
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-info btn-icon-text" id="btnDetail" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-warning btn-icon-text" id="btnEdit" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-pencil-box"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['stok', 'aksi'])
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

            if ($request->file('foto_produk') == "") {
                DB::table('produk')->where('id', $request->id)->update([
                    'nama_produk'     => $request->nama_produk,
                    'harga_produk'     => $request->harga_produk,
                    'kategori_id'     => $request->kategori_id,
                    'variasi_produk'     => $request->variasi_produk,
                    'ukuran_produk'     => $request->ukuran_produk,
                    'berat_produk'     => $request->berat_produk,
                    'deskripsi_produk'     => $request->deskripsi_produk,
                    'updated_at'    => \Carbon\Carbon::now()
                ]);
            } else {
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
            }

            Alert::success('Sukses', 'Barang Berhasil Diedit');
            return redirect("/admin/barang");
        } else {
            DB::table('produk')->where('id', $request->id)->update([
                'stok_produk'     => $request->stok_produk
            ]);

            Alert::success('Sukses', 'Stok Barang Berhasil Diedit');
            return redirect("/admin/stok");
        }
    }

    public function edit($id)
    {
        $produk = DB::table('produk')
            ->select('produk.*', 'kategori.nama_kategori')
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
