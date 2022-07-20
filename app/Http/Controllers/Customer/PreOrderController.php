<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PreOrder;
use App\Models\DetPreOrder;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\AlamatUser;
use App\Models\AlamatToko;
use App\Models\PaymentMidtrains;
use App\Models\DetailTransaksi;
use App\Models\Pengiriman;
use Alert;

class PreOrderController extends Controller
{
    
    public function index()
    {
        $preOrder = PreOrder::where('user_id', \Auth::user()->id)->get();
        return view('customer.pre-order', compact('preOrder'));
    }

    public function create()
    {
        $produk = Produk::join('kategori as kt', 'kt.id', '=', 'produk.kategori_id')
            ->where('produk.status', '1')
            ->select('produk.*', 'kt.nama_kategori')
            ->get();
        $kodePesanan = app('request')->session()->get('kode_pesanan');
        $detPreOrder = DetPreOrder::join('produk as pr', 'pr.id', '=', 'detail_pre_order.produk_id')
            ->where('detail_pre_order.pre_order_kode', $kodePesanan)
            ->select('detail_pre_order.*', 'pr.harga_produk', 'pr.nama_produk')
            ->where('detail_pre_order.user_id', \Auth::user()->id)->get();
        return view('customer.create-pre-order', compact('detPreOrder', 'produk', 'kodePesanan'));
    }

    public function show($kode)
    {
        $preOrder = PreOrder::where('kode_pesanan', $kode)->first();
        $detPreOrder = DetPreOrder::join('produk as pr', 'pr.id', '=', 'detail_pre_order.produk_id')
            ->where('detail_pre_order.pre_order_kode', $kode)
            ->select('detail_pre_order.*', 'pr.harga_produk', 'pr.nama_produk')
            ->where('detail_pre_order.user_id', \Auth::user()->id)->get();
        return view('customer.show-pre-order', compact('detPreOrder', 'preOrder'));
    }

    public function store(Request $request)
    {
       $kodePesanan = app('request')->session()->get('kode_pesanan');
       if(!app('request')->session()->has('kode_pesanan')){
           $count = PreOrder::count();
           $count = $count + 1;
           $kodePesanan = app('request')->session()->put('kode_pesanan', 'BONA-PRDR-'.$count.\Auth::user()->id);
       }
       $produk = Produk::find($request->produk_id);
       $detPreOrder = new DetPreOrder();
       $detPreOrder->pre_order_kode = $kodePesanan;
       $detPreOrder->user_id = \Auth::user()->id;
       $detPreOrder->produk_id = $request->produk_id;
       $detPreOrder->qty = $request->qty;
       $detPreOrder->variasi = $request->variasi;
       $detPreOrder->harga = $produk->harga_produk;
       $detPreOrder->ukuran = $request->ukuran;
       
        $imageName = time() . $request->file('foto')->getClientOriginalName();
        $request->foto->move(public_path('foto/pre_order'), $imageName);
        $detPreOrder->foto = $imageName;
       
       $detPreOrder->keterangan = $request->keterangan;
       $detPreOrder->save();
       Alert::success('Sukses', 'Berhasil menambahkan produk pre order');
       return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $detPreOrder = DetPreOrder::find($id);
        $detPreOrder->qty = $request->qty;
        $detPreOrder->variasi = $request->variasi;
        $detPreOrder->ukuran = $request->ukuran;
        $detPreOrder->keterangan = $request->keterangan;
        if($request->hasFile('foto')){
            $imageName = time() . $request->file('foto')->getClientOriginalName();
            $request->foto->move(public_path('foto/pre_order'), $imageName);
            $detPreOrder->foto = $imageName;
        }
        $detPreOrder->save();
        Alert::success('Sukses', 'Berhasil mengubah produk pre order');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $detPreOrder = DetPreOrder::find($id);
        $detPreOrder->delete();
        Alert::success('Sukses', 'Berhasil menghapus produk pre order');
        return redirect()->back();
    }

    public function finishOrder()
    {
        $kodePesanan = app('request')->session()->get('kode_pesanan');
        $sumTotal = DetPreOrder::where('pre_order_kode', $kodePesanan)
            ->select(\DB::raw('SUM((harga * qty)) as total'))
            ->groupBy('pre_order_kode')
            ->first();
        $preOrder = new PreOrder();
        $preOrder->kode_pesanan = $kodePesanan;
        $preOrder->total = $sumTotal->total;
        $preOrder->user_id = \Auth::user()->id;
        $preOrder->status = 0;
        $preOrder->save();
        app('request')->session()->forget('kode_pesanan');
        Alert::success('Sukses', 'Berhasil melakukan pre order');
        return redirect('pre-order');
    }

    public function batalPreOrder($id_pre_order)
    {
        $preOrder = PreOrder::find($id_pre_order);
        $preOrder->status = 3;
        $preOrder->save();
        Alert::success('Sukses', 'Berhasil melakukan pembatalan pre order');
        return redirect('pre-order');
    }

    public function billingPreOrder(Request $request)
    {
        $kode = $request->kode_pesanan;
        $alamatUser = AlamatUser::find(\Auth::user()->alamat_user_id);
        $alamatToko = AlamatToko::first();
        $preOrder = PreOrder::where('kode_pesanan', $kode)->first();
        $detPreOrder = DetPreOrder::join('produk as pr', 'pr.id', '=', 'detail_pre_order.produk_id')
            ->where('detail_pre_order.pre_order_kode', $kode)
            ->select('detail_pre_order.*', 'pr.harga_produk', 'pr.nama_produk', 'pr.berat_produk')
            ->where('detail_pre_order.user_id', \Auth::user()->id)->get();
        return view('customer.billing-address-pre-order', compact('alamatUser', 'alamatToko', 'detPreOrder', 'preOrder'));
    }

