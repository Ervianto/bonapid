<?php 

use App\Models\Review;

function getRating($produkId) {
    $jumlahBintang =  Review::join('users as u', 'u.id', '=', 'review.user_id')
        ->join('produk as p', 'p.id', '=', 'review.produk_id')
        ->select(DB::raw('SUM(review.bintang) as rating'), DB::raw('COUNT(review.id) as jumlah'))
        ->where('review.produk_id', $produkId)
        ->groupBy('review.produk_id')
        ->first();
    return $jumlahBintang;
}

function getBalasanAdmin($reviewId) {
    $balasan = \DB::table('balas_review')->where('review_id', $reviewId)->first();
    return $balasan;
}