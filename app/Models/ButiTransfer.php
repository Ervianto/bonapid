<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButiTransfer extends Model
{
    use HasFactory;
    protected $table = "buti_transfer";
    protected $fillable = [
        "kode_transaksi",
        "bukti_transfer",
        "is_verified"
    ];
}
