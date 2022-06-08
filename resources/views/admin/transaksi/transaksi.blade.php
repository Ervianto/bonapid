@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Data Transaksi</h4>
                        </div>
                        <div class="col-6">
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
                                <th>Pembayaran</th>
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
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-md-center">
                        <img id="foto_produk1" class="rounded" style="width: 100px;height: 100px;object-fit: cover" src="" alt="">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kode Barang :</label>
                            <input type="text" class="form-control" id="kode_produk1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Nama Barang :</label>
                            <input type="text" class="form-control" id="nama_produk1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Harga :</label>
                            <input type="text" class="form-control" id="harga_produk1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Ukuran :</label>
                            <input type="text" class="form-control" id="ukuran_produk1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Variasi :</label>
                            <input type="text" class="form-control" id="variasi_produk1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Berat :</label>
                            <input type="text" class="form-control" id="berat_produk1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kategori :</label>
                            <input type="text" class="form-control" id="nama_kategori1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Deskripsi :</label>
                            <textarea class="form-control" id="deskripsi_produk1" rows="4" cols="50" readonly></textarea>
                        </div>
                    </div>
                </div>
            </div>
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
            <form action="{{route('admin.transaksi-hapus')}}" method="POST">
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
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            "scrollX": true,
            ajax: "{{ route('admin.transaksi') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kode',
                    name: 'kode'
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
                    data: 'total_transaksi',
                    name: 'total_transaksi',
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                },
                {
                    data: 'status_pembayaran',
                    name: 'status_pembayaran',
                    searchable: false
                },
                {
                    data: 'status_trx',
                    name: 'status_trx',
                    searchable: false
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    searchable: false
                },
            ]
        });
    });

    $(document).ready(function() {

        // modal detail
        $('body').on('click', '#btnDetail', function() {
            var data_id = $(this).data('id');
            $.get('barang/' + data_id + '/edit/', function(data) {
                $('#detailLabel').html("Detail Barang");
                $('#detail').modal('show');
                $('#kode_produk1').val(data.kode_produk);
                $('#nama_produk1').val(data.nama_produk);
                $('#nama_kategori1').val(data.nama_kategori);
                $('#harga_produk1').val(format(data.harga_produk));
                $('#variasi_produk1').val(data.variasi_produk);
                $('#ukuran_produk1').val(data.ukuran_produk);
                $('#berat_produk1').val(data.berat_produk);
                $('#deskripsi_produk1').val(data.deskripsi_produk);
                $("#foto_produk1").attr("src", "http://localhost/ecommerce/public/foto/produk/" + data.foto_produk);
            })
        });

        // modal hapus
        $('body').on('click', '#btnHapus', function() {
            var data_id = $(this).data('id');
            $.get('barang/' + data_id + '/edit', function(data) {
                $('#hapusLabel').html("Hapus Barang");
                $('#btn-save').prop('disabled', false);
                $('#hapus').modal('show');
                $('#id1').val(data.id);
            })
        });
    });
</script>
@endpush