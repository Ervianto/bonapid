@extends('layouts.landing')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Detail Pre Order</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-section mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-body">
                        <h4>Detail Produk</h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Ukuran</th>
                                    <th>Variasi</th>
                                    <th>Keterangan</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $jumlah = 0;
                                @endphp
                                @foreach ($detPreOrder as $row)
                                    @php $total = $total + ($row->harga * $row->qty); @endphp
                                    @php $jumlah = $jumlah + $row->qty; @endphp
                                    <tr>
                                        <td>{{ $row->nama_produk }}</td>
                                        <td>{{ $row->ukuran }}</td>
                                        <td>{{ $row->variasi }}</td>
                                        <td>{{ $row->keterangan }}</td>
                                        <td>{{ rupiah($row->harga) }}</td>
                                        <td>{{ $row->qty }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="4">Total</th>
                                    <td>{{ rupiah($total) }}</td>
                                    <td>{{ $jumlah }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-body">
                        <h4>Pre Order</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Kode Pre Order</th>
                                <td>{{ $preOrder->kode_pesanan }}</td>
                            </tr>
                            <tr>
                                <th>Status Pre Order</th>
                                <td>
                                    @if ($preOrder->status == 0)
                                        Menunggu Verifikasi
                                    @elseif($preOrder->status == 1)
                                        Terverfikasi & Menunggu Pembayaran
                                    @elseif($preOrder->status == 2)
                                        Terverfikasi & Terbayar
                                    @elseif($preOrder->status == 3)
                                        Dibatalkan
                                    @endif
                                </td>
                            </tr>
                            @if ($preOrder->status == 1)
                                <tr>
                                    <th>Lanjut Pembayaran</th>
                                    <td>
                                        <form method="POST" action="{{ url('billing-address-pre-order') }}">
                                            @csrf
                                            <input type="hidden" name="kode_pesanan" value="{{ $preOrder->kode_pesanan }}" />
                                            <button class="btn btn-primary" type="submit">Bayar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
