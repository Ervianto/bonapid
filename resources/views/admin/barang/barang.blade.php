@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Data Barang</h4>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0)" id="btnTambah" class="btn btn-primary btn-icon-text" style="float: right;">
                                <i class="mdi mdi-plus-box"></i>
                                Tambah Barang
                            </a>
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
                                <th>Kategori</th>
                                <th>Harga</th>
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
                        <img id="barang_gambar1" class="rounded" style="width: 100px;height: 100px;object-fit: cover" src="" alt="">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kode Barang :</label>
                            <input type="text" class="form-control" id="barang_kode1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Nama Barang :</label>
                            <input type="text" class="form-control" id="barang_nama1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Satuan :</label>
                            <input type="text" class="form-control" id="barang_satuan1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Quantity :</label>
                            <input type="text" class="form-control" id="barang_stok1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Tanggal :</label>
                            <input type="text" class="form-control" id="barang_tgl1" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="tambah" tabindex="-1" role="dialog" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahLabel"></h5>
            </div>
            <form action="{{route('admin.barang-tambah')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="barang_id" id="barang_id">
                <input type="hidden" name="action" id="action" value="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Nama Barang :</label>
                                <input type="text" id="barang_nama" name="barang_nama" placeholder="Masukkan Nama Barang" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Satuan :</label>
                                <select name="barang_satuan" id="barang_satuan" class="form-control" required>
                                    <option value="" selected>---</option>
                                    <option value="Botol 100ml">Botol 100ml</option>
                                    <option value="Botol 200ml">Botol 200ml</option>
                                    <option value="Plastik">Plastik</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Quantity :</label>
                                <input type="number" id="barang_stok" name="barang_stok" placeholder="Masukkan Quantity" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Tanggal :</label>
                                <input type="date" id="barang_tgl" name="barang_tgl" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Pilih Gambar :</label>
                                <input type="file" id="barang_gambar" name="barang_gambar" accept="image/png, image/gif, image/jpeg" class="form-control">
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
<!-- end modal tambah & edit -->
<!-- modal hapus -->
<div class="modal fade bd-example-modal-lg" id="hapus" tabindex="-1" role="dialog" aria-labelledby="hapusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.barang-hapus')}}" method="POST">
                @csrf
                <input type="hidden" name="barang_id1" id="barang_id1">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal tampilkan -->
<div class="modal fade bd-example-modal-lg" id="tampilkan" tabindex="-1" role="dialog" aria-labelledby="tampilkanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tampilkanLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.barang-tampilkan')}}" method="POST">
                @csrf
                <input type="hidden" name="barang_id2" id="barang_id2">
                <input type="hidden" name="status" id="status" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
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
            ajax: "{{ route('admin.barang') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kode_produk',
                    name: 'kode_produk'
                },
                {
                    data: 'produk_nama',
                    name: 'produk_nama'
                },
                {
                    data: 'kategori_produk',
                    name: 'kategori_produk'
                },
                {
                    data: 'harga_produk',
                    name: 'harga_produk'
                },
                {
                    data: 'status',
                    name: 'status',
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
                $('#barang_kode1').val(data.barang_kode);
                $('#barang_nama1').val(data.barang_nama);
                $('#barang_satuan1').val(data.barang_satuan);
                $('#barang_stok1').val(data.barang_stok);
                $('#barang_tgl1').val(data.barang_tgl);
                $("#barang_gambar1").attr("src", "http://localhost/ecommerce-susu/public/images/" + data.barang_gambar);
            })
        });

        $('#barang_gambar').bind('change', function() {
            if (this.files[0].size >= '2048000') {
                swal("Error", "File Lebih Dari 2mb!", "error");
                $('#barang_gambar').val('');
            }
        });

        // modal tambah
        $(document).on('click', '#btnTambah', function(e) {
            $('#tambahLabel').html("Tambah Barang");
            $('#tambah').modal('show');
            $('input[name=action]').val('tambah');
            $('#barang_id').val("");
            $('#barang_kode').val("");
            $('#barang_nama').val("");
            $('#barang_satuan').val("");
            $('#barang_stok').val("");

        });

        // modal edit
        $('body').on('click', '#btnEdit', function() {
            var data_id = $(this).data('id');
            $.get('barang/' + data_id + '/edit', function(data) {
                $('#tambahLabel').html("Edit Barang");
                $('#btn-save').prop('disabled', false);
                $('#tambah').modal('show');
                $('input[name=action]').val('edit');
                $('#barang_id').val(data.barang_id);
                $('#barang_satuan').val(data.barang_satuan);
                $('#barang_nama').val(data.barang_nama);
                $('#barang_stok').val(data.barang_stok);
                $('#barang_tgl').val(data.barang_tgl);
            })
        });

        // modal hapus
        $('body').on('click', '#btnHapus', function() {
            var data_id = $(this).data('id');
            $.get('barang/' + data_id + '/edit', function(data) {
                $('#hapusLabel').html("Hapus Barang");
                $('#btn-save').prop('disabled', false);
                $('#hapus').modal('show');
                $('#barang_id1').val(data.barang_id);
            })
        });

        // modal tampilkan
        $('body').on('click', '#btnTampilkan', function() {
            var data_id = $(this).data('id');
            $.get('barang/' + data_id + '/edit', function(data) {
                if (data.barang_status == "0") {
                    $('#tampilkanLabel').html("Tampilkan Barang");
                    $('#btn-save').prop('disabled', false);
                    $('#tampilkan').modal('show');
                    $('#barang_id2').val(data.barang_id);
                    $('input[name=status]').val('display');
                } else {
                    $('#tampilkanLabel').html("Hidden Barang");
                    $('#btn-save').prop('disabled', false);
                    $('#tampilkan').modal('show');
                    $('#barang_id2').val(data.barang_id);
                    $('input[name=status]').val('hidden');
                }
            })
        });
    });
</script>
@endpush