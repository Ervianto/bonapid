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

class PreOrderController extends Controller
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
                $pre_order = DB::table('pre_order')
                    ->select('pre_order.*', 'users.name')
                    ->join('users', 'users.id', '=', 'pre_order.user_id')
                    ->whereBetween('pre_order.created_at', [$request->get('tgl_awal'), $request->get('tgl_akhir')])
                    ->orderByDesc('pre_order.created_at')->get();
            } else {
                $pre_order = DB::table('pre_order')
                    ->select('pre_order.*', 'users.name')
                    ->join('users', 'users.id', '=', 'pre_order.user_id')
                    ->orderByDesc('pre_order.created_at')->get();
            }

            return DataTables::of($pre_order)
                ->addColumn('st', function ($row) {
                    if ($row->status == "0") {
                        $data = '<a href="javascript:void(0)" class="btn btn-success btn-icon-text" id="btnVerif" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-send"></i> Verifikasi</a>
                                            <meta name="csrf-token" content="{{ csrf_token() }}"><br>
                                <a href="javascript:void(0)" class="btn btn-danger btn-icon-text mt-1" id="btnTolak" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-bookmark-remove"></i> Tolak</a>
                                            <meta name="csrf-token" content="{{ csrf_token() }}">';
                    }else if ($row->status == "1") {   
                        $data = 'Terverifikasi & Menunggu Pembayaran';
                    }else if ($row->status == "2") {   
                        $data = 'Terverifikasi & Terbayar';
                    }else if ($row->status == "3") {   
                        $data = 'Dibatalkan';
                    }else if ($row->status == "4") {   
                        $data = 'Ditolak';
                    }
                    return $data;
                })
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-info btn-icon-text" id="btnDetail" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-eye"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-trash-can-outline"></i></a>
                    <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['st', 'aksi'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.transaksi.preorder');
    }

    public function detail(Request $request)
    {
        $detail = DB::table('detail_pre_order')->join('produk', 'produk.id', '=', 'detail_pre_order.produk_id')->where('detail_pre_order.pre_order_kode', $request->kode_pesanan)->get();

        return response()->json([
            'detail' => $detail
        ]);
    }

    public function edit($id)
    {
        $pre_order = DB::table('pre_order')
            ->select('pre_order.*', 'users.name', 'users.username', 'alamat_user.alamat')
            ->join('users', 'users.id', '=', 'pre_order.user_id')
            ->join('alamat_user', 'users.alamat_user_id', '=', 'alamat_user.id')
            ->where('pre_order.id', $id)->first();

        return Response::json($pre_order);
    }

    public function update(Request $request)
    {
        if($request->action=="verif"){
            DB::table('pre_order')->where('id', $request->id1)->update([
                'status'     => '1'
            ]);
        }else{
            DB::table('pre_order')->where('id', $request->id1)->update([
                'status'     => '4'
            ]);
        }

        Alert::success('Sukses', 'Data Berhasil Diupdate');

        return redirect("/admin/preorder");
    }

    public function destroy(Request $request)
    {
        DB::table('pre_order')->where('kode_pesanan', $request->id2)->delete();
        DB::table('detail_pre_order')->where('pre_order_kode', $request->id2)->delete();

        Alert::success('Sukses', 'Data Berhasil Dihapus');

        return redirect("/admin/preorder");
    }
}
