@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="card-title">Data Pre Order</h4>
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
                            <a href="{{route('admin.preorder')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-refresh"></i> </a>
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
                                <th>Total</th>
                                <th>Status</th>
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
                            <label class="form-control-label">Kode :</label>
                            <input type="text" class="form-control" id="kode_pesanan1" readonly>
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
                        <label for="kb" class=" form-control-label">Detail Preorder</label>
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
                            <input type="text" class="form-control" id="total1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Status :</label>
                            <input type="text" class="form-control" id="status1" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal update -->
<div class="modal fade bd-example-modal-lg" id="update" tabindex="-1" role="dialog" aria-labelledby="updateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateLabel"></h5>
            </div>
            <form action="{{route('admin.preorder-update')}}" method="POST">
                @csrf
                <input type="hidden" name="id1" id="id1">
                <input type="hidden" name="action" id="action">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal hapus -->
<div class="modal fade bd-example-modal-lg" id="hapus" tabindex="-1" role="dialog" aria-labelledby="hapusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusLabel"></h5>
            </div>
            <form action="{{route('admin.preorder-hapus')}}" method="POST">
                @csrf
                <input type="hidden" name="id2" id="id2">
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
                url: "{{ route('admin.preorder') }}",
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
                    data: 'kode_pesanan',
                    name: 'kode_pesanan'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'total',
                    name: 'total',
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                },
                {
                    data: 'st',
                    name: 'st',
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
            $.get('preorder/' + data_id + '/edit/', function(data) {
                $('#detailLabel').html("Detail Pre Order");
                $('#detail').modal('show');
                $('#name1').val(data.name);
                $('#username1').val(data.username);
                $('#alamat1').val(data.alamat);
                $('#kode_pesanan1').val(data.kode_pesanan);
                $('#created_at1').val(data.created_at);
                $('#total1').val("Rp. " + format(data.total));
                if (data.status == "0") {
                    $('#status1').val('Menunggu Verifikasi');
                } else if (data.status == "1") {
                    $('#status1').val('Terverifikasi');
                } else if (data.status == "2") {
                    $('#status1').val('Terbayar');
                } else if (data.status == "3") {
                    $('#status1').val('Batal');
                }
                $.post('preorder/detail', {
                    kode_pesanan: data.kode_pesanan,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(data1) {
                    table_post_row(data1);
                });
            })
        });

        // table row with ajax
        function table_post_row(res) {
            let htmlView = '';
            if (res.detail.length <= 0) {
                htmlView += `
       <tr>
          <td colspan="4">No data.</td>
      </tr>`;
            }
            for (let i = 0; i < res.detail.length; i++) {
                htmlView += `
        <tr>
           <td>` + (i + 1) + `</td>
              <td>` + res.detail[i].nama_produk + `</td>
               <td>Rp. ` + format(res.detail[i].harga_produk) + `</td>
               <td>` + res.detail[i].qty + `</td>
               <td>Rp. ` + format(res.detail[i].harga_produk * res.detail[i].qty) + `</td>
        </tr>`;
            }
            $('#table-detail').html(htmlView);
        }

        // modal verif
        $('body').on('click', '#btnVerif', function() {
            var data_id = $(this).data('id');
            $.get('preorder/' + data_id + '/edit', function(data) {
                $('#updateLabel').html("Verifikasi Pre Order");
                $('#btn-save').prop('disabled', false);
                $('#update').modal('show');
                $('#id1').val(data.id);
                $('input[name=action]').val('verif');
            })
        });
        // modal tolak
        $('body').on('click', '#btnTolak', function() {
            var data_id = $(this).data('id');
            $.get('preorder/' + data_id + '/edit', function(data) {
                $('#updateLabel').html("Tolak Pre Order");
                $('#btn-save').prop('disabled', false);
                $('#update').modal('show');
                $('#id1').val(data.id);
                $('input[name=action]').val('tolak');
            })
        });

        // modal hapus
        $('body').on('click', '#btnHapus', function() {
            var data_id = $(this).data('id');
            $.get('preorder/' + data_id + '/edit', function(data) {
                $('#hapusLabel').html("Hapus Pre Order");
                $('#btn-save').prop('disabled', false);
                $('#hapus').modal('show');
                $('#id2').val(data.kode_pesanan);
            })
        });
    });
</script>
@endpush