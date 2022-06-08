@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Data User</h4>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0)" id="btnTambah" class="btn btn-primary btn-icon-text" style="float: right;">
                                <i class="mdi mdi-plus-box"></i>
                                Tambah User
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
                                <th>Name</th>
                                <th>Username</th>
                                <th>Alamat</th>
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
                            <label class="form-control-label">Nama :</label>
                            <input type="text" class="form-control" id="name1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Username :</label>
                            <input type="text" class="form-control" id="alamat1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Alamat :</label>
                            <input type="text" class="form-control" id="alamat1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kota :</label>
                            <input type="text" class="form-control" id="kota1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Provinsi :</label>
                            <input type="text" class="form-control" id="provinsi1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kode Pos :</label>
                            <input type="text" class="form-control" id="kode_pos1" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Email :</label>
                            <input type="text" class="form-control" id="email1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Telepon :</label>
                            <input type="text" class="form-control" id="telepon1" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Role :</label>
                            <input type="text" class="form-control" id="role1" readonly>
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
            <form action="{{route('admin.user-tambah')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="action" id="action" value="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" form-control-label">Nama :</label>
                                <input type="text" id="name" name="name" placeholder="Masukkan Nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" form-control-label">Username :</label>
                                <input type="text" id="username" name="username" placeholder="Masukkan Username" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Alamat :</label>
                                <textarea id="alamat" name="alamat" placeholder="Masukkan Alamat" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" form-control-label">Provinsi :</label>
                                <select name="province_id" id="province_id" class="form-control">
                                    <option value="" selected>---</option>
                                    @foreach($province as $data)
                                    <option value="{{$data->province_id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" form-control-label">Kota :</label>
                                <select name="city_id" id="city_id" class="form-control">
                                    <option value="" selected>---</option>
                                    @foreach($city as $data)
                                    <option value="{{$data->city_id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" form-control-label">Kode Pos :</label>
                                <input type="number" id="kode_pos" name="kode_pos" placeholder="Masukkan Kode Pos" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" form-control-label">Telepon :</label>
                                <input type="password" id="password" name="password" placeholder="Masukkan Password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" form-control-label">Email :</label>
                                <input type="email" id="email" name="email" placeholder="Masukkan Email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class=" form-control-label">Password :</label>
                                <input type="password" id="password" name="password" placeholder="Masukkan Password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Role :</label>
                                <select name="role" id="role" class="js-example-basic-single w-100" style="width: 100%;" required>
                                    <option value="" selected>---</option>
                                    <option value="admin">admin</option>
                                    <option value="customer">customer</option>
                                </select>
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
            <form action="{{route('admin.user-hapus')}}" method="POST">
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
            ajax: "{{ route('admin.user') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
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
            $.get('user/' + data_id + '/edit/', function(data) {
                $('#detailLabel').html("Detail User");
                $('#detail').modal('show');
                $('#name1').val(data.name);
                $('#username1').val(data.username);
                $('#email1').val(data.email);
                $('#alamat1').val(data.alamat);
                $('#kode_pos1').val(data.kode_pos);
                $('#city_id1').val(data.city_id);
                $('#province_id1').val(data.province_id);
                $('#telepon1').val(data.telepon);
                $('#role1').val(data.role);
                if (data.status == 1) {
                    $('#status1').val('Aktif');
                } else {
                    $('#status1').val('Tidak Aktif');
                }
            })
        });
        // modal tambah
        $(document).on('click', '#btnTambah', function(e) {
            $('#tambahLabel').html("Tambah User");
            $('#tambah').modal('show');
            $('input[name=action]').val('tambah');
            $('#id').val("");
            $('#name').val("");
            $('#username').val("");
            $('#email').val("");
            $('#alamat').val("");
            $('#telepon').val("");
            $('#role').val("").trigger('change');
            $('#password').val("");
            $('#city_id').val("");
            $('#province_id').val("");
            $('#kode_pos').val("");
        });

        // modal edit
        $('body').on('click', '#btnEdit', function() {
            var data_id = $(this).data('id');
            $.get('user/' + data_id + '/edit', function(data) {
                $('#tambahLabel').html("Edit User");
                $('#btn-save').prop('disabled', false);
                $('#tambah').modal('show');
                $('input[name=action]').val('edit');
                $('#id').val(data.id);
                $('#role').val(data.role).trigger('change');
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#username').val(data.username);
                $('#alamat').val(data.alamat);
                $('#city_id').val(data.city_id);
                $('#province_id').val(data.province_id);
                $('#telepon').val(data.telepon);
                $('#kode_pos').val(data.kode_pos);
            })
        });

        // modal hapus
        $('body').on('click', '#btnHapus', function() {
            var data_id = $(this).data('id');
            $.get('user/' + data_id + '/edit', function(data) {
                $('#hapusLabel').html("Hapus User");
                $('#btn-save').prop('disabled', false);
                $('#hapus').modal('show');
                $('#id1').val(data.id);
            })
        });

        // update status

        $('body').on('change', '#cbStatus', function(e) {
            e.preventDefault();
            var ele = $(this);
            var id = ele.parents("tr").find(".status").attr("data-id");
            console.log(id);

            if (this.checked) {
                $.ajax({
                    url: "{{ route('admin.user-update') }}",
                    method: "patch",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").find(".status").attr("data-id"),
                        status: '1'
                    },
                    success: function(response) {
                        // window.location.reload();
                        console.log(response);
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('admin.user-update') }}",
                    method: "patch",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").find(".status").attr("data-id"),
                        status: '0'
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