@extends('layouts.landing')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Tambah Pre Order</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="checkout-section mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card card-body">
                        <h3>Isikan data pesanan dibawah ini!</h3>
                        <form method="POST" action="{{ route('pre-order.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Barang</label>
                                        <select style="width: 100%;" class="produk form-control" name="produk_id"
                                            id="produk_id" required>
                                            <option value="">Pilih Salah Satu</option>
                                            @foreach ($produk as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->nama_produk . ' | ' . $item->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jumlah Barang</label>
                                        <input style="width: 100%;" class="form-control" name="qty" type="number"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Variasi Barang</label>
                                        <input style="width: 100%;" class="form-control" name="variasi" type="text"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ukuran Barang</label>
                                        <input style="width: 100%;" class="form-control" name="ukuran" type="text"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Keterangan Pesanan</label>
                                        <textarea style="width: 100%;" class="form-control" name="keterangan" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </form>
                    </div>

                    <div class="card card-body mt-5 mb-5">
                        <div class="table-responsive mt-3">
                            <h4>Daftar barang yang diorder</h4>
                            <table class="table" id="tablePreOrder" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Barang</td>
                                        <td>Jumlah</td>
                                        <td>Variasi</td>
                                        <td>Ukuran</td>
                                        <td>Keterangan</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 0; @endphp
                                    @foreach ($detPreOrder as $row)
                                        @php $no++; @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $row->nama_produk }}</td>
                                            <td>{{ $row->qty }}</td>
                                            <td>{{ $row->variasi }}</td>
                                            <td>{{ $row->ukuran }}</td>
                                            <td>{{ $row->keterangan }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#modalEdit{{ $row->id }}">
                                                    Edit
                                                </button>
                                                <button type="button" data-toggle="modal"
                                                    data-target="#modalHapus{{ $row->id }}" class="btn btn-danger">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modalHapus{{ $row->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                                                            Produk</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah yakin menghapus produk {{ $row->nama_produk }} dari
                                                            daftar pre order ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tidak</button>
                                                        <form action="{{ route('pre-order.destroy', $row->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-primary">Ya</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="modalEdit{{ $row->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('pre-order.update', $row->id) }}">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="form-group">
                                                                <label>Nama Produk</label>
                                                                <input type="text" readonly class="form-control"
                                                                    value="{{ $row->nama_produk }}" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Jumlah Produk</label>
                                                                <input type="number" style="width: 100%;"
                                                                    class="form-control" name="qty"
                                                                    value="{{ $row->qty }}" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Variasi Produk</label>
                                                                <input type="text" class="form-control" name="variasi"
                                                                    value="{{ $row->variasi }}" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Ukuran Produk</label>
                                                                <input type="text" class="form-control" name="ukuran"
                                                                    value="{{ $row->ukuran }}" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Keterangan</label>
                                                                <textarea class="form-control" name="keterangan">{{ $row->keterangan }}</textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Tutup</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5">
                            @if (count($detPreOrder) > 0)
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#finishOrder">
                                    Selesaikan Pre Order
                                </button>
                            @endif
                        </div>

                        <div class="modal fade" id="finishOrder" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('finish-pre-order') }}" method="POST">
                                            @csrf
                                            <p>Pastikan semua data telah benar sebelum melakukan pre order</p>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tidak</button>
                                            <button type="submit" class="btn btn-primary">Sudah Benar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.produk').select2();
            $("#tablePreOrder").DataTable();
        });
    </script>
@endpush