    public function bayarSekarang(Request $request)
    {
        \Midtrans\Config::$serverKey = "SB-Mid-server-HQxOHvetNXC2CiUFk7rmudNe";
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $kodePesanan = $request->kode_pesanan;

        $detPreOrder = DetPreOrder::join('produk as pr', 'pr.id', '=', 'detail_pre_order.produk_id')
            ->where('detail_pre_order.pre_order_kode', $kodePesanan)
            ->select('detail_pre_order.*', 'pr.harga_produk', 'pr.nama_produk', 'pr.berat_produk')
            ->where('detail_pre_order.user_id', \Auth::user()->id)->get();
        $itemDetails = [];
        $total = 0;
        foreach($detPreOrder as $row){
            $total = $total + ($row->harga * $row->qty);
            array_push($itemDetails, [
                'id' => $row->produk_id,
                'name' => $row->nama_produk,
                'price' => $row->harga,
                'quantity' => $row->qty
            ]);
        }

        $jasaOngkir = $request->jasa_ongkir;
        $kurir = $request->kurir;
        $lamaSampai = $request->lama_sampai;

        array_push($itemDetails, [
            'id' => 'ongkir123',
            'name' => 'JASA ONGKIR '.$kurir,
            'price' => $jasaOngkir,
            'quantity' => 1
        ]);

        $kode = \Str::random(16);
        $params = array(
            'transaction_details' => array(
                'order_id' => $kode,
                'gross_amount' => $total + $jasaOngkir,
            ),
            "item_details" => $itemDetails,
            'customer_details' => array(
                'first_name' => \Auth::user()->name,
                'last_name' => '-',
                'email' => \Auth::user()->email,
                'phone' => \Auth::user()->telepon,
            ),
        );
         
        $snapToken = \Midtrans\Snap::getSnapToken($params); 
        return view('customer.pembayaran-pre-order', compact('detPreOrder', 'snapToken', 'jasaOngkir', 'kodePesanan', 'total','kurir', 'lamaSampai'));
    }

    public function paymentProsess(Request $request)
    {
        \DB::transaction(function() use ($request) {

            $kodePesanan = $request->kode_pesanan;
            
            $json = json_decode($request->json);
            $order = new PaymentMidtrains();
            $order->status = $json->transaction_status;
            $order->transaction_id = $json->transaction_id;
            $order->order_id = $json->order_id;
            $order->gross_amount = $json->gross_amount;
            $order->payment_type = $json->payment_type;
            $order->payment_code = isset($json->payment_code) ? $json->payment_code : null;
            $order->pdf_url = isset($json->pdf_url) ? $json->pdf_url : null;
            $order->userId = \Auth::user()->id;
            if($json->payment_type == 'bank_transfer'){
                $order->va_number = json_encode($json->va_numbers);
            }
            if($json->payment_type == 'echannel'){
                $order->bill_key = $json->bill_key;
                $order->biller_code = $json->biller_code;
            }
            $order->save();

            $preOrder = PreOrder::where('kode_pesanan', $kodePesanan)->first();

            Transaksi::create([
                "kode" => $json->order_id,
                "user_id" => \Auth::user()->id,
                "total_transaksi" => $json->gross_amount,
                "status_transaksi" => 0,
                "tipe" => "pre_order",
                "jasa_ongkir" => ($json->gross_amount - $preOrder->total),
            ]);
    
            $detPreOrder = DetPreOrder::join('produk as pr', 'pr.id', '=', 'detail_pre_order.produk_id')
                ->where('detail_pre_order.pre_order_kode', $kodePesanan)
                ->select('detail_pre_order.*', 'pr.harga_produk', 'pr.nama_produk', 'pr.berat_produk')
                ->where('detail_pre_order.user_id', \Auth::user()->id)->get();
            foreach($detPreOrder as $row){
                DetailTransaksi::create([
                    "kode_transaksi" => $json->order_id,
                    "produk_id" => $row->produk_id,
                    "qty" => $row->qty,
                    "harga_produk" => $row->harga
                ]);

                $produk = Produk::find($row->produk_id);
                $produk->stok_produk = ($produk->stok_produk - $row->qty);
                $produk->save();
            }

            Pengiriman::create([
                "kode_transaksi" => $json->order_id,
                "status_dikirim" => 0,
                "status_sampai" => 0,
                "kurir" => $request->kurir,
                "lama_sampai" => $request->lama_sampai
            ]);

            PreOrder::where('kode_pesanan', $kodePesanan)->update([
                'status' => 2
            ]);
    
            // Pembayaran::create([
            //     "kode_transaksi" => $json->order_id,
            //     "bank_id" => $request->bank_id,
            //     "user_id" => Auth::user()->id
            // ]);
    
            // ButiTransfer::create([
            //     'kode_transaksi' => $json->order_id,
            //     "is_verified" => 0
            // ]);
    
        });
        return redirect('customer-transaksi')->with('success', 'Berhasil melakukan pembayaran transaksi pre order');
    }


}
