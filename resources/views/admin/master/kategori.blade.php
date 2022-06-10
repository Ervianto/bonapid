@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Data Kategori</h4>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0)" id="btnTambah" class="btn btn-primary btn-icon-text" style="float: right;">
                                <i class="mdi mdi-plus-box"></i>
                                Tambah Kategori
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
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal tambah -->
<div class="modal fade bd-example-modal-lg" id="tambah" tabindex="-1" role="dialog" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden=" true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.kategori-tambah')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="action" id="action" value="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Nama Kategori :</label>
                                <input type="text" id="nama_kategori" name="nama_kategori" placeholder="Masukkan Nama Kategori" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
            <form action="{{route('admin.kategori-hapus')}}" method="POST">
                @csrf
                <input type="hidden" name="id1" id="id1">
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
            ajax: "{{ route('admin.kategori') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_kategori',
                    name: 'nama_kategori'
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

        // modal tambah
        $(document).on('click', '#btnTambah', function(e) {
            $('#tambahLabel').html("Tambah Kategori");
            $('#tambah').modal('show');
            $('input[name=action]').val('tambah');
            $('#id').val("");
            $('#nama_kategori').val("");
        });

        // modal edit
        $('body').on('click', '#btnEdit', function() {
            var data_id = $(this).data('id');
            $.get('kategori/' + data_id + '/edit', function(data) {
                $('#tambahLabel').html("Edit Kategori");
                $('#btn-save').prop('disabled', false);
                $('#tambah').modal('show');
                $('input[name=action]').val('edit');
                $('#id').val(data.id);
                $('#nama_kategori').val(data.nama_kategori);
            })
        });

        // modal hapus
        $('body').on('click', '#btnHapus', function() {
            var data_id = $(this).data('id');
            $.get('kategori/' + data_id + '/edit', function(data) {
                $('#hapusLabel').html("Hapus Kategori");
                $('#btn-save').prop('disabled', false);
                $('#hapus').modal('show');
                $('#id1').val(data.id);
            })
        });

    });
</script>
@endpush