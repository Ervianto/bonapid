<?php

use App\Models\DetailProduk;

function getFotoProduk($produkId) {
    $produk = DetailProduk::where('produk_id', $produkId)
        ->select('foto_produk')->get();
    return $produk;
}

function getFotoSingleProduk($produkId) {
    $produk = DetailProduk::where('produk_id', $produkId)
        ->select('foto_produk')->first();
    return $produk->foto_produk;
}