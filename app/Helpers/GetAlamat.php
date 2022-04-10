<?php

use App\Models\AlamatUser;
use App\Models\AlamatToko;
use App\Models\City;
use App\Models\Province;

function getCityToko(){
    $toko = AlamatToko::first();
    return $toko->city_id;
}

function getAlamatLengkap($id){
    $alamatUser = AlamatUser::find($id);
    $city = City::where('city_id', $alamatUser->city_id)->first();
    $provinsi = Province::find($alamatUser->province_id);
    return $alamatUser->alamat.','.$alamatUser->kode_pos.','.$city->name.','.$provinsi->name;
}

function getKotaId($id){
    $alamatUser = AlamatUser::find($id);
    return $alamatUser->city_id;
}

function getProvinsiId($id){
    $alamatUser = AlamatUser::find($id);
    return $alamatUser->province_id;
}