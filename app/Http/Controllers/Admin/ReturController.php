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

class ReturController extends Controller
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
                    ->select('pengiriman.*', 'users.name', 'transaksi.id as id_trx', 'transaksi.created_at as tgl_trx')
                    ->join('transaksi', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
                    ->join('users', 'users.id', '=', 'transaksi.user_id')
                    ->where('pengiriman.status_sampai','=','2')
                    ->whereBetween('transaksi.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->orderByDesc('transaksi.created_at')->get();
            } else {
                $transaksi = DB::table('pengiriman')
                    ->select('pengiriman.*', 'users.name', 'transaksi.id as id_trx', 'transaksi.created_at as tgl_trx')
                    ->join('transaksi', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
                    ->join('users', 'users.id', '=', 'transaksi.user_id')
                    ->where('pengiriman.status_sampai','=','2')
                    ->orderByDesc('transaksi.created_at')->get();
            }

            return DataTables::of($transaksi)
                ->addColumn('video', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-primary btn-icon-text" id="btnRetur" data-toggle="modal" data-id="' . $row->id . '">Lihat</a>';
                    return $data;
                })
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-info btn-icon-text" id="btnDetail" data-toggle="modal" data-id="' . $row->id_trx . '"><i class="mdi mdi-eye"></i></a>';
                    return $data;
                })
                ->rawColumns(['video', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.transaksi.retur');
    }
}
