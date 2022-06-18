@extends('layouts.landing')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Pre Order</h1>
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
                        <div class="mb-3">
                            <a href="{{ route('pre-order.create') }}" class="btn btn-primary p-2">Buat Pesanan</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="tablePreOrder" style="width: 100%">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Kode Pesanan</td>
                                        <td>Tanggal</td>
                                        <td>Status</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 0; @endphp
                                    @foreach ($preOrder as $row)
                                        @php $no++; @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $row->kode_pesanan }}</td>
                                            <td>{{ $row->created_at }}</td>
                                            <td>
                                                @if ($row->status == 0)
                                                    Menunggu Verifikasi
                                                @elseif($row->status == 1)
                                                    Terverfikasi & Menunggu Pembayaran
                                                @elseif($row->status == 2)
                                                    Terverfikasi & Terbayar
                                                @elseif($row->status == 3)
                                                    Dibatalkan
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->status != 3 && $row->status != 2)
                                                    <button type="button" data-toggle="modal"
                                                        data-target="#modalBatal{{ $row->id }}" class="btn btn-danger">
                                                        Batalkan
                                                    </button>
                                                @endif
                                                <a class="btn btn-info" href="{{ route('pre-order.show', $row->kode_pesanan) }}">Detail</a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modalBatal{{ $row->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah yakin membatalkan pre order {{ $row->kode_pesanan }}  ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tidak</button>
                                                        <form action="{{ url('batal-pre-order/'.$row->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">Ya</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $("#tablePreOrder").DataTable();
    </script>
@endpush
