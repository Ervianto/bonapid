<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = "transaksi";
    protected $fillable = [
        "kode",
        "user_id",
        "total_transaksi",
        "pesanan_id",
        "status_transaksi",
        "tipe",
        "jasa_ongkir",
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'kode_transaksi');
    }

    public function getPembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'kode_transaksi');
    }
}
