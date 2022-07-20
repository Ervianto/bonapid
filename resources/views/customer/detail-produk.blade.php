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
                @if(getFotoSingleProduk($produk->id) != null)
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('foto/produk/' . getFotoSingleProduk($produk->id)) }}" height="500" alt="">
                        </div>
                        @foreach ($produk->detailProduk as $row)
                            <div class="carousel-item">
                                <img src="{{ asset('foto/produk/' . $row->foto_produk) }}" height="500" alt="">
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
                @endif
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
                    <table class="mt-3 table table-borderless">
                        <tr>
                            <td>
                                <h5>Rating</h5>
                            </td>
                            <td>
                                <h5>
                                        @if($jumlahBintang)
                                            @php 
                                                $rating = $jumlahBintang->rating / $jumlahReview;
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
                                </h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Jumlah Reviewer</h5>
                            </td>
                            <td>
                                <h5>{{ $jumlahReview }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Sisa</h5>
                            </td>
                            <td>
                                <h5>{{ $produk->stok_produk }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Ukuran</h5>
                            </td>
                            <td>
                                <h5>{{ $produk->ukuran_produk }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Berat</h5>
                            </td>
                            <td>
                                <h5>{{ $produk->berat_produk }} gram</h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Variasi</h5>
                            </td>
                            <td>
                                <h5>{{ $produk->variasi_produk }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h5>Deskripsi</h5>
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

            @if (Auth::check())
                <div class="col-md-12 mt-3 mb-3">
                    <div class="card card-body">
                        <div class="p-2 @if ($review == null) hidden @endif" id="sudahReview">
                            <h5>Review Anda</h5>
                            @if ($review != null)
                                @if ($review->bintang == 1)
                                    <div class="row col-6">
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                        <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                        <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                        <h5><span class="fa fa-star-o"></span></h5>
                                    </div>
                                @elseif($review->bintang == 2)
                                    <div class="row col-6">
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                        <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                        <h5><span class="fa fa-star-o"></span></h5>
                                    </div>
                                @elseif($review->bintang == 3)
                                    <div class="row col-6">
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="text-warning ml-"><span class="fa fa-star"></span></h5>
                                        <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                        <h5><span class="fa fa-star-o"></span></h5>
                                    </div>
                                @elseif($review->bintang == 4)
                                    <div class="row col-6">
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5><span class="fa fa-star-o"></span></h5>
                                    </div>
                                @elseif($review->bintang == 5)
                                    <div class="row col-6">
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="text-warning mr-1"><span class="fa fa-star"></span></h5>
                                        <h5 class="text-warning"><span class="fa fa-star"></span></h5>
                                    </div>
                                @endif
                                <p>{{ $review->ulasan }}</p>
                                @if ($review->foto != null)
                                    <img id="myImg" class="myImg" width="100"
                                        src="{{ asset('foto/review/' . $review->foto) }}" />
                                @endif
                            @endif
                            <br /><br />
                            <button class="btn btn-primary" onclick="editReview()" type="button">Edit</button>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#modalDelete" type="button">Hapus</button>
                        </div>

                        <div id="myModal" class="modalImage">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="img">
                            <div id="caption"></div>
                        </div>

                        <script>
                            // Get the modal
                            var modal = document.getElementById("myModal");

                            // Get the image and insert it inside the modal - use its "alt" text as a caption
                            var img = document.getElementById("myImg");
                            var modalImg = document.getElementById("img");
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

                        <div id="belumReview" @if ($review != null) class="hidden" @endif>
                            <h4>Review Produk</h4>
                            <label class="ml-3 mt-2">Pilih Bintang</label>
                            <div class="row col-6 ml-1">
                                @if ($review == null)
                                    <h1 class="mr-2 cursor-pointer" onclick="pickStar('1')" id="star-1"><span
                                            class="fa fa-star-o" id="item-bintang-1"></span></h1>
                                    <h1 class="mr-2 cursor-pointer" onclick="pickStar('2')" id="star-2"><span
                                            class="fa fa-star-o" id="item-bintang-2"></span></h1>
                                    <h1 class="mr-2 cursor-pointer" onclick="pickStar('3')" id="star-3"><span
                                            class="fa fa-star-o" id="item-bintang-3"></span></h1>
                                    <h1 class="mr-2 cursor-pointer" onclick="pickStar('4')" id="star-4"><span
                                            class="fa fa-star-o" id="item-bintang-4"></span></h1>
                                    <h1 class="cursor-pointer" onclick="pickStar('5')" id="star-5"><span
                                            class="fa fa-star-o" id="item-bintang-5"></span></h1>
                                @else
                                    @if ($review->bintang == 1)
                                        <div class="row col-6">
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('1')"
                                                id="star-1"><span class="fa fa-star" id="item-bintang-1"></span></h1>
                                            <h1 class="mr-2 cursor-pointer" onclick="pickStar('2')" id="star-2"><span
                                                    class="fa fa-star-o" id="item-bintang-2"></span></h1>
                                            <h1 class="mr-2 cursor-pointer" onclick="pickStar('3')" id="star-3"><span
                                                    class="fa fa-star-o" id="item-bintang-3"></span></h1>
                                            <h1 class="mr-2 cursor-pointer" onclick="pickStar('4')" id="star-4"><span
                                                    class="fa fa-star-o" id="item-bintang-4"></span></h1>
                                            <h1 class="cursor-pointer" onclick="pickStar('5')" id="star-5"><span
                                                    class="fa fa-star-o" id="item-bintang-5"></span></h1>
                                        </div>
                                    @elseif($review->bintang == 2)
                                        <div class="row col-6">
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('1')"
                                                id="star-1"><span class="fa fa-star" id="item-bintang-1"></span></h1>
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('2')"
                                                id="star-2"><span class="fa fa-star" id="item-bintang-2"></span></h1>
                                            <h1 class="mr-2 cursor-pointer" onclick="pickStar('3')" id="star-3"><span
                                                    class="fa fa-star-o" id="item-bintang-3"></span></h1>
                                            <h1 class="mr-2 cursor-pointer" onclick="pickStar('4')" id="star-4"><span
                                                    class="fa fa-star-o" id="item-bintang-4"></span></h1>
                                            <h1 class="cursor-pointer" onclick="pickStar('5')" id="star-5"><span
                                                    class="fa fa-star-o" id="item-bintang-5"></span></h1>
                                        </div>
                                    @elseif($review->bintang == 3)
                                        <div class="row col-6">
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('1')"
                                                id="star-1"><span class="fa fa-star " id="item-bintang-1"></span></h1>
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('2')"
                                                id="star-2"><span class="fa fa-star " id="item-bintang-2"></span></h1>
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('3')"
                                                id="star-3"><span class="fa fa-star " id="item-bintang-3"></span></h1>
                                            <h1 class="mr-2 cursor-pointer" onclick="pickStar('4')" id="star-4"><span
                                                    class="fa fa-star-o" id="item-bintang-4"></span></h1>
                                            <h1 class="cursor-pointer" onclick="pickStar('5')" id="star-5"><span
                                                    class="fa fa-star-o" id="item-bintang-5"></span></h1>
                                        </div>
                                    @elseif($review->bintang == 4)
                                        <div class="row col-6">
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('1')"
                                                id="star-1"><span class="fa fa-star " id="item-bintang-1"></span></h1>
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('2')"
                                                id="star-2"><span class="fa fa-star " id="item-bintang-2"></span></h1>
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('3')"
                                                id="star-3"><span class="fa fa-star " id="item-bintang-3"></span></h1>
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('4')"
                                                id="star-4"><span class="fa fa-star " id="item-bintang-4"></span></h1>
                                            <h1 class="cursor-pointer" onclick="pickStar('5')" id="star-5"><span
                                                    class="fa fa-star-o" id="item-bintang-5"></span></h1>
                                        </div>
                                    @elseif($review->bintang == 5)
                                        <div class="row col-6">
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('1')"
                                                id="star-1"><span class="fa fa-star " id="item-bintang-1"></span></h1>
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('2')"
                                                id="star-2"><span class="fa fa-star " id="item-bintang-2"></span></h1>
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('3')"
                                                id="star-3"><span class="fa fa-star " id="item-bintang-3"></span></h1>
                                            <h1 class="mr-2 cursor-pointer text-warning" onclick="pickStar('4')"
                                                id="star-4"><span class="fa fa-star " id="item-bintang-4"></span></h1>
                                            <h1 class="cursor-pointer text-warning" onclick="pickStar('5')" id="star-5">
                                                <span class="fa fa-star " id="item-bintang-5"></span>
                                            </h1>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <form action="{{ url('store_review') }}" class="col-6"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="review_id" id="review_id"
                                    @if ($review != null) value="{{ $review->id }}" @endif />
                                <input type="hidden" name="bintang" id="bintang"
                                    @if ($review != null) value="{{ $review->bintang }}" @endif />
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}" />
                                <div class="form-group">
                                    <label>Ulasan Produk <strong class="text-danger">*</strong> </label>
                                    <textarea class="form-control" name="ulasan" required placeholder="Ulasan Produk">@if ($review != null){{ $review->ulasan }}@endif</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Tambahkan Foto</label>
                                    <div class="custom-file mb-2">
                                        <input type="file" name="foto" class="custom-file-input" id="customFile"
                                            accept="image/*">
                                        <label class="custom-file-label" for="customFile">Ambil file</label>
                                    </div>
                                    @if ($review != null)
                                        @if ($review->foto != null)
                                            <img id="myImg" class="myImg" width="100"
                                                src="{{ asset('foto/review/' . $review->foto) }}" />
                                        @endif
                                    @endif
                                </div>
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Hapus Review --}}
            @if ($review != null)
                <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ url('delete-review/' . $review->id) }}">
                                    @csrf
                                    <label>Apakah anda yakin menghapus review ini ?</label>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Ya Hapus</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12 mt-3 mb-3">
                <div class="card card-body">
                    @foreach ($reviews as $item)
                        <div class="p-2">
                            <h5>{{ $item->name }}</h5>
                            @if ($item->bintang == 1)
                                <div class="row col-6">
                                    <h5 class="mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5><span class="fa fa-star-o"></span></h5>
                                </div>
                            @elseif($item->bintang == 2)
                                <div class="row col-6">
                                    <h5 class="mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5><span class="fa fa-star-o"></span></h5>
                                </div>
                            @elseif($item->bintang == 3)
                                <div class="row col-6">
                                    <h5 class="mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class="ml-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="fa fa-star-o"></span></h5>
                                    <h5><span class="fa fa-star-o"></span></h5>
                                </div>
                            @elseif($item->bintang == 4)
                                <div class="row col-6">
                                    <h5 class="mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class="mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5><span class="fa fa-star-o"></span></h5>
                                </div>
                            @elseif($item->bintang == 5)
                                <div class="row col-6">
                                    <h5 class=" mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class=" mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class=" mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5 class=" mr-1"><span class="text-warning fa fa-star"></span></h5>
                                    <h5><span class="text-warning fa fa-star"></span></h5>
                                </div>
                            @endif
                            <p>{{ $item->ulasan }}</p>
                            @if ($item->foto != null)
                                <img id="myImg{{ $item->id }}" class="myImg" width="100"
                                    src="{{ asset('foto/review/' . $item->foto) }}" />
                            @endif
                            @if(getBalasanAdmin($item->id) != null)
                            <div class="alert alert-secondary mt-2 ml-2" role="alert">
                                <h6>Respon Penjual : </h6>
                                <p>{{ getBalasanAdmin($item->id)->isi }}</p>
                                @if(getBalasanAdmin($item->id)->foto != null)
                                    <img width="300" src="{{ asset('foto/balas_review/'.getBalasanAdmin($item->id)->foto) }}" />
                                @endif
                            </div>
                            @endif
                            <hr />
                        </div>

                        <div id="myModal{{ $item->id }}" class="modalImage">
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

        function editReview() {
            $("#belumReview").removeClass("hidden");
            $("#sudahReview").addClass("hidden");
        }
    </script>
@endpush
