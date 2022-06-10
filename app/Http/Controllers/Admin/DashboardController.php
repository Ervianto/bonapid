<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_brg = DB::table('produk')->count();
        $total_trx = DB::table('transaksi')->count();
        $total_trx_blm_bayar = DB::table('transaksi')
            ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
            ->where('pm.status', 'pending')->count();
        $total_trx_sdh_bayar = DB::table('transaksi')
            ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
            ->where('pm.status', 'settlement')->count();
        $total_trx_sdh_kirim =  DB::table('pengiriman')
            ->join('transaksi', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->where('status_dikirim', '1')->count();
        $total_trx_sdh_sampai =  DB::table('pengiriman')
            ->join('transaksi', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->where('status_sampai', '1')->count();

        //chart
        $trx_produk = DB::table('detail_transaksi')
            ->select('detail_transaksi.produk_id', 'produk.nama_produk', DB::raw('sum(detail_transaksi.qty) as total'))
            ->join('produk', 'produk.id', '=', 'detail_transaksi.produk_id')
            ->groupBy('detail_transaksi.produk_id')
            ->get();

        $trx_user = DB::table('transaksi')
            ->select('transaksi.user_id', 'users.username', DB::raw('sum(transaksi.total_transaksi) as total'))
            ->join('users', 'users.id', '=', 'transaksi.user_id')
            ->groupBy('transaksi.user_id')
            ->get();

        return view('admin.dashboard.dashboard', [
            'total_brg' => $total_brg,
            'total_trx' => $total_trx,
            'total_trx_blm_bayar' => $total_trx_blm_bayar,
            'total_trx_sdh_bayar' => $total_trx_sdh_bayar,
            'total_trx_sdh_kirim' => $total_trx_sdh_kirim,
            'total_trx_sdh_sampai' => $total_trx_sdh_sampai,
            'trx_produk'    => $trx_produk,
            'trx_user'    => $trx_user
        ]);
    }
}
