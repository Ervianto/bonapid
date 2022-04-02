<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('customer.cart.index');
    }

    public function edit($id)
    {
    }

    public function tambah()
    {
    }

    public function hapus()
    {
    }
}
