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
                            <img src="{{ asset('foto/produk/' . $produk->foto_produk) }}" alt="">
                        </div>
                        @foreach ($produk->detailProduk as $row)
                            <div class="carousel-item">
                                <img src="{{ asset('foto/produk/' . $row->foto_produk) }}" alt="">
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
                        <input type="hidden" value="{{ $produk->foto_produk }}" name="gambarProduk">
                        <input type="hidden" value="{{ $produk->berat_produk }}" name="beratProduk">
                        <input type="hidden" value="1" name="jumlahProduk">
                        <button type="submit" class="btn btn-warning text-white rounded">Tambah <i
                                class="fas fa-shopping-cart"></i></button>
                    </form>
                    <table>
                        <tr>
                            <td>
                                <h3>Sisa</h3>
                            </td>
                            <td>
                                <h3>{{ $produk->stok_produk }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3>Ukuran</h3>
                            </td>
                            <td>
                                <h3>{{ $produk->ukuran_produk }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3>Berat</h3>
                            </td>
                            <td>
                                <h3>{{ $produk->berat_produk }} gram</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3>Variasi</h3>
                            </td>
                            <td>
                                <h3>{{ $produk->variasi_produk }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h3>Deskripsi</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p>{{ $produk->deskripsi_produk }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-12 mt-3 mb-3">
                <div class="card card-body">
                    <h4>Review Produk</h4>
                    <label class="ml-3 mt-2">Pilih Bintang</label>
                    <div class="row col-6 ml-1">
                        <h1 class="mr-2 cursor-pointer" onclick="pickStar('1')" id="star-1"><span class="fa fa-star-o"
                                id="item-bintang-1"></span></h1>
                        <h1 class="mr-2 cursor-pointer" onclick="pickStar('2')" id="star-2"><span class="fa fa-star-o"
                                id="item-bintang-2"></span></h1>
                        <h1 class="mr-2 cursor-pointer" onclick="pickStar('3')" id="star-3"><span class="fa fa-star-o"
                                id="item-bintang-3"></span></h1>
                        <h1 class="mr-2 cursor-pointer" onclick="pickStar('4')" id="star-4"><span class="fa fa-star-o"
                                id="item-bintang-4"></span></h1>
                        <h1 class="cursor-pointer" onclick="pickStar('5')" id="star-5"><span class="fa fa-star-o"
                                id="item-bintang-5"></span></h1>
                    </div>
                    <form action="{{ url('store_review') }}" class="col-6" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        <input type="hidden" name="review_id" id="review_id" />
                        <input type="hidden" name="bintang" id="bintang" />
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}" />
                        <div class="form-group">
                            <label>Ulasan Produk <strong class="text-danger">*</strong> </label>
                            <textarea class="form-control" name="ulasan" required placeholder="Ulasan Produk"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tambahkan Foto</label>
                            <div class="custom-file">
                                <input type="file" name="foto" class="custom-file-input" id="customFile" accept="image/*">
                                <label class="custom-file-label" for="customFile">Ambil file</label>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                </div>
            </div>

            <div class="col-md-12 mt-3 mb-3">
                <div class="card card-body">
                    @foreach ($reviews as $item)
                        <div class="p-2">
                            <h5>{{ $item->name }}</h5>
                            @if ($item->bintang == 1)
                                <div class="row col-6">
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5><span class="fa fa-star-o"></span></h5>
                                </div>
                            @elseif($item->bintang == 2)
                                <div class="row col-6">
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5><span class="fa fa-star-o"></span></h5>
                                </div>
                            @elseif($item->bintang == 3)
                                <div class="row col-6">
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="text-warning ml-"><span class="fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5><span class="fa fa-star-o"></span></h5>
                                </div>
                            @elseif($item->bintang == 4)
                                <div class="row col-6">
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5><span class="fa fa-star-o"></span></h5>
                                </div>
                            @elseif($item->bintang == 5)
                                <div class="row col-6">
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                    <h5 class="text-warning"><span class="fa fa-star"></span></h5>
                                </div>
                            @endif
                            <p>{{ $item->ulasan }}</p>
                            <img id="myImg{{ $item->id }}" class="myImg" width="100" src="{{ asset('foto/review/' . $item->foto) }}" />
                            <hr />
                        </div>

                        <div id="myModal{{ $item->id }}" class="modal">
                            <span class="close{{ $item->id }}">&times;</span>
                            <img class="modal-content" id="img{{ $item->id }}">
                            <div id="caption"></div>
                        </div>

                        <script>
                            // Get the modal
                            var modal = document.getElementById("myModal{{ $item->id }}");
                    
                            // Get the image and insert it inside the modal - use its "alt" text as a caption
                            var img = document.getElementById("myImg{{ $item->id }}");
                            var modalImg = document.getElementById("img{{ $item->id }}");
                            var captionText = document.getElementById("caption");
                            img.onclick = function() {
                                console.log(this.src);
                                modal.style.display = "block";
                                modalImg.src = this.src;
                                captionText.innerHTML = this.alt;
                            }
                    
                            modal.onclick = function() {
                                modal.style.display = "none";
                            }
                        </script>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function pickStar(star) {
            $("#bintang").val(star);
            if (star == '1') {
                $("#star-1").addClass("text-warning");
                $("#item-bintang-1").removeClass("fa-star-o");
                $("#item-bintang-1").addClass("fa-star");

                $("#star-2").removeClass("text-warning");
                $("#item-bintang-2").removeClass("fa-star");
                $("#item-bintang-2").addClass("fa-star-o");
                $("#star-3").removeClass("text-warning");
                $("#item-bintang-3").removeClass("fa-star");
                $("#item-bintang-3").addClass("fa-star-o");
                $("#star-4").removeClass("text-warning");
                $("#item-bintang-4").removeClass("fa-star");
                $("#item-bintang-4").addClass("fa-star-o");
                $("#star-5").removeClass("text-warning");
                $("#item-bintang-5").removeClass("fa-star");
                $("#item-bintang-5").addClass("fa-star-o");
            }
            if (star == '2') {
                $("#star-1").addClass("text-warning");
                $("#item-bintang-1").removeClass("fa-star-o");
                $("#item-bintang-1").addClass("fa-star");

                $("#star-2").addClass("text-warning");
                $("#item-bintang-2").removeClass("fa-star-o");
                $("#item-bintang-2").addClass("fa-star");

                $("#star-3").removeClass("text-warning");
                $("#item-bintang-3").removeClass("fa-star");
                $("#item-bintang-3").addClass("fa-star-o");
                $("#star-4").removeClass("text-warning");
                $("#item-bintang-4").removeClass("fa-star");
                $("#item-bintang-4").addClass("fa-star-o");
                $("#star-5").removeClass("text-warning");
                $("#item-bintang-5").removeClass("fa-star");
                $("#item-bintang-5").addClass("fa-star-o");
            }

            if (star == '3') {
                $("#star-1").addClass("text-warning");
                $("#item-bintang-1").removeClass("fa-star-o");
                $("#item-bintang-1").addClass("fa-star");

                $("#star-2").addClass("text-warning");
                $("#item-bintang-2").removeClass("fa-star-o");
                $("#item-bintang-2").addClass("fa-star");

                $("#star-3").addClass("text-warning");
                $("#item-bintang-3").removeClass("fa-star-o");
                $("#item-bintang-3").addClass("fa-star");

                $("#star-4").removeClass("text-warning");
                $("#item-bintang-4").removeClass("fa-star");
                $("#item-bintang-4").addClass("fa-star-o");
                $("#star-5").removeClass("text-warning");
                $("#item-bintang-5").removeClass("fa-star");
                $("#item-bintang-5").addClass("fa-star-o");
            }

            if (star == '4') {
                $("#star-1").addClass("text-warning");
                $("#item-bintang-1").removeClass("fa-star-o");
                $("#item-bintang-1").addClass("fa-star");

                $("#star-2").addClass("text-warning");
                $("#item-bintang-2").removeClass("fa-star-o");
                $("#item-bintang-2").addClass("fa-star");

                $("#star-3").addClass("text-warning");
                $("#item-bintang-3").removeClass("fa-star-o");
                $("#item-bintang-3").addClass("fa-star");

                $("#star-4").addClass("text-warning");
                $("#item-bintang-4").removeClass("fa-star-o");
                $("#item-bintang-4").addClass("fa-star");

                $("#star-5").removeClass("text-warning");
                $("#item-bintang-5").removeClass("fa-star");
                $("#item-bintang-5").addClass("fa-star-o");
            }

            if (star == '5') {
                $("#star-1").addClass("text-warning");
                $("#item-bintang-1").removeClass("fa-star-o");
                $("#item-bintang-1").addClass("fa-star");

                $("#star-2").addClass("text-warning");
                $("#item-bintang-2").removeClass("fa-star-o");
                $("#item-bintang-2").addClass("fa-star");

                $("#star-3").addClass("text-warning");
                $("#item-bintang-3").removeClass("fa-star-o");
                $("#item-bintang-3").addClass("fa-star");

                $("#star-4").addClass("text-warning");
                $("#item-bintang-4").removeClass("fa-star-o");
                $("#item-bintang-4").addClass("fa-star");

                $("#star-5").addClass("text-warning");
                $("#item-bintang-5").removeClass("fa-star-o");
                $("#item-bintang-5").addClass("fa-star");
            }
        }
    </script>
@endpush
