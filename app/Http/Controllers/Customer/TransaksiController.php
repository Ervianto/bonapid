<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pengiriman;
use App\Models\PaymentMidtrains;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class TransaksiController extends Controller
{
    
    public function index()
    {
        $transaksiSelesai = Transaksi::join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->join('payment_midtrains as md', 'md.order_id', '=', 'transaksi.kode')
            ->where('transaksi.status_transaksi', 1)
            ->where('pengiriman.status_dikirim', 1)
            ->where('pengiriman.status_sampai', 1)
            ->where('md.status', 'settlement')
            ->where('transaksi.user_id', Auth::user()->id)
            ->select('transaksi.*', 'pengiriman.kurir', 'pengiriman.lama_sampai', 
                'pengiriman.status_sampai', 'pengiriman.status_dikirim', 
                \DB::raw('CONCAT("BONA","-", transaksi.id, "-", transaksi.user_id) as kode_tr'),
                'md.payment_type', 'md.status', 'md.va_number', 'md.bill_key', 'md.biller_code', 'md.payment_code',
                'md.transaction_id')
            ->orderBy('transaksi.created_at', 'DESC')
            ->get();
        $transaksiBlmSelesaipembayaran = Transaksi::join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->join('payment_midtrains as md', 'md.order_id', '=', 'transaksi.kode')
            ->where('transaksi.status_transaksi', 0)
            ->where('pengiriman.status_dikirim', 0)
            ->where('md.status', 'pending')
            ->where('transaksi.user_id', Auth::user()->id)
            ->select('transaksi.*', 'pengiriman.kurir', 'pengiriman.lama_sampai', 
                'pengiriman.status_sampai', 'pengiriman.status_dikirim', 
                \DB::raw('CONCAT("BONA","-", transaksi.id, "-", transaksi.user_id) as kode_tr'),
                'md.payment_type', 'md.status', 'md.va_number', 'md.bill_key', 'md.biller_code', 'md.payment_code', 'md.transaction_id')
            ->orderBy('transaksi.created_at', 'DESC')
            ->get();
        $transaksiPengiriman = Transaksi::join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->join('payment_midtrains as md', 'md.order_id', '=', 'transaksi.kode')
            ->where('transaksi.status_transaksi', 0)
            ->where('pengiriman.status_dikirim', 1)
            ->where('pengiriman.status_sampai', 0)
            ->where('md.status', 'settlement')
            ->where('transaksi.user_id', Auth::user()->id)
            ->select('transaksi.*', 'pengiriman.kurir', 'pengiriman.lama_sampai', 
                'pengiriman.status_sampai', 'pengiriman.status_dikirim', 
                \DB::raw('CONCAT("BONA","-", transaksi.id, "-", transaksi.user_id) as kode_tr'),
                'md.payment_type', 'md.status', 'md.va_number')
            ->orderBy('transaksi.created_at', 'DESC')
            ->get();
        return view('customer.histori', compact('transaksiSelesai', 'transaksiBlmSelesaipembayaran', 'transaksiPengiriman'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->join('payment_midtrains as md', 'md.order_id', '=', 'transaksi.kode')
            ->where('transaksi.user_id', Auth::user()->id)
            ->where('transaksi.kode', $id)
            ->select('transaksi.*', 'pengiriman.kurir', 'pengiriman.lama_sampai', 
                'pengiriman.status_sampai', 'pengiriman.status_dikirim', 
                \DB::raw('CONCAT("BONA","-", transaksi.id, "-", transaksi.user_id) as kode_tr'),
                'md.payment_type', 'md.status', 'md.va_number', 'md.bill_key', 'md.biller_code', 'md.payment_code', 'md.transaction_id',
                'md.order_id')
            ->first();
        $detailTransaksi = DetailTransaksi::join('produk', 'produk.id', '=', 'detail_transaksi.produk_id')
            ->where('detail_transaksi.kode_transaksi', $id)
            ->select('detail_transaksi.*', 'produk.nama_produk', 'produk.ukuran_produk', 'produk.variasi_produk')
            ->get();
        return view('customer.detail-transaksi', compact('transaksi', 'detailTransaksi'));
    }

    public function konfirmasi($id)
    {
        $transaksi = Transaksi::join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->join('payment_midtrains as md', 'md.order_id', '=', 'transaksi.kode')
            ->where('transaksi.user_id', Auth::user()->id)
            ->where('transaksi.kode', $id)
            ->select('transaksi.*', 'pengiriman.kurir', 'pengiriman.lama_sampai', 
                'pengiriman.status_sampai', 'pengiriman.status_dikirim', 'pengiriman.id as id_pengiriman',
                \DB::raw('CONCAT("BONA","-", transaksi.id, "-", transaksi.user_id) as kode_tr'),
                'md.payment_type', 'md.status', 'md.va_number')
            ->first();
        $detailTransaksi = DetailTransaksi::join('produk', 'produk.id', '=', 'detail_transaksi.produk_id')
            ->where('detail_transaksi.kode_transaksi', $id)
            ->select('detail_transaksi.*', 'produk.nama_produk', 'produk.ukuran_produk', 'produk.variasi_produk')
            ->get();
        return view('customer.konfirmasi-barang-sampai', compact('transaksi', 'detailTransaksi'));
    }

    public function konfirmasiBarangSampai(Request $request, $id)
    {
        $pengiriman = Pengiriman::where('kode_transaksi', $id)->first();
        $pengiriman->status_sampai = 1;
        if(isset($request->keterangan)){
            $pengiriman->keterangan = $request->keterangan;
        }
        $pengiriman->save();
        Transaksi::where('kode', $id)->update([
            'status_transaksi' => 1
        ]);
        Alert::success('Sukses', 'Terimakasih sudah berbelanja pada toko kami');
        return redirect()->back();
    }

    public function konfirmasiPembayaran($orderId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/" . $orderId . "/status",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => [
                "Authorization: Basic U0ItTWlkLXNlcnZlci1IUXhPSHZldE5YQzJDaVVGazdybXVkTmU=",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            Alert::error('Error', 'Konfirmasi Pembayaran Gagal');
            return redirect()->back();
        } else {
            $data = json_decode($response, true);
            PaymentMidtrains::where('order_id', $orderId)->update([
                'status' => $data['transaction_status']
            ]);
            Alert::success('Sukses', 'Konfirmasi Pembayaran Berhasil');
            return redirect()->back();
        }
    }

}
