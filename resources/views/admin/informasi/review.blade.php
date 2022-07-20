@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Data Review Barang</h4>
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
                                <th>Username</th>
                                <th>Barang</th>
                                <th>Kategori</th>
                                <th>Rating</th>
                                <th>Ulasan</th>
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

<!-- modal balas -->
<div class="modal fade bd-example-modal-lg" id="balas" tabindex="-1" role="dialog" aria-labelledby="balasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="balasLabel"></h5>
            </div>
            <form action="{{route('admin.review-balas')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="review_id" id="review_id">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="kb" class=" form-control-label">Daftar Balasan</label>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table table-dark">
                                        <tr>
                                            <td>No.</td>
                                            <td>Isi</td>
                                            <td>Foto</td>
                                        </tr>
                                    </thead>
                                    <tbody id="table-detail">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Pilih Gambar :</label>
                                <input type="file" id="foto" name="foto" placeholder="Masukkan Foto" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class=" form-control-label">Isi Balasan :</label>
                                <textarea id="isi" name="isi" placeholder="Masukkan Isi Balasan" class="form-control" required></textarea>
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
            <form action="{{route('admin.review-hapus')}}" method="POST">
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
            ajax: "{{ route('admin.review') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'username',
                    name: 'username'
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
                    data: 'bintang',
                    name: 'bintang'
                },
                {
                    data: 'ulasan',
                    name: 'ulasan'
                },
                {
                    data: 'foto_review',
                    name: 'foto_review'
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
        
        // modal edit
        $('body').on('click', '#btnBalas', function() {
            var data_id = $(this).data('id');
            $.get('review/' + data_id + '/edit', function(data) {
                $('#balasLabel').html("Balas Review");
                $('#btn-save').prop('disabled', false);
                $('#balas').modal('show');
                $('#review_id').val(data.id);
                
                $.post('review/balasan', {
                    review_id: data.id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function(data1) {
                    table_post_row(data1);
                });
            })
        });
        
     // table row with ajax
            function table_post_row(res) {
                let htmlView = '';
                if (res.review.length <= 0) {
                    htmlView += `
           <tr>
              <td colspan="4">No data.</td>
          </tr>`;
                }
                for (let i = 0; i < res.review.length; i++) {
                    htmlView += `
            <tr>
               <td>` + (i + 1) + `</td>
                  <td>` + res.review[i].isi + `</td>
                   <td><a href="https://tokobonafide.store/public/foto/balas_review/` + res.review[i].foto + `" target="_blank"><img src="https://tokobonafide.store/public/foto/balas_review/` + res.review[i].foto + `" width="300px"></img></a></td>
            </tr>`;
                }
                $('#table-detail').html(htmlView);
            }
            
        // modal hapus
        $('body').on('click', '#btnHapus', function() {
            var data_id = $(this).data('id');
            $.get('review/' + data_id + '/edit', function(data) {
                $('#hapusLabel').html("Hapus Review");
                $('#btn-save').prop('disabled', false);
                $('#hapus').modal('show');
                $('#id1').val(data.id);
            })
        });

    });
</script>
@endpush