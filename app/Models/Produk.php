<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = [
        "kategori_id",
        "nama_produk",
        "stok_produk",
        "harga_produk",
        "ukuran_produk",
        "variasi_produk",
        "foto_produk",
        "deskripsi_produk"
    ];
}
