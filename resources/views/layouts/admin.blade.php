<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin :: {{Auth::user()->name}}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('admin/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('admin/js/select.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/js/select.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('admin/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('admin/images/favicon.png')}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="sidebar-dark">
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row navbar-info">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <div class="me-3">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                </div>
                <div>
                    <a class="navbar-brand brand-logo" href="index.html">
                        <img src="images/logo.svg" alt="logo" />
                    </a>
                    <a class="navbar-brand brand-logo-mini" href="index.html">
                        <img src="images/logo-mini.svg" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
                <ul class="navbar-nav">
                    <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                        <h1 class="welcome-text">Haii, <span class="text-black fw-bold">{{Auth::user()->username}}</span></h1>
                        <h3 class="welcome-sub-text">E-COMMERCE TOKO PENGRAJIN BONAFIDE KABUPATEN MAGETAN </h3>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon-bell"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
                            <a class="dropdown-item py-3" href="{{route('admin.transaksi')}}">
                                <p class="mb-0 font-weight-medium float-left">Notifikasi Transaksi Terbaru</p>
                                <span class="badge badge-pill badge-primary float-right">View all</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            @php
                            $trx = DB::select("select a.*,b.name from transaksi a, users b where a.user_id=b.id order by created_at desc limit 4");
                            @endphp
                            @foreach($trx as $data)
                            <a class="dropdown-item preview-item">
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">{{$data->name}} </p>
                                    <p class="fw-light small-text mb-0"> {{\Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i')}} </p>
                                    <p class="fw-light small-text mb-0"> @currency($data->total_transaksi) </p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </li>
                    <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="img-xs rounded-circle" src="images/faces/face8.jpg" alt="Profile image"> </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                <img class="img-md rounded-circle" src="images/faces/face8.jpg" alt="Profile image">
                                <p class="mb-1 mt-3 font-weight-semibold">{{Auth::user()->name}}</p>
                                <p class="fw-light text-muted mb-0">{{Auth::user()->email}}</p>
                            </div>
                            <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Profile </a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }} " href="{{route('admin.dashboard')}}">
                            <i class="mdi mdi-grid-large menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item nav-category">Menu</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form-transaksi" aria-expanded="{{ Route::is('admin.barang') ? 'true' : 'false' }}" aria-controls="form-transaksi">
                            <i class="menu-icon mdi mdi-card-text-outline"></i>
                            <span class="menu-title">Transaksi</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse {{ Route::is('admin.transaksi')||Route::is('admin.pengiriman') ? 'show' : '' }} " id="form-transaksi">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link {{ Route::is('admin.transaksi') ? 'active' : '' }} " href="{{route('admin.transaksi')}}">Pembelian</a></li>
                                <li class="nav-item"><a class="nav-link {{ Route::is('admin.pengiriman') ? 'active' : '' }}" href="{{route('admin.pengiriman')}}">Pengiriman</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form-laporan" aria-expanded="{{ Route::is('admin.laporan-transaksi')||Route::is('admin.laporan-stok') ? 'true' : 'false' }}" aria-controls="form-laporan">
                            <i class="menu-icon mdi mdi-card-text-outline"></i>
                            <span class="menu-title">Laporan</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse {{Route::is('admin.laporan-transaksi')||Route::is('admin.laporan-stok') ? 'show' : '' }} " id="form-laporan">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link {{ Route::is('admin.laporan-transaksi') ? 'active' : '' }} " href="{{route('admin.laporan-transaksi')}}">Transaksi</a></li>
                                <li class="nav-item"><a class="nav-link {{ Route::is('admin.laporan-stok') ? 'active' : '' }}" href="{{route('admin.laporan-stok')}}">Stok</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form-informasi" aria-expanded="{{ Route::is('admin.alamat-toko')||Route::is('admin.review') ? 'true' : 'false' }}" aria-controls="form-informasi">
                            <i class="menu-icon mdi mdi-card-text-outline"></i>
                            <span class="menu-title">Informasi</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse {{ Route::is('admin.alamat-toko')||Route::is('admin.review') ? 'show' : '' }} " id="form-informasi">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link {{ Route::is('admin.alamat-toko') ? 'active' : '' }}" href="{{route('admin.alamat-toko')}}">Alamat Toko</a></li>
                                <li class="nav-item"><a class="nav-link {{ Route::is('admin.event') ? 'active' : '' }} " href="{{route('admin.event')}}">Event</a></li>
                                <li class="nav-item"><a class="nav-link {{ Route::is('admin.review') ? 'active' : '' }} " href="{{route('admin.review')}}">Review</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form-gudang" aria-expanded="{{ Route::is('admin.barang') ? 'true' : 'false' }}" aria-controls="form-gudang">
                            <i class="menu-icon mdi mdi-card-text-outline"></i>
                            <span class="menu-title">Gudang</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse {{ Route::is('admin.barang')||Route::is('admin.stok') ? 'show' : '' }} " id="form-gudang">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link {{ Route::is('admin.barang') ? 'active' : '' }} " href="{{route('admin.barang')}}">Barang</a></li>
                                <li class="nav-item"><a class="nav-link {{ Route::is('admin.stok') ? 'active' : '' }}" href="{{route('admin.stok')}}">Stok</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-master" aria-expanded="{{ Route::is('admin.kategori')|| Route::is('admin.user') ? 'true' : 'false' }}" aria-controls="ui-master">
                            <i class="menu-icon mdi mdi-floor-plan"></i>
                            <span class="menu-title">Master</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse {{ Route::is('admin.kategori')||Route::is('admin.user') ? 'show' : '' }} " id="ui-master">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link {{ Route::is('admin.kategori') ? 'active' : '' }}" href="{{route('admin.kategori')}}">Kategori</a></li>
                                <li class="nav-item"> <a class="nav-link {{ Route::is('admin.user') ? 'active' : '' }}" href="{{route('admin.user')}}">Users</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item nav-category">Info</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('about')}}">
                            <i class="menu-icon mdi mdi-file-document"></i>
                            <span class="menu-title">About</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">

                @include('sweetalert::alert')
                @yield('content')
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{asset('admin/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('admin/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('admin/vendors/progressbar.js/progressbar.min.js')}}"></script>
    <script src="{{asset('admin/vendors/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('admin/js/dataTables.select.min.js')}}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('admin/js/off-canvas.js')}}"></script>
    <script src="{{asset('admin/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('admin/js/template.js')}}"></script>
    <script src="{{asset('admin/js/settings.js')}}"></script>
    <script src="{{asset('admin/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{asset('admin/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin/js/dashboard.js')}}"></script>
    <script src="{{asset('admin/js/Chart.roundedBarCharts.js')}}"></script>
    <!-- End custom js for this page-->

    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{asset('admin/vendors/sweetalert/sweetalert.min.js')}}"></script>

    <script src="{{asset('admin/vendors/select2/select2.min.js')}}"></script>
    <script src="{{asset('admin/js/select2.js')}}"></script>
    <script type="text/javascript">
        // rupiah
        var format = function(num) {
            var str = num.toString().replace("", ""),
                parts = false,
                output = [],
                i = 1,
                formatted = null;
            if (str.indexOf(".") > 0) {
                parts = str.split(".");
                str = parts[0];
            }
            str = str.split("").reverse();
            for (var j = 0, len = str.length; j < len; j++) {
                if (str[j] != ",") {
                    output.push(str[j]);
                    if (i % 3 == 0 && j < (len - 1)) {
                        output.push(",");
                    }
                    i++;
                }
            }
            formatted = output.reverse().join("");
            return ("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
        };
    </script>
    @stack('scripts')
</body>

</html>