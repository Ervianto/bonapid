<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        "jasa_ongkir",
    ];
}
