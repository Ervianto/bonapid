@extends('layouts.landing')
@section('content')
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <h1>Karanjang Produk</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cart-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead class="cart-table-head">
                            <tr class="table-head-row">
                                <th class="product-remove"></th>
                                <th class="product-image">Foto</th>
                                <th class="product-name">Nama Produk</th>
                                <th class="product-price">Berat</th>
                                <th class="product-price">Harga</th>
                                <th class="product-quantity">Qty</th>
                                <th class="product-quantity">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                            <tr class="table-body-row">
                                <td class="product-remove">
                                    <form action="{{ route('customer-cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        {{ method_field('delete') }}
                                        <button type="submit" class="btn btn-danger text-white">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    </form>
                                </td>
                                <td class="product-image"><img src="{{ asset('foto/produk/'.$item->attributes->image) }}" alt=""></td>
                                <td class="product-name">{{ $item->name }}</td>
                                <td class="product-name">{{ $item->attributes->weight }} gram</td>
                                <td class="product-price">{{ rupiah($item->price) }}</td>
                                <td class="product-quantity p-2">
                                    <form action="{{ route('customer-cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        {{ method_field('put') }}
                                        <div class="input-group mb-3">
                                            <input type="number" name="jumlahProduk" class="form-control" placeholder="0" value="{{ $item->quantity }}">
                                            <div class="input-group-append">
                                              <button type="submit" class="btn btn-warning">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="product-price">{{ rupiah($item->price * $item->quantity ) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="product-name">Sub Total</td>
                                <td class="product-price">{{ rupiah(Cart::getTotal())  }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row justify-content-end mt-3">
                        <a href="{{ url('checkout') }}" class="boxed-btn black">Check Out</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection