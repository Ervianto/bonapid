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
use App\Models\Province;

class AlamatTokoController extends Controller
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
        $provinces = Province::all();
        return view('admin.informasi.alamat-toko', compact('provinces'));
    }

    public function update(Request $request)
    {
        DB::table('alamat_toko')->where('id', $request->id)->update([
            'province_id'     => $request->province_id,
            'city_id'     => $request->city_id,
            'kode_pos'     => $request->kode_pos,
            'alamat'     => $request->alamat,
            'updated_at'    => \Carbon\Carbon::now()
        ]);

        Alert::success('Sukses', 'Alamat Toko Berhasil Diupdate');
        return redirect("/admin/alamat-toko");
    }

    public function edit($id)
    {
        $alamat_toko = DB::table('alamat_toko')
            ->where('id', $id)->first();

        return Response::json($alamat_toko);
    }
}
