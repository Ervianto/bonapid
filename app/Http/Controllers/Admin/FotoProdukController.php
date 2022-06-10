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

class FotoProdukController extends Controller
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
            $produk = DB::table('detail_produk')
                ->select('detail_produk.*', 'produk.nama_produk')
                ->join('produk', 'produk.id', '=', 'detail_produk.produk_id')
                ->orderBy('produk.nama_produk')->get();

            return DataTables::of($produk)
                ->addColumn('foto', function ($row) {
                    $data = '<a href="http://localhost/ecommerce/public/foto/produk/' . $row->foto_produk . '" target="_blank"><img src="http://localhost/ecommerce/public/foto/produk/' . $row->foto_produk . '" width="300px"></img></a>';
                    return $data;
                })
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-warning btn-icon-text" id="btnEdit" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-pencil-box"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-trash-can-outline"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['aksi', 'foto'])
                ->addIndexColumn()
                ->make(true);
        }

        $produk = DB::table('produk')->orderBy('nama_produk')->get();

        return view('admin.barang.foto-produk', [
            'produk'  =>  $produk
        ]);
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

            DB::table('detail_produk')->insert([
                'produk_id'     => $request->produk_id,
                'foto_produk'     => $nama_file,
                'created_at'    => \Carbon\Carbon::now()
            ]);

            Alert::success('Sukses', 'Foto Produk Berhasil Ditambah');
            return redirect("/admin/foto-produk");
        } else {

            if ($request->file('foto_produk') == "") {
                DB::table('detail_produk')->where('id', $request->id)->update([
                    'produk_id'     => $request->produk_id,
                    'updated_at'    => \Carbon\Carbon::now()
                ]);
            } else {
                DB::table('detail_produk')->where('id', $request->id)->update([
                    'produk_id'     => $request->produk_id,
                    'foto_produk'     => $nama_file,
                    'updated_at'    => \Carbon\Carbon::now()
                ]);
            }

            Alert::success('Sukses', 'Foto Produk Berhasil Diedit');
            return redirect("/admin/foto-produk");
        }
    }

    public function edit($id)
    {
        $produk = DB::table('detail_produk')
            ->where('id', $id)->first();

        return Response::json($produk);
    }

    public function destroy(Request $request)
    {
        $dt = DB::table('detail_produk')->where('id', $request->id1)->first();
        File::delete('foto/produk/' . $dt->foto_produk);

        DB::table('detail_produk')->where('id', $request->id1)->delete();

        Alert::success('Sukses', 'Foto Produk Berhasil Dihapus');

        return redirect("/admin/foto-produk");
    }
}
