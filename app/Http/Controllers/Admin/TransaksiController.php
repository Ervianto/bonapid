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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('tgl_awal') || $request->get('tgl_akhir')) {
                if ($request->get('status') == "") {
                    $transaksi = DB::table('transaksi')
                        ->select('transaksi.*', 'users.name', 'pm.status')
                        ->join('users', 'users.id', '=', 'transaksi.user_id')
                        ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
                        ->whereBetween('transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                        ->orderByDesc('transaksi.created_at')->get();
                } else {
                    $transaksi = DB::table('transaksi')
                        ->select('transaksi.*', 'users.name', 'pm.status')
                        ->join('users', 'users.id', '=', 'transaksi.user_id')
                        ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
                        ->whereBetween('transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                        ->where('pm.status', '=', $request->get('status'))
                        ->orderByDesc('transaksi.created_at')->get();
                }
            } else {
                if ($request->get('status') == "") {
                    $transaksi = DB::table('transaksi')
                        ->select('transaksi.*', 'users.name', 'pm.status')
                        ->join('users', 'users.id', '=', 'transaksi.user_id')
                        ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
                        ->orderByDesc('transaksi.created_at')->get();
                } else {
                    $transaksi = DB::table('transaksi')
                        ->select('transaksi.*', 'users.name', 'pm.status')
                        ->join('users', 'users.id', '=', 'transaksi.user_id')
                        ->join('payment_midtrains as pm', 'pm.order_id', '=', 'transaksi.kode')
                        ->where('pm.status', '=', $request->get('status'))
                        ->orderByDesc('transaksi.created_at')->get();
                }
            }

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
                    $data = '<a href="javascript:void(0)" class="btn btn-info btn-icon-text" id="btnDetail" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-eye"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-trash-can-outline"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['aksi', 'status_pembayaran', 'status_trx'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.transaksi.transaksi');
    }

    public function detail(Request $request)
    {
        $transaksi = DB::table('detail_transaksi')->join('produk', 'produk.id', '=', 'detail_transaksi.produk_id')->where('kode_transaksi', $request->kode)->get();

        return response()->json([
            'transaksi' => $transaksi
        ]);
    }

    public function edit($id)
    {
        $transaksi = DB::table('transaksi')
            ->select('transaksi.*', 'users.name', 'users.username', 'alamat_user.alamat')
            ->join('users', 'users.id', '=', 'transaksi.user_id')
            ->join('alamat_user', 'users.alamat_user_id', '=', 'alamat_user.id')
            ->where('transaksi.id', $id)->first();

        return Response::json($transaksi);
    }

    public function destroy(Request $request)
    {
        DB::table('transaksi')->where('kode', $request->id1)->delete();
        DB::table('detail_transaksi')->where('kode_transaksi', $request->id1)->delete();

        Alert::success('Sukses', 'Transaksi Berhasil Dihapus');

        return redirect("/admin/transaksi");
    }
}
