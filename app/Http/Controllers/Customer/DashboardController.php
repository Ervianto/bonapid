<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Review;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tglNow = Carbon::now()->format('Y-m-d');
        $events = Event::where('is_active', 1)
            ->get();
        if($request->search != ''){
            $produk = Produk::with('category')->where('status', '1')
                ->where('nama_produk', 'like', '%'.$request->search.'%')
                ->paginate(10);
        }else{
            $produk = Produk::with('category')->where('status', '1')->paginate(10);
        }
        return view('customer.dashboard.home', compact('produk', 'events'));
    }

    public function detailProduk($id)
    {
        $produk = Produk::with('category', 'detailProduk')->find($id);
        $reviews = Review::join('users as u', 'u.id', '=', 'review.user_id')
            ->join('produk as p', 'p.id', '=', 'review.produk_id')
            ->where('review.produk_id', $id)
            ->select('review.*', 'u.name')
            ->get();
        $jumlahReview = Review::join('users as u', 'u.id', '=', 'review.user_id')
            ->join('produk as p', 'p.id', '=', 'review.produk_id')
            ->where('review.produk_id', $id)
            ->count();
        $jumlahBintang =  Review::join('users as u', 'u.id', '=', 'review.user_id')
            ->join('produk as p', 'p.id', '=', 'review.produk_id')
            ->selectRaw('SUM(review.bintang) as rating')
            ->where('review.produk_id', $id)
            ->groupBy('review.produk_id')
            ->first();
        if (Auth::check()) {
            $review = Review::where('review.produk_id', $id)
                ->where('review.user_id', Auth::user()->id)
                ->first();
        } else {
            $review = null;
        }
        return view('customer.detail-produk', compact('produk', 'reviews', 'review', 'jumlahReview', 'jumlahBintang'));
    }

    public function storeReview(Request $request)
    {
        if ($request->review_id != "") {
            $review = Review::find($request->review_id);
            $message = "Berhasil menambahkan review";
        } else {
            $review = new Review();
            $message = "Berhasil mengubah review";
        }
        $review->produk_id = $request->produk_id;
        $review->user_id = Auth::user()->id;
        $review->bintang = $request->bintang;
        $review->ulasan = $request->ulasan;
        if ($request->hasFile('foto')) {
            $imageName = time() . $request->file('foto')->getClientOriginalName();
            $request->foto->move(public_path('foto/review'), $imageName);
            $review->foto = $imageName;
        }
        $review->save();
        Alert::success('Sukses', $message);
        return redirect()->back();
    }

    public function deleteReview($review_id)
    {
        $review = Review::find($review_id);
        $review->delete();
        Alert::success('Sukses', 'Berhasil menghapus review');
        return redirect()->back();
    }
}
