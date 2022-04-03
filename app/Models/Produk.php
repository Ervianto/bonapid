<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\DetailProduk;

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
        "berat_produk",
        "variasi_produk",
        "foto_produk",
        "deskripsi_produk"
    ];

    public function category()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detailProduk()
    {
        return $this->hasMany(DetailProduk::class, 'produk_id');
    }
}
