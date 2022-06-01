<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $produk = Produk::with('category')->get();
        return view('customer.dashboard.home', compact('produk'));
    }

    public function detailProduk($id)
    {
        $produk = Produk::with('category', 'detailProduk')->find($id);
        $reviews = Review::join('users as u', 'u.id', '=', 'review.user_id')
            ->join('produk as p', 'p.id', '=', 'review.produk_id')
            ->where('review.user_id', Auth::user()->id)
            ->where('review.produk_id', $id)
            ->select('review.*', 'u.name')
            ->get();
        return view('customer.detail-produk', compact('produk', 'reviews'));
    }

    public function storeReview(Request $request)
    {
        $review = new Review();
        $review->produk_id = $request->produk_id;
        $review->user_id = Auth::user()->id;
        $review->bintang = $request->bintang;
        $review->ulasan = $request->ulasan;
        if($request->hasFile('foto')){
            $imageName = time() . $request->file('foto')->getClientOriginalName();
            $request->foto->move(public_path('foto/review'), $imageName);
            $review->foto = $imageName;
        }
        $review->save();
        return redirect()->back();
    }

}
