@extends('layouts.landing')
@section('content')
    <!-- home page slider -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @php $no = 0; @endphp
                            @foreach ($events as $event)
                                <li data-target="#carouselExampleCaptions" data-slide-to="{{ $no }}"
                                    @if ($no == 0) class="active" @endif></li>
                                @php $no++; @endphp
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @php $no = 0; @endphp
                            @foreach ($events as $event)
                                <div class="carousel-item @if ($no == 0) active @endif">
                                    <img src="{{ asset('foto/events/' . $event->foto_event) }}"
                                        class="d-block w-100 img-carosol" alt="...">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h1 class="text-white">{{ $event->nama_event }}</h1>
                                        <h4 class="text-white">{{ $event->isi_event }}</h4>
                                    </div>
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
                </div>
            </div>
        </div>
    </div>
    <!-- end home page slider -->

    <!-- latest news -->
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Produk</span> Kami</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($produk as $item)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="single-product.html"><img src="{{ asset('foto/produk/' . $item->foto_produk) }}"
                                        alt=""></a>
                            </div>
                            <h3>{{ $item->nama_produk }}</h3>
                            <p class="product-price">{{ rupiah($item->harga_produk) }}</p>
                            <div class="row justify-content-center">
                                <a href="{{ url('produk/' . $item->id) }}" class="beli-btn mr-3">Detail <i
                                        class="fas fa-eye"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                {{ $produk->links() }}
            </div>
        </div>
    </div>
    <!-- end latest news -->

    <!-- logo carousel -->
    <div class="logo-carousel-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo-carousel-inner">
                        <div class="single-logo-item">
                            <img src="assets/img/company-logos/1.png" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="assets/img/company-logos/2.png" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="assets/img/company-logos/3.png" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="assets/img/company-logos/4.png" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="assets/img/company-logos/5.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end logo carousel -->
@endsection
@push('scripts')
@endpush
