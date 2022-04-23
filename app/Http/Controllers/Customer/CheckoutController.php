<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlamatToko;
use App\Models\AlamatUser;
use App\Models\Bank;
use App\Models\Province;
use App\Models\City;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\ButiTransfer;
use App\Models\Pengiriman;
use App\Models\Pembayaran;
use App\Models\PaymentMidtrains;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Illuminate\Support\Str;
use Auth;

class CheckoutController extends Controller
{

    public function check_ongkir(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $request->city_origin, // ID kota/kabupaten asal
            'destination'   => $request->city_destination, // ID kota/kabupaten tujuan
            'weight'        => $request->weight, // berat barang dalam gram
            'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();
        return response()->json(["data" => $cost]);
    }
    
    public function index(Request $request)
    {
        $alamatUser = AlamatUser::find(Auth::user()->alamat_user_id);
        $alamatToko = AlamatToko::first();
        $bank = Bank::all();
        $cart = \Cart::getContent();
        return view('customer.billing-address', compact('alamatUser', 'alamatToko', 'cart', 'bank'));
    }

    public function bayarSekarang(Request $request)
    {
        // \Midtrans\Config::$serverKey = config('global.MIDTRAINS_SERVER_KEY');
        \Midtrans\Config::$serverKey = env('MIDTRAINS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $cart = \Cart::getContent();
        $itemDetails = [];
        foreach($cart as $row){
            array_push($itemDetails, [
                'id' => $row->id,
                'name' => $row->name,
                'price' => $row->price,
                'quantity' => $row->quantity
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

        $kode = Str::random(16);
        $params = array(
            'transaction_details' => array(
                'order_id' => $kode,
                'gross_amount' => \Cart::getTotal() + $jasaOngkir,
            ),
            "item_details" => $itemDetails,
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'last_name' => '-',
                'email' => Auth::user()->email,
                'phone' => Auth::user()->telepon,
            ),
        );
         
        $snapToken = \Midtrans\Snap::getSnapToken($params); 
        return view('customer.pembayaran', compact('cart', 'snapToken', 'jasaOngkir', 'kurir', 'lamaSampai'));
    }

    public function paymentProsess(Request $request)
    {
        $json = json_decode($request->json);
        $order = new PaymentMidtrains();
        $order->status = $json->transaction_status;
        $order->transaction_id = $json->transaction_id;
        $order->order_id = $json->order_id;
        $order->gross_amount = $json->gross_amount;
        $order->payment_type = $json->payment_type;
        $order->payment_code = isset($json->payment_code) ? $json->payment_code : null;
        $order->pdf_url = isset($json->pdf_url) ? $json->pdf_url : null;
        $order->userId = Auth::user()->id;
        $order->save();
    }

    public function checkout(Request $request)
    {
        $kode = Str::random(16);
        Transaksi::create([
            "kode" => $kode,
            "user_id" => Auth::user()->id,
            "total_transaksi" => \Cart::getTotal() + $request->jasa_ongkir,
            "status_transaksi" => 0,
            "jasa_ongkir" => $request->jasa_ongkir,
        ]);

        $cart = \Cart::getContent();
        foreach($cart as $row){
            DetailTransaksi::create([
                "kode_transaksi" => $kode,
                "produk_id" => $row->id,
                "qty" => $row->quantity,
                "harga_produk" => $row->price
            ]);
        }

        Pembayaran::create([
            "kode_transaksi" => $kode,
            "bank_id" => $request->bank_id,
            "user_id" => Auth::user()->id
        ]);

        Pengiriman::create([
            "kode_transaksi" => $kode,
            "status_dikirim" => 0,
            "status_sampai" => 0,
            "kurir" => $request->kurir,
            "lama_sampai" => $request->lama_sampai
        ]);

        ButiTransfer::create([
            'kode_transaksi' => $kode,
            "is_verified" => 0
        ]);

        \Cart::clear();

        return redirect('customer-transaksi')->with('success', 'Berhasil melakukan checkout');

    }

}
