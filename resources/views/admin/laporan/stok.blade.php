@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="card-title">Laporan Stok Barang</h4>
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
                            <a href="{{route('admin.laporan-stok')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-refresh"></i> </a>
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
                                <th>Ukuran</th>
                                <th>Variasi</th>
                                <th>Berat</th>
                                <th>Harga</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
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
            "paging": false,
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            ajax: {
                url: "{{ route('admin.laporan-stok') }}",
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
                    data: 'ukuran_produk',
                    name: 'ukuran_produk'
                },
                {
                    data: 'variasi_produk',
                    name: 'variasi_produk'
                },
                {
                    data: 'berat_produk',
                    name: 'berat_produk'
                },
                {
                    data: 'harga_produk',
                    name: 'harga_produk',
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                },
                {
                    data: 'stok_produk',
                    name: 'stok_produk'
                },
            ]
        });
        $("#filter").click(function() {
            table.draw();
        });
    });
</script>
@endpush