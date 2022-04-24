<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
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
                'md.payment_type', 'md.status', 'md.va_number')
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
                'md.payment_type', 'md.status', 'md.va_number')
            ->orderBy('transaksi.created_at', 'DESC')
            ->get();
        $transaksiPengiriman = Transaksi::join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->join('payment_midtrains as md', 'md.order_id', '=', 'transaksi.kode')
            ->where('transaksi.status_transaksi', 0)
            ->where('pengiriman.status_dikirim', 0)
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
                'md.payment_type', 'md.status', 'md.va_number')
            ->first();
        $detailTransaksi = DetailTransaksi::join('produk', 'produk.id', '=', 'detail_transaksi.produk_id')
            ->where('detail_transaksi.kode_transaksi', $id)
            ->select('detail_transaksi.*', 'produk.nama_produk', 'produk.ukuran_produk', 'produk.variasi_produk')
            ->get();
        return view('customer.detail-transaksi', compact('transaksi', 'detailTransaksi'));
    }

}
