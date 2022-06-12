@extends('layouts.landing')
@section('content')
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <h1>About</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
use App\Models\AlamatToko;

$alamat = AlamatToko::join('provinces as prov', 'prov.id', '=', 'alamat_toko.province_id')
    ->join('cities as city', 'city.id', '=', 'alamat_toko.city_id')
    ->select('alamat_toko.kode_pos', 'alamat_toko.alamat', 'prov.name as nama_provinsi', 'city.name as kota')
    ->first();
?>

<div class="cart-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-body text-center">
                    <h5 class="mb-1">TOKO BONAFIDE</h5>
                    <img src="{{asset('assets/images/logo-full.png')}}" height="100" alt="">
                    <h4 class="text-center"><span class="fa fa-map-marker"></span> {{ $alamat->kode_pos.', '.$alamat->alamat.', '.$alamat->kota.', '.$alamat->nama_provinsi }}</h4>
                    <p class="text-center">
                        <br> Telp. : (0354) 2810000, 2810001, 2810008
                        <br> Fax. : (0354) 2810000

                        <br> Email : email@email.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection