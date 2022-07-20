@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Data Stok Barang</h4>
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
                                <th>Nama</th>
                                <th>Stok</th>
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
<!-- modal update -->
<div class="modal fade bd-example-modal-lg" id="update" tabindex="-1" role="dialog" aria-labelledby="updateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateLabel"></h5>
            </div>
            <form action="{{route('admin.barang-tambah')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="action" id="action">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Tanggal :</label>
                                <input type="date" id="tgl" name="tgl" placeholder="Masukkan Tanggal" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Jumlah Stok :</label>
                                <input type="number" id="stok_produk" name="stok_produk" placeholder="Masukkan Jumlah Stok" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal update & edit -->
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
            ajax: "{{ route('admin.stok') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kode_produk',
                    name: 'kode_produk'
                },
                {
                    data: 'nama_produk',
                    name: 'nama_produk'
                },
                {
                    data: 'stok',
                    name: 'stok',
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
            })
        });

        // modal edit
        $('body').on('click', '#btnEdit', function() {
            var data_id = $(this).data('id');
            $.get('barang/' + data_id + '/edit', function(data) {
                $('#updateLabel').html("Update Stok");
                $('#btn-save').prop('disabled', false);
                $('#update').modal('show');
                $('input[name=action]').val('update-stok');
                $('#id').val(data.id);
                $('#stok_produk').val(data.stok_produk);
            })
        });
    });
</script>
@endpush