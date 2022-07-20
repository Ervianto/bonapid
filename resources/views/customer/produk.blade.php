@extends('layouts.landing')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>{{ $kt->nama_kategori }}</p>
                        <h1>Daftar Produk</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
         @if(count($produk) > 0)
         <div class="row">
                @foreach ($produk as $item)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="#">
                                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            @php $no = 0; @endphp
                                            @foreach (getFotoProduk($item->id) as $row)
                                                <li data-target="#carouselExampleCaptions" data-slide-to="{{ $no }}"
                                                    @if ($no == 0) class="active" @endif></li>
                                                @php $no++; @endphp
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @php $no = 0; @endphp
                                            @foreach (getFotoProduk($item->id) as $row)
                                                <div class="carousel-item @if ($no == 0) active @endif">
                                                    <img src="{{ asset('foto/produk/' . $row->foto_produk) }}" height="300" alt="...">
                                                </div>
                                                @php $no++; @endphp
                                            @endforeach
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </button>
                                    </div>
                                </a>
                            </div>
                            <h3>{{ $item->nama_produk }}</h3>
                            <p class="product-price">{{ rupiah($item->harga_produk) }}</p>
                            <table class="table table-borderless">
                                <tr>
                                    <td>Rating</td>
                                    <td>
                                         @if(getRating($item->id))
                                            @php 
                                                $rating = getRating($item->id)->rating / getRating($item->id)->jumlah;
                                            @endphp
                                            @if($rating >= 1 && $rating < 2)
                                                <div class="row col-12">
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                                    <h5><span class="fa fa-star-o"></span></h5>
                                                </div>
                                            @elseif($rating >= 2 && $rating < 3)
                                                <div class="row col-12">
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                                    <h5><span class="fa fa-star-o"></span></h5>
                                                </div>
                                            @elseif($rating >= 3 && $rating < 4)
                                                 <div class="row col-12">
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="text-warning ml-"><span class="fa fa-star"></span></h5>
                                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                                    <h5><span class="fa fa-star-o"></span></h5>
                                                </div>
                                            @elseif($rating >= 4 && $rating < 5)
                                                <div class="row col-12">
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5><span class="fa fa-star-o"></span></h5>
                                                </div>
                                            @elseif($rating >= 5)
                                                 <div class="row col-12">
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                                    <h5 class="text-warning"><span class="fa fa-star"></span></h5>
                                                </div>
                                            @endif
                                         @else
                                            Belum ada penilaian
                                         @endif
                                    </td>
                                </tr>
                                <!--<tr>-->
                                <!--    <td>Ukuran</td>-->
                                <!--    <td>{{ $item->ukuran_produk }}</td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>Variasi</td>-->
                                <!--    <td>{{ $item->variasi_produk }}</td>-->
                                <!--</tr>-->
                            </table>
                            <div class="row justify-content-center">
                                <a href="{{ url('produk/' . $item->id) }}" class="beli-btn mr-3">Detail <i
                                        class="fas fa-eye"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row justify-content-center mb-5">
                <h3>Tidak ada produk</h3>
            </div>
        @endif
    </div>
@endsection