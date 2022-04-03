<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    protected $table = "pengiriman";
    protected $fillable = [
        "kode_transaksi",
        "status_dikirim",
        "status_sampai",
        "kurir",
        "lama_sampai"
    ];
}
