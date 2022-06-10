@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="card-title">Data Pengiriman</h4>
                        </div>
                    </div>
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
                            <a href="{{route('admin.pengiriman')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-refresh"></i> </a>
                        </div>
                    </div>
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <table id="table" class="table table-striped table-hover" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Kurir</th>
                                <th>Lama</th>
                                <th>Status Kirim</th>
                                <th>Status Sampai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal detail -->
<div class="modal fade bd-example-modal-lg" id="detail" tabindex="-1" role="dialog" aria-labelledby="detailLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden=" true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mt-1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Name :</label>
                            <input type="text" class="form-control" id="name1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Username :</label>
                            <input type="text" class="form-control" id="username1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label">Alamat :</label>
                            <input type="text" class="form-control" id="alamat1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kode Transaksi :</label>
                            <input type="text" class="form-control" id="kode1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Tanggal :</label>
                            <input type="text" class="form-control" id="created_at1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="kb" class=" form-control-label">Detail Transaksi</label>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table table-dark">
                                    <tr>
                                        <td>No.</td>
                                        <td>Barang</td>
                                        <td>Harga</td>
                                        <td>Qty</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody id="table-detail">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Total :</label>
                            <input type="text" class="form-control" id="total_transaksi1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Ongkir :</label>
                            <input type="text" class="form-control" id="jasa_ongkir1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Status Pembayaran :</label>
                            <input type="text" class="form-control" id="status_pembayaran1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Status Transaksi :</label>
                            <input type="text" class="form-control" id="status_transaksi1" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal kirim -->
<div class="modal fade bd-example-modal-lg" id="kirim" tabindex="-1" role="dialog" aria-labelledby="kirimLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kirimLabel"></h5>
            </div>
            <form action="{{route('admin.pengiriman-kirim')}}" method="POST">
                @csrf
                <input type="hidden" name="id1" id="id1">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            "scrollX": true,
            ajax: {
                url: "{{ route('admin.pengiriman') }}",
                data: function(d) {
                    d.tgl_awal = $('#tgl_awal').val(),
                        d.tgl_akhir = $('#tgl_akhir').val()
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kode_transaksi',
                    name: 'kode_transaksi'
                },
                {
                    data: 'tgl_trx',
                    name: 'tgl_trx'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'kurir',
                    name: 'kurir'
                },
                {
                    data: 'lama_sampai',
                    name: 'lama_sampai',
                    searchable: false
                },
                {
                    data: 'sd',
                    name: 'sd',
                    searchable: false
                },
                {
                    data: 'ss',
                    name: 'ss',
                    searchable: false
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    searchable: false
                },
            ]
        });
        $("#filter").click(function() {
            table.draw();
        });
    });

    $(document).ready(function() {

        // modal detail
        $('body').on('click', '#btnDetail', function() {
            var data_id = $(this).data('id');
            $.get('transaksi/' + data_id + '/edit/', function(data) {
                $('#detailLabel').html("Detail Transaksi");
                $('#detail').modal('show');
                $('#name1').val(data.name);
                $('#username1').val(data.username);
                $('#alamat1').val(data.alamat);
                $('#kode1').val(data.kode);
                $('#created_at1').val(data.created_at);
                $('#total_transaksi1').val("Rp. " + format(data.total_transaksi));
                $('#jasa_ongkir1').val("Rp. " + format(data.jasa_ongkir));
                if (data.status == "pending") {
                    $('#status_pembayaran1').val('BELUM DIBAYAR');
                } else {
                    $('#status_pembayaran1').val('SUDAH DIBAYAR');
                }
                if (data.status_transaksi == "0") {
                    $('#status_transaksi1').val('BELUM SELESAI');
                } else {
                    $('#status_transaksi1').val('SELESAI');
                }
                $.post('transaksi/detail', {
                    kode: data.kode,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(data1) {
                    table_post_row(data1);
                });
            })
        });

        // table row with ajax
        function table_post_row(res) {
            let htmlView = '';
            if (res.transaksi.length <= 0) {
                htmlView += `
       <tr>
          <td colspan="4">No data.</td>
      </tr>`;
            }
            for (let i = 0; i < res.transaksi.length; i++) {
                htmlView += `
        <tr>
           <td>` + (i + 1) + `</td>
              <td>` + res.transaksi[i].nama_produk + `</td>
               <td>Rp. ` + format(res.transaksi[i].harga_produk) + `</td>
               <td>` + res.transaksi[i].qty + `</td>
               <td>Rp. ` + format(res.transaksi[i].harga_produk * res.transaksi[i].qty) + `</td>
        </tr>`;
            }
            $('#table-detail').html(htmlView);
        }

        // modal kirim
        $('body').on('click', '#btnKirim', function() {
            var data_id = $(this).data('id');
            $.get('pengiriman/' + data_id + '/edit', function(data) {
                $('#kirimLabel').html("Kirim Barang");
                $('#btn-save').prop('disabled', false);
                $('#kirim').modal('show');
                $('#id1').val(data.id);
            })
        });
    });
</script>
@endpush