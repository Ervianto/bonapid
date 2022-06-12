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
                                        <h3 class="rate-percentage" id="total_brg">{{$total_brg}}</h3>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Transaksi</p>
                                        <h3 class="rate-percentage" id="total_trx">{{$total_trx}}</h3>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">Transaksi Belum Bayar</p>
                                        <h3 class="rate-percentage" id="total_trx_blm_bayar">{{$total_trx_blm_bayar}}</h3>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">Transaksi Sudah Bayar</p>
                                        <h3 class="rate-percentage" id="total_trx_sdh_bayar">{{$total_trx_sdh_bayar}}</h3>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">Transaksi Sudah Kirim</p>
                                        <h3 class="rate-percentage" id="total_trx_sdh_kirim">{{$total_trx_sdh_kirim}}</h3>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <p class="statistics-title">Transaksi Sudah Sampai</p>
                                        <h3 class="rate-percentage" id="total_trx_sdh_sampai">{{$total_trx_sdh_sampai}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 d-flex flex-column">
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
                                                    <canvas id="pieChart" style="height: 230px;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex flex-column">
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
                                                    <canvas id="barChart" style="height: 230px;"></canvas>
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
<script>
    $(function() {

        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: false
            },
            elements: {
                point: {
                    radius: 0
                }
            }

        };

        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: {},
            options: options
        });

        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: {},
            options: {}
        });
        $("#filter").click(function() {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.dashboard-statistik') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    tgl_awal: $('#tgl_awal').val(),
                    tgl_akhir: $('#tgl_akhir').val()
                },
                success: function(response) {
                    $('#total_brg').html(response.total_brg);
                    $('#total_trx').html(response.total_trx);
                    $('#total_trx_blm_bayar').html(response.total_trx_blm_bayar);
                    $('#total_trx_sdh_bayar').html(response.total_trx_sdh_bayar);
                    $('#total_trx_sdh_kirim').html(response.total_trx_sdh_kirim);
                    $('#total_trx_sdh_sampai').html(response.total_trx_sdh_sampai);
                },
                error: function(xhr) {

                }
            });
            /* ChartJS
             * -------
             * Data and config for chartjs
             */
            $.ajax({
                type: "POST",
                url: "{{ route('admin.dashboard-chart1') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    tgl_awal: $('#tgl_awal').val(),
                    tgl_akhir: $('#tgl_akhir').val()
                },
                success: function(response) {
                    var labels = response.data.map(function(e) {
                        return e.username
                    })

                    var dt = response.data.map(function(e) {
                        return e.total
                    })

                    var data = {
                        labels: labels,
                        datasets: [{
                            label: 'Data Penjualan',
                            data: dt,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1,
                            fill: false
                        }]
                    };

                    barChart.data = data;
                    barChart.update();
                },
                error: function(xhr) {

                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('admin.dashboard-chart2') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    tgl_awal: $('#tgl_awal').val(),
                    tgl_akhir: $('#tgl_akhir').val()
                },
                success: function(response) {
                    console.log(response);
                    var label = response.data.map(function(e) {
                        return e.nama_produk
                    })

                    var dt = response.data.map(function(e) {
                        return e.total
                    })
                    var doughnutPieData = {
                        datasets: [{
                            data: dt,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)',
                                'rgba(255, 159, 64, 0.5)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                        }],

                        // These labels appear in the legend and in the tooltips when hovering different arcs
                        labels: label
                    };
                    var doughnutPieOptions = {
                        responsive: true,
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    };

                    pieChart.data = doughnutPieData;
                    pieChart.options = doughnutPieOptions;
                    pieChart.update();
                }
            });
        });
    });
</script>
@endpush