<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Auth;

class TransaksiController extends Controller
{
    
    public function index()
    {
        $transaksiSelesai = Transaksi::join('pembayaran', 'pembayaran.kode_transaksi', '=', 'transaksi.kode')
            ->join('bank', 'bank.id', '=', 'pembayaran.bank_id')
            ->join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->join('buti_transfer', 'buti_transfer.kode_transaksi', '=', 'transaksi.kode')
            ->where('transaksi.status_transaksi', 1)
            ->where('buti_transfer.is_verified', 1)
            ->where('pengiriman.status_dikirim', 1)
            ->where('pengiriman.status_sampai', 1)
            ->where('transaksi.user_id', Auth::user()->id)
            ->select('transaksi.*', 'bank.nama_bank', 'bank.no_rekening', 'pengiriman.kurir', 
                'pengiriman.lama_sampai', 'pengiriman.status_sampai', 'pengiriman.status_dikirim', \DB::raw('CONCAT("BONA","-", transaksi.id, "-", transaksi.user_id) as kode_tr'),
                'buti_transfer.is_verified')
            ->orderBy('transaksi.created_at', 'DESC')
            ->get();
        $transaksiBlmSelesaipembayaran = Transaksi::join('pembayaran', 'pembayaran.kode_transaksi', '=', 'transaksi.kode')
            ->join('bank', 'bank.id', '=', 'pembayaran.bank_id')
            ->join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->join('buti_transfer', 'buti_transfer.kode_transaksi', '=', 'transaksi.kode')
            ->where('transaksi.status_transaksi', 0)
            ->where('buti_transfer.is_verified', 0)
            ->where('pengiriman.status_dikirim', 0)
            ->where('transaksi.user_id', Auth::user()->id)
            ->select('transaksi.*', 'bank.nama_bank', 'bank.no_rekening', 'pengiriman.kurir', 
                'pengiriman.lama_sampai', 'pengiriman.status_sampai', 'pengiriman.status_dikirim', \DB::raw('CONCAT("BONA","-", transaksi.id, "-", transaksi.user_id) as kode_tr'),
                'buti_transfer.is_verified', 'buti_transfer.bukti_transfer')
            ->orderBy('transaksi.created_at', 'DESC')
            ->get();
        $transaksiPengiriman = Transaksi::join('pembayaran', 'pembayaran.kode_transaksi', '=', 'transaksi.kode')
            ->join('bank', 'bank.id', '=', 'pembayaran.bank_id')
            ->join('pengiriman', 'pengiriman.kode_transaksi', '=', 'transaksi.kode')
            ->join('buti_transfer', 'buti_transfer.kode_transaksi', '=', 'transaksi.kode')
            ->where('transaksi.status_transaksi', 0)
            ->where('buti_transfer.is_verified', 1)
            ->where('pengiriman.status_dikirim', 1)
            ->where('transaksi.user_id', Auth::user()->id)
            ->select('transaksi.*', 'bank.nama_bank', 'bank.no_rekening', 'pengiriman.kurir', 
                'pengiriman.lama_sampai', 'pengiriman.status_sampai', 'pengiriman.status_dikirim', \DB::raw('CONCAT("BONA","-", transaksi.id, "-", transaksi.user_id) as kode_tr'),
                'buti_transfer.is_verified')
            ->orderBy('transaksi.created_at', 'DESC')
            ->get();
        return view('customer.histori', compact('transaksiSelesai', 'transaksiBlmSelesaipembayaran', 'transaksiPengiriman'));
    }

}
