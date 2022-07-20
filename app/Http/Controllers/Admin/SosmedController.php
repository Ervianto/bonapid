<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Response;
use Validator;
use Illuminate\Support\Facades\Auth;
use PDF;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;

class SosmedController extends Controller
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
        return view('admin.master.sosmed');
    }
    
    public function edit()
    {
        $sosmed = DB::table('sosmed')->limit(1)->first();

        return Response::json($sosmed);
    }

    public function update(Request $request)
    {
            DB::table('sosmed')->where('id', $request->id)->update([
                'fb'     => $request->fb,
                'ig'     => $request->ig,
                'wa'     => $request->wa
            ]);
            
        Alert::success('Sukses', 'Sosmed Berhasil Diupdate');
        return redirect()->back();
    }
}
