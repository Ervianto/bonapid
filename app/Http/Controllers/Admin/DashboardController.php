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

        return view('admin.dashboard.dashboard', [
            'total_brg' => $total_brg,
            'total_trx' => $total_trx,
            'total_trx_blm_bayar' => $total_trx_blm_bayar,
            'total_trx_sdh_bayar' => $total_trx_sdh_bayar,
            'total_trx_sdh_kirim' => $total_trx_sdh_kirim,
            'total_trx_sdh_sampai' => $total_trx_sdh_sampai
        ]);
    }

    public function statistik(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('tgl_awal') || $request->get('tgl_akhir')) {
                $total_brg = DB::table('produk')
                    ->whereBetween('created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->count();
                $total_trx = DB::table('transaksi')
                    ->whereBetween('created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->count();
                $total_trx_blm_bayar = DB::table('transaksi')
                    ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
                    ->where('pm.status', 'pending')
                    ->whereBetween('transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->count();
                $total_trx_sdh_bayar = DB::table('transaksi')
                    ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
                    ->where('pm.status', 'settlement')
                    ->whereBetween('transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->count();
                $total_trx_sdh_kirim =  DB::table('pengiriman')
                    ->join('transaksi', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
                    ->where('status_dikirim', '1')
                    ->whereBetween('transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->count();
                $total_trx_sdh_sampai =  DB::table('pengiriman')
                    ->join('transaksi', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
                    ->where('status_sampai', '1')
                    ->whereBetween('transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->count();
            } else {
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
            }

            return response()->json([
                'total_brg' => $total_brg,
                'total_trx' => $total_trx,
                'total_trx_blm_bayar' => $total_trx_blm_bayar,
                'total_trx_sdh_bayar' => $total_trx_sdh_bayar,
                'total_trx_sdh_kirim' => $total_trx_sdh_kirim,
                'total_trx_sdh_sampai' => $total_trx_sdh_sampai
            ]);
        }
    }

    public function chart1(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('tgl_awal') || $request->get('tgl_akhir')) {
                $items = DB::table('transaksi')
                    ->select('transaksi.user_id', 'transaksi.created_at', 'users.username', DB::raw('sum(transaksi.total_transaksi) as total'))
                    ->join('users', 'users.id', '=', 'transaksi.user_id')
                    ->groupBy('transaksi.user_id')
                    ->whereBetween('transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->get();
            } else {
                $items = DB::table('transaksi')
                    ->select('transaksi.user_id', 'users.username', DB::raw('sum(transaksi.total_transaksi) as total'))
                    ->join('users', 'users.id', '=', 'transaksi.user_id')
                    ->groupBy('transaksi.user_id')
                    ->get();
            }

            return response()->json([
                'data' => $items
            ]);
        }
    }

    public function chart2(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('tgl_awal') || $request->get('tgl_akhir')) {
                $items = DB::table('detail_transaksi')
                    ->select('detail_transaksi.produk_id', 'detail_transaksi.created_at', 'produk.nama_produk', DB::raw('sum(detail_transaksi.qty) as total'))
                    ->join('produk', 'produk.id', '=', 'detail_transaksi.produk_id')
                    ->groupBy('detail_transaksi.produk_id')
                    ->whereBetween('detail_transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->get();
            } else {
                $items = DB::table('detail_transaksi')
                    ->select('detail_transaksi.produk_id', 'produk.nama_produk', DB::raw('sum(detail_transaksi.qty) as total'))
                    ->join('produk', 'produk.id', '=', 'detail_transaksi.produk_id')
                    ->groupBy('detail_transaksi.produk_id')
                    ->get();
            }

            return response()->json([
                'data' => $items
            ]);
        }
    }
}
