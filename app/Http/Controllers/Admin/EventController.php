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

class EventController extends Controller
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
            $event = DB::table('event')
                ->orderBy('nama_event')->get();

            return DataTables::of($event)
                ->addColumn('status', function ($row) {
                    if ($row->is_active == '1') {
                        $data = '<input type="checkbox" id="cbStatus" class="checkbox status" data-id="' . $row->id . '" checked> Aktif';
                    } else {
                        $data = '<input type="checkbox" id="cbStatus" class="checkbox status" data-id="' . $row->id . '"> Aktif';
                    }
                    return $data;
                })
                ->addColumn('foto', function ($row) {
                    $data = '<a href="http://localhost/ecommerce/public/foto/events/' . $row->foto_event . '" target="_blank"><img src="http://localhost/ecommerce/public/foto/events/' . $row->foto_event . '" width="300px"></img></a>';
                    return $data;
                })
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-warning btn-icon-text" id="btnEdit" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-pencil-box"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-trash-can-outline"></i></a>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->rawColumns(['aksi', 'status', 'foto'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.informasi.event');
    }

    public function store(Request $request)
    {
        $file = $request->file('foto_event');
        if ($file == "") {
            $nama_file = "";
        } else {
            $file->move(public_path('foto/events'), $file->getClientOriginalName());
            $nama_file = $file->getClientOriginalName();
        }

        if ($request->action == 'tambah') {

            DB::table('event')->insert([
                'nama_event'     => $request->nama_event,
                'foto_event'    => $nama_file,
                'isi_event'    => $request->isi_event,
                'tanggal_mulai_event'    => $request->tanggal_mulai_event,
                'tanggal_selesai_event'    => $request->tanggal_selesai_event,
                'is_active'    => '0',
                'created_at'    => \Carbon\Carbon::now()
            ]);

            Alert::success('Sukses', 'Event Berhasil Ditambah');
            return redirect("/admin/event");
        } else if ($request->action == 'edit') {

            if ($request->file('foto_event') == "") {
                DB::table('event')->where('id', $request->id)->update([
                    'nama_event'     => $request->nama_event,
                    'isi_event'    => $request->isi_event,
                    'tanggal_mulai_event'    => $request->tanggal_mulai_event,
                    'tanggal_selesai_event'    => $request->tanggal_selesai_event,
                    'updated_at'    => \Carbon\Carbon::now()
                ]);
            } else {
                DB::table('event')->where('id', $request->id)->update([
                    'nama_event'     => $request->nama_event,
                    'foto_event'    => $nama_file,
                    'isi_event'    => $request->isi_event,
                    'tanggal_mulai_event'    => $request->tanggal_mulai_event,
                    'tanggal_selesai_event'    => $request->tanggal_selesai_event,
                    'updated_at'    => \Carbon\Carbon::now()
                ]);
            }

            Alert::success('Sukses', 'Event Berhasil Diedit');
            return redirect("/admin/event");
        }
    }

    public function edit($id)
    {
        $event = DB::table('event')
            ->where('id', $id)->first();

        return Response::json($event);
    }

    public function destroy(Request $request)
    {
        DB::table('event')->where('id', $request->id1)->delete();

        Alert::success('Sukses', 'Event Berhasil Dihapus');

        return redirect("/admin/event");
    }

    public function update(Request $request)
    {
        DB::table('event')->where('id', $request->id)->update([
            'is_active'     => $request->is_active
        ]);

        return redirect("/admin/event");
    }
}
