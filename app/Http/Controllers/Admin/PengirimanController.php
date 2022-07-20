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

class PengirimanController extends Controller
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
    public function index(Request $request)
    {
        if (request()->ajax()) {
            if ($request->get('tgl_awal') || $request->get('tgl_akhir')) {
                $transaksi = DB::table('pengiriman')
                    ->select('pengiriman.*', 'users.name', 'transaksi.id as id_trx', 'transaksi.created_at as tgl_trx','transaksi.tipe')
                    ->join('transaksi', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
                    ->join('users', 'users.id', '=', 'transaksi.user_id')
                    ->where('pengiriman.status_sampai','!=','2')
                    ->whereBetween('transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->orderByDesc('transaksi.created_at')->get();
            } else {
                $transaksi = DB::table('pengiriman')
                    ->select('pengiriman.*', 'users.name', 'transaksi.id as id_trx', 'transaksi.created_at as tgl_trx','transaksi.tipe')
                    ->join('transaksi', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
                    ->join('users', 'users.id', '=', 'transaksi.user_id')
                    ->where('pengiriman.status_sampai','!=','2')
                    ->orderByDesc('transaksi.created_at')->get();
            }

            return DataTables::of($transaksi)
                ->addColumn('sd', function ($row) {
                    if ($row->status_dikirim == "0") {
                        $data = '<a href="javascript:void(0)" class="btn btn-success btn-icon-text" id="btnKirim" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-send"></i> Kirim</a>
                                            <meta name="csrf-token" content="{{ csrf_token() }}">';
                    } else {
                        $data = 'SUDAH DIKIRIM';
                    }
                    return $data;
                })
                ->addColumn('ss', function ($row) {
                    if ($row->status_sampai == "0") {
                        $data = 'BELUM SAMPAI';
                    } else {
                        $data = 'SUDAH SAMPAI';
                    }
                    return $data;
                })
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-info btn-icon-text" id="btnDetail" data-toggle="modal" data-id="' . $row->id_trx . '"><i class="mdi mdi-eye"></i></a>';
                    return $data;
                })
                ->rawColumns(['sd', 'ss', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.transaksi.pengiriman');
    }

    public function edit($id)
    {
        $pengiriman = DB::table('pengiriman')
            ->where('id', $id)->first();

        return Response::json($pengiriman);
    }

    public function kirim(Request $request)
    {
        $data = DB::table('pengiriman')->where('id',$request->id1)->first();
        $cek = DB::table('pengiriman')->where('kode_transaksi',$data->kode_transaksi)->count();
        if($cek>1){
            $transaksi = DB::table('detail_transaksi')->where('kode_transaksi',$data->kode_transaksi)->get();
            foreach($transaksi as $dt){
                $produk = DB::table('produk')->where('id', $dt->produk_id)->first();
                DB::table('produk')->where('id', $dt->produk_id)->update([
                    'stok_produk'     => $produk->stok_produk - $dt->qty
                ]);
            }
        }

        DB::table('pengiriman')->where('id', $request->id1)->update([
            'status_dikirim'     => '1'
        ]);
        
        Alert::success('Sukses', 'Barang Berhasil Dikirim');

        return redirect("/admin/pengiriman");
    }
}
