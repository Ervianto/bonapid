<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- title -->
    <title>E-Commerce</title>

    <style>
        .hidden {
            display: none;
        }
    </style>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('landing/img/favicon.png') }}">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{ asset('landing/css/all.min.css') }}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('landing/bootstrap/css/bootstrap.min.css') }}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{ asset('landing/css/magnific-popup.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('landing/css/animate.css') }}">
    <!-- mean menu css -->
    <link rel="stylesheet" href="{{ asset('landing/css/meanmenu.min.css') }}">
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('landing/css/main.css') }}">
    <!-- responsive -->
    <link rel="stylesheet" href="{{ asset('landing/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/select2/css/select2.min.css') }}" />
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
    <style>
        .input-password {
            padding: 12px;
        }

        .hidden {
            display: none;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .img-review {
            width: 100px;
            cursor: pointer;
            margin-top: 0px;
        }

        .img-carosol {
            height: 500px;
            object-fit: cover;
        }

        .myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .myImg:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modalImage {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9);
            /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content,
        #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: relative;
            top: 50px;
            right: 50px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->

    <!-- header -->
    <div class="top-header-area" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- logo -->
                        <div class="site-logo">
                            <a href="index.html">
                                <img src="assets/img/logo.png" alt="">
                            </a>
                        </div>
                        <!-- logo -->

                        <!-- menu start -->
                        <nav class="main-menu">
                            <ul>
                                <li><a href="{{ url('/') }}">Home</a>
                                </li>
                                <li><a href="{{ url('/about') }}">About</a></li>
                                <li><a href="#">Produk</a>
                                    <ul class="sub-menu">
                                        <?php
                                            use App\Models\Kategori;
                                            
                                            $kategori = Kategori::all();
                                            foreach($kategori as $row){
                                        ?>
                                        <li><a href="{{ url('list_produk/'.$row->id) }}"><?= $row->nama_kategori ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                {{-- <li><a href="#">Contact</a></li> --}}
                                @if (Auth::check())
                                    <li><a href="{{ url('customer-transaksi') }}">Transaksi</a></li>
                                    <li><a href="{{ url('pre-order') }}">Pre-Order</a></li>
                                    <li><a href="#"><i class="fas fa-user"></i> {{ Auth::user()->username }}</a>
                                        <ul class="sub-menu">
                                                <li><a href="{{ route('customer.account') }}"> Profile</a></li>
                                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"> Sign Out</a>

                                                    <form id="logout-form" action="{{ route('logout') }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                    </li>
                                @endif
                                <li>
                                    <div class="header-icons">
                                        @if (!Auth::check())
                                            <a href="{{ route('customer.signin') }}"><i class="fas fa-user"></i>
                                                Masuk</a>
                                        @endif
                                        <a class="shopping-cart" href="{{ url('customer-cart') }}"><i
                                                class="fas fa-shopping-cart"></i> <span class="badge badge-danger" style="margin-top: -10px; margin-left: 20px; float: left;">{{ count(\Cart::getContent()) }}</span></a>
                                        <a class="mobile-hide search-bar-icon" href="#"><i
                                                class="fas fa-search"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                        <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                        <div class="mobile-menu"></div>
                        <!-- menu end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end header -->

    <!-- search area -->
    <div class="search-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="close-btn"><i class="fas fa-window-close"></i></span>
                    <div class="search-bar">

                        <div class="search-bar-tablecell">
                            <h3>Pencarian :</h3>
                            <form action="{{ route('home') }}" method="GET">
                                <input type="text" name="search" placeholder="Masukkan Nama Barang">
                                <button type="submit">Search <i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end search area -->

    @include('sweetalert::alert')
    @yield('content')

    <!-- footer -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <p>Copyrights &copy; 2022 - All Rights
                    </p>
                </div>
                <div class="col-lg-6 text-right col-md-12">
                    <div class="social-icons">
                        <ul>
                            <?php
                            
                                $sosmed=DB::table('sosmed')->get();
                                foreach($sosmed as $data){
                            ?>
                            <li><a href="{{$data->fb}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="{{$data->ig}}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="{{$data->wa}}" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                            <?php
                                }
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end copyright -->

    <!-- jquery -->
    <script src="{{ asset('landing/js/jquery-1.11.3.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{ asset('landing/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- count down -->
    <script src="{{ asset('landing/js/jquery.countdown.js') }}"></script>
    <!-- isotope -->
    <script src="{{ asset('landing/js/jquery.isotope-3.0.6.min.js') }}"></script>
    <!-- waypoints -->
    <script src="{{ asset('landing/js/waypoints.js') }}"></script>
    <!-- owl carousel -->
    <script src="{{ asset('landing/js/owl.carousel.min.js') }}"></script>
    <!-- magnific popup -->
    <script src="{{ asset('landing/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- mean menu -->
    <script src="{{ asset('landing/js/jquery.meanmenu.min.js') }}"></script>
    <!-- sticker js -->
    <script src="{{ asset('landing/js/sticker.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('landing/bs-input-file/bs-input-file.min.js') }}"></script>
    <script src="{{ asset('landing/js/main.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('landing/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-RuqVzBovLvbbSKaW"></script>

    <script>
        $(document).ready(function() {
            bsCustomFileInput.init()
        });
    </script>

    @stack('scripts')

</body>

</html>
