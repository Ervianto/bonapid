@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Data Foto Produk</h4>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0)" id="btnTambah" class="btn btn-primary btn-icon-text" style="float: right;">
                                <i class="mdi mdi-plus-box"></i>
                                Tambah Foto
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
                                <th>Nama Produk</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
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
            <form action="{{route('admin.foto-produk-tambah')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="action" id="action" value="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Barang :</label>
                                <select name="produk_id" id="produk_id" class="form-control" required>
                                    <option value="" selected>Pilih Barang</option>
                                    @foreach($produk as $data)
                                    <option value="{{$data->id}}">{{$data->nama_produk}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Gambar :</label>
                                <input type="file" id="foto_produk" name="foto_produk" class="form-control">
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
            <form action="{{route('admin.foto-produk-hapus')}}" method="POST">
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
            ajax: "{{ route('admin.foto-produk') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_produk',
                    name: 'nama_produk'
                },
                {
                    data: 'foto',
                    name: 'foto'
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

        $('#foto_produk').bind('change', function() {
            if (this.files[0].size >= '2048000') {
                swal("Error", "File Lebih Dari 2mb!", "error");
                $('#foto_produk').val('');
            }
        });

        // modal tambah
        $(document).on('click', '#btnTambah', function(e) {
            $('#tambahLabel').html("Tambah Foto Produk");
            $('#tambah').modal('show');
            $('input[name=action]').val('tambah');
            $('#id').val("");
            $('#produk_id').val("");
            $('#foto_produk').val("");
        });

        // modal edit
        $('body').on('click', '#btnEdit', function() {
            var data_id = $(this).data('id');
            $.get('foto-produk/' + data_id + '/edit', function(data) {
                $('#tambahLabel').html("Edit Foto Produk");
                $('#btn-save').prop('disabled', false);
                $('#tambah').modal('show');
                $('input[name=action]').val('edit');
                $('#id').val(data.id);
                $('#produk_id').val(data.produk_id);
            })
        });

        // modal hapus
        $('body').on('click', '#btnHapus', function() {
            var data_id = $(this).data('id');
            $.get('foto-produk/' + data_id + '/edit', function(data) {
                $('#hapusLabel').html("Hapus Foto Produk");
                $('#btn-save').prop('disabled', false);
                $('#hapus').modal('show');
                $('#id1').val(data.id);
            })
        });


    });
</script>
@endpush