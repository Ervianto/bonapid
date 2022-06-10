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

class LaporanController extends Controller
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
    public function indexTrx(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('tgl_awal') || $request->get('tgl_akhir')) {
                $transaksi = DB::table('transaksi')
                    ->select('transaksi.*', 'users.name', 'users.name', 'alamat_user.alamat', 'pengiriman.kurir', 'pengiriman.lama_sampai', 'pm.payment_type')
                    ->join('users', 'users.id', '=', 'transaksi.user_id')
                    ->join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
                    ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
                    ->join('alamat_user', 'alamat_user.id', '=', 'users.alamat_user_id')
                    ->whereBetween('transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->orderByDesc('transaksi.created_at')->get();
            } else {
                $transaksi = DB::table('transaksi')
                    ->select('transaksi.*', 'users.name', 'users.name', 'alamat_user.alamat', 'pengiriman.kurir', 'pengiriman.lama_sampai', 'pm.payment_type')
                    ->join('users', 'users.id', '=', 'transaksi.user_id')
                    ->join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
                    ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
                    ->join('alamat_user', 'alamat_user.id', '=', 'users.alamat_user_id')
                    ->orderByDesc('transaksi.created_at')->get();
            }

            return DataTables::of($transaksi)
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.laporan.transaksi');
    }
    public function indexStok(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('tgl_awal') || $request->get('tgl_akhir')) {
                $produk = DB::table('produk')
                    ->join('kategori', 'kategori.id', '=', 'produk.kategori_id')
                    ->whereBetween('produk.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->orderByDesc('produk.created_at')->get();
            } else {
                $produk = DB::table('produk')
                    ->join('kategori', 'kategori.id', '=', 'produk.kategori_id')
                    ->orderByDesc('produk.created_at')->get();
            }

            return DataTables::of($produk)
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.laporan.stok');
    }
}
