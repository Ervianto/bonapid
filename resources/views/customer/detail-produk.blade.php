@extends('layouts.landing')
@section('content')
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>{{ $produk->nama_produk }}</p>
                    <h1>Detail Produk</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('foto/produk/'.$produk->foto_produk) }}" alt="">
                        </div>
                        @foreach($produk->detailProduk as $row)
                            <div class="carousel-item">
                                <img src="{{ asset('foto/produk/'.$row->foto_produk) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
        </div>
        <div class="col-md-6">
            <div class="single-product-item p-4">
                <h3><span class="orange-text">{{ rupiah($produk->harga_produk) }}</span></h3>
                <form action="{{ route('customer-cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $produk->id }}" name="id">
                    <input type="hidden" value="{{ $produk->nama_produk }}" name="namaProduk">
                    <input type="hidden" value="{{ $produk->harga_produk }}" name="hargaProduk">
                    <input type="hidden" value="{{ $produk->foto_produk }}"  name="gambarProduk">
                    <input type="hidden" value="{{ $produk->berat_produk }}"  name="beratProduk">
                    <input type="hidden" value="1" name="jumlahProduk">
                    <button type="submit" class="btn btn-warning text-white rounded">Tambah <i class="fas fa-shopping-cart"></i></button>
                </form>
                <table>
                    <tr>
                        <td><h3>Sisa</h3></td>
                        <td><h3>{{ $produk->stok_produk }}</h3></td>
                    </tr>
                    <tr>
                        <td><h3>Ukuran</h3></td>
                        <td><h3>{{ $produk->ukuran_produk }}</h3></td>
                    </tr>
                    <tr>
                        <td><h3>Berat</h3></td>
                        <td><h3>{{ $produk->berat_produk }} gram</h3></td>
                    </tr>
                    <tr>
                        <td><h3>Variasi</h3></td>
                        <td><h3>{{ $produk->variasi_produk }}</h3></td>
                    </tr>
                    <tr>
                        <td colspan="2"><h3>Deskripsi</h3></td>
                    </tr>
                    <tr>
                        <td colspan="2"><p>{{ $produk->deskripsi_produk }}</p></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush