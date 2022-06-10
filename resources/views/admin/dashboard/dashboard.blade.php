@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row mb-3">
                            <div class="col-3">
                                <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" required>
                            </div>
                            <div class="col-1">
                                <p class="mt-2">Sampai</p>
                            </div>
                            <div class="col-3">
                                <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" required>
                            </div>
                            <div class="col-2">
                                <button id="filter" class="btn btn-sm btn-primary"><i class="mdi mdi-filter"></i> </button>
                                <a href="{{route('admin.dashboard')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-refresh"></i> </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="statistics-details d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="statistics-title">Barang</p>
                                        <h3 class="rate-percentage">{{$total_brg}}</h3>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Transaksi</p>
                                        <h3 class="rate-percentage">{{$total_trx}}</h3>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">Transaksi Belum Bayar</p>
                                        <h3 class="rate-percentage">{{$total_trx_blm_bayar}}</h3>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">Transaksi Sudah Bayar</p>
                                        <h3 class="rate-percentage">{{$total_trx_sdh_bayar}}</h3>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">Transaksi Sudah Kirim</p>
                                        <h3 class="rate-percentage">{{$total_trx_sdh_kirim}}</h3>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">Transaksi Sudah Sampai</p>
                                        <h3 class="rate-percentage">{{$total_trx_sdh_sampai}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Grafik Transaksi Berdasarkan Produk</h4>
                                                    </div>
                                                </div>
                                                <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                                    <!-- <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                                        <h2 class="me-2 fw-bold">$36,2531.00</h2>
                                                        <h4 class="me-2">USD</h4>
                                                        <h4 class="text-success">(+1.37%)</h4>
                                                    </div> -->
                                                    <!-- <div class="me-3">
                                                        <div id="marketing-overview-legend"></div>
                                                    </div> -->
                                                </div>
                                                <div class="chartjs-bar-wrapper mt-3">
                                                    <div id="chart1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Grafik Transaksi Berdasarkan Customer</h4>
                                                    </div>
                                                </div>
                                                <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                                    <!-- <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                                        <h2 class="me-2 fw-bold">$36,2531.00</h2>
                                                        <h4 class="me-2">USD</h4>
                                                        <h4 class="text-success">(+1.37%)</h4>
                                                    </div> -->
                                                    <!-- <div class="me-3">
                                                        <div id="marketing-overview-legend"></div>
                                                    </div> -->
                                                </div>
                                                <div class="chartjs-bar-wrapper mt-3">
                                                    <div id="chart2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
@endsection
@push('scripts')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    //chart1
    google.charts.load("current", {
        packages: ["corechart"]
    });

    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart1);


    //chart
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Produk', 'Total'],
            <?php
            foreach ($trx_produk as $data) {
                echo "['" . $data->nama_produk .
                    "', " . $data->total .
                    "],";
            };
            ?>
        ]);

        var options = {
            title: '',
            width: 600,
            height: 400,
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart1'));
        chart.draw(data, options);
    }

    function drawChart1() {
        var data = google.visualization.arrayToDataTable([
            ['Produk', 'Total'],

            <?php
            foreach ($trx_user as $data) {
                echo "['" . $data->username .
                    "', " . $data->total .
                    "],";
            };
            ?>
        ]);

        var options = {
            title: '',
            width: 1000,
            height: 450,
            bar: {
                groupWidth: "80%"
            },
            legend: {
                position: "right"
            },
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart2'));
        chart.draw(data, options);
    }
</script>
@endpush