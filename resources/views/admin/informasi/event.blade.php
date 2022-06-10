@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Data Event</h4>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0)" id="btnTambah" class="btn btn-primary btn-icon-text" style="float: right;">
                                <i class="mdi mdi-plus-box"></i>
                                Tambah Event
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
                                <th>Foto</th>
                                <th>Isi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
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

<!-- modal tambah -->
<div class="modal fade bd-example-modal-lg" id="tambah" tabindex="-1" role="dialog" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahLabel"></h5>
            </div>
            <form action="{{route('admin.event-tambah')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="action" id="action" value="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Nama Event :</label>
                                <input type="text" id="nama_event" name="nama_event" placeholder="Masukkan Nama Event" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Foto Event :</label>
                                <input type="file" id="foto_event" name="foto_event" placeholder="Masukkan Foto Event" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Isi Event :</label>
                                <textarea id="isi_event" name="isi_event" placeholder="Masukkan Isi Event" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Tanggal Mulai Event :</label>
                                <input type="date" id="tanggal_mulai_event" name="tanggal_mulai_event" placeholder="Masukkan Tanggal Mulai Event" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Tanggal Selesai Event :</label>
                                <input type="date" id="tanggal_selesai_event" name="tanggal_selesai_event" placeholder="Masukkan Tanggal Selesai Event" class="form-control">
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
            <form action="{{route('admin.event-hapus')}}" method="POST">
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
            ajax: "{{ route('admin.event') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_event',
                    name: 'nama_event'
                },
                {
                    data: 'foto',
                    name: 'foto'
                },
                {
                    data: 'isi_event',
                    name: 'isi_event'
                },
                {
                    data: 'tanggal_mulai_event',
                    name: 'tanggal_mulai_event'
                },
                {
                    data: 'tanggal_selesai_event',
                    name: 'tanggal_selesai_event'
                },
                {
                    data: 'status',
                    name: 'status'
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
            $('#tambahLabel').html("Tambah Event");
            $('#tambah').modal('show');
            $('input[name=action]').val('tambah');
            $('#id').val("");
            $('#nama_event').val("");
            $('#foto_event').val("");
            $('#isi_event').val("");
            $('#tanggal_mulai_event').val("");
            $('#tanggal_selesai_event').val("");
        });

        // modal edit
        $('body').on('click', '#btnEdit', function() {
            var data_id = $(this).data('id');
            $.get('event/' + data_id + '/edit', function(data) {
                $('#tambahLabel').html("Edit Event");
                $('#btn-save').prop('disabled', false);
                $('#tambah').modal('show');
                $('input[name=action]').val('edit');
                $('#id').val(data.id);
                $('#nama_event').val(data.nama_event);
                $('#isi_event').val(data.isi_event);
                $('#tanggal_mulai_event').val(data.tanggal_mulai_event);
                $('#tanggal_selesai_event').val(data.tanggal_selesai_event);
            })
        });

        // modal hapus
        $('body').on('click', '#btnHapus', function() {
            var data_id = $(this).data('id');
            $.get('event/' + data_id + '/edit', function(data) {
                $('#hapusLabel').html("Hapus Event");
                $('#btn-save').prop('disabled', false);
                $('#hapus').modal('show');
                $('#id1').val(data.id);
            })
        });

        // status
        $('body').on('change', '#cbStatus', function(e) {
            e.preventDefault();
            var ele = $(this);
            var id = ele.parents("tr").find(".status").attr("data-id");
            console.log(id);

            if (this.checked) {
                $.ajax({
                    url: "{{ route('admin.event-update') }}",
                    method: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        is_active: '1'
                    },
                    success: function(response) {
                        // window.location.reload();
                        console.log(response);
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('admin.event-update') }}",
                    method: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        is_active: '0'
                    },
                    success: function(response) {
                        // window.location.reload();
                        console.log(response);
                    }
                });
            }
        });
    });
</script>
@endpush