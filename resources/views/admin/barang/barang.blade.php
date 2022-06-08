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

<div class="modal fade bd-example-modal-lg" id="tambah" tabindex="-1" role="dialog" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahLabel"></h5>
            </div>
            <form action="{{route('admin.barang-tambah')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="action" id="action" value="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Nama Barang :</label>
                                <input type="text" id="nama_produk" name="nama_produk" placeholder="Masukkan Nama" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Kategori :</label>
                                <select name="kategori_id" id="kategori_id" class="form-control" required>
                                    <option value="" selected>Pilih Kategori</option>
                                    @foreach($kategori as $data)
                                    <option value="{{$data->id}}">{{$data->nama_kategori}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Harga :</label>
                                <input type="number" id="harga_produk" name="harga_produk" placeholder="Masukkan Harga" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Ukuran :</label>
                                <input type="text" id="ukuran_produk" name="ukuran_produk" placeholder="Ukuran" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Berat :</label>
                                <input type="number" id="berat_produk" name="berat_produk" placeholder="Berat" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Variasi :</label>
                                <input type="text" id="variasi_produk" name="variasi_produk" placeholder="Variasi" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Deskripsi :</label>
                                <textarea id="deskripsi_produk" name="deskripsi_produk" placeholder="Masukkan Deskripsi" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Pilih Gambar :</label>
                                <input type="file" id="foto_produk" name="foto_produk" accept="image/png, image/gif, image/jpeg" class="form-control">
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
            </div>
            <form action="{{route('admin.barang-hapus')}}" method="POST">
                @csrf
                <input type="hidden" name="id1" id="id1">
                <div class="modal-footer">
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
            </div>
            <form action="{{route('admin.barang-tampilkan')}}" method="POST">
                @csrf
                <input type="hidden" name="id2" id="id2">
                <input type="hidden" name="status" id="status" value="">
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
                    data: 'nama_produk',
                    name: 'nama_produk'
                },
                {
                    data: 'nama_kategori',
                    name: 'nama_kategori'
                },
                {
                    data: 'harga_produk',
                    name: 'harga_produk',
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
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

        $('#foto_produk').bind('change', function() {
            if (this.files[0].size >= '2048000') {
                swal("Error", "File Lebih Dari 2mb!", "error");
                $('#foto_produk').val('');
            }
        });

        // modal tambah
        $(document).on('click', '#btnTambah', function(e) {
            $('#tambahLabel').html("Tambah Barang");
            $('#tambah').modal('show');
            $('input[name=action]').val('tambah');
            $('#id').val("");
            $('#kode_produk').val("");
            $('#nama_produk').val("");
            $('#variasi_produk').val("");
            $('#berat_produk').val("");
            $('#ukuran_produk').val("");
            $('#harga_produk').val("");
            $('#deskripsi_produk').val("");
            $('#kategori_id').val("");

        });

        // modal edit
        $('body').on('click', '#btnEdit', function() {
            var data_id = $(this).data('id');
            $.get('barang/' + data_id + '/edit', function(data) {
                $('#tambahLabel').html("Edit Barang");
                $('#btn-save').prop('disabled', false);
                $('#tambah').modal('show');
                $('input[name=action]').val('edit');
                $('#id').val(data.id);
                $('#variasi_produk').val(data.variasi_produk);
                $('#nama_produk').val(data.nama_produk);
                $('#berat_produk').val(data.berat_produk);
                $('#kategori_id').val(data.kategori_id);
                $('#ukuran_produk').val(data.ukuran_produk);
                $('#harga_produk').val(data.harga_produk);
                $('#deskripsi_produk').val(data.deskripsi_produk);
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

        // modal tampilkan
        $('body').on('click', '#btnTampilkan', function() {
            var data_id = $(this).data('id');
            $.get('barang/' + data_id + '/edit', function(data) {
                if (data.status == "0") {
                    $('#tampilkanLabel').html("Tampilkan Barang");
                    $('#btn-save').prop('disabled', false);
                    $('#tampilkan').modal('show');
                    $('#id2').val(data.id);
                    $('input[name=status]').val('display');
                } else {
                    $('#tampilkanLabel').html("Hidden Barang");
                    $('#btn-save').prop('disabled', false);
                    $('#tampilkan').modal('show');
                    $('#id2').val(data.id);
                    $('input[name=status]').val('hidden');
                }
            })
        });
    });
</script>
@endpush