<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        $produk = Produk::with('category')->where('status', '1')->get();
        return view('customer.dashboard.home', compact('produk'));
    }

    public function detailProduk($id)
    {
        $produk = Produk::with('category', 'detailProduk')->find($id);
        return view('customer.detail-produk', compact('produk'));
    }
}
