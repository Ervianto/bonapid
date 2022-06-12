@extends('layouts.landing')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Detail Transaksi</h1>
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
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $jumlah = 0;
                                @endphp
                                @foreach ($detailTransaksi as $row)
                                    @php $total = $total + ($row->harga_produk * $row->qty); @endphp
                                    @php $jumlah = $jumlah + $row->qty; @endphp
                                    <tr>
                                        <td>{{ $row->nama_produk }}</td>
                                        <td>{{ $row->ukuran_produk }}</td>
                                        <td>{{ $row->variasi_produk }}</td>
                                        <td>{{ rupiah($row->harga_produk) }}</td>
                                        <td>{{ $row->qty }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3">Total</th>
                                    <td>{{ rupiah($total) }}</td>
                                    <td>{{ $jumlah }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h4>Ongkir</h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Jasa</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $transaksi->kurir }}</td>
                                    <td>{{ rupiah($transaksi->jasa_ongkir) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <h4>Pembayaran</h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Pembayaran</th>
                                    <th>Akun Pembayaran</th>
                                    <th>Total Dibayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @if ($transaksi->payment_type == 'credit_card')
                                            Credit Card
                                        @elseif($transaksi->payment_type == 'gopay')
                                            Gopay
                                        @elseif($transaksi->payment_type == 'qris')
                                            QRIS
                                        @elseif($transaksi->payment_type == 'shopeepay')
                                            Shopeepay
                                        @elseif($transaksi->payment_type == 'bank_transfer')
                                            Bank Transfer
                                        @elseif($transaksi->payment_type == 'echannel')
                                            Mandiri Bill
                                        @elseif($transaksi->payment_type == 'bca_klikpay')
                                            BCA Klikpay
                                        @elseif($transaksi->payment_type == 'bca_klikbca')
                                            Klik BCA
                                        @elseif($transaksi->payment_type == 'cimb_clicks')
                                            CIMB Clicks
                                        @elseif($transaksi->payment_type == 'danamon_online')
                                            Danamon Online Banking
                                        @elseif($transaksi->payment_type == 'cstore')
                                            Indomaret / Alfamart
                                        @elseif($transaksi->payment_type == 'akulaku')
                                            Akulaku
                                        @elseif($transaksi->payment_type == 'bri_epay')
                                            BRImo
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaksi->va_number != null)
                                            @php $va = json_decode($transaksi->va_number) @endphp
                                            <?= 'Bank : ' . $va[0]->bank . '<br/>' . 'VA:' . $va[0]->va_number ?>
                                        @elseif($transaksi->payment_type == 'echannel')
                                            Bill Key : {{ $transaksi->bill_key }}<br/>
                                            Bill Code : {{ $transaksi->biller_code }}
                                        @elseif($transaksi->payment_type == 'cstore')
                                            Payment Code : {{ $transaksi->payment_code }}
                                        @elseif($transaksi->payment_type == 'gopay')
                                            QR Code Pembayaran : <a target="_blank" href="https://api.sandbox.midtrans.com/v2/gopay/{{ $item->transaction_id }}/qr-code">
                                            Lihat QR code</a>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $transaksi->jasa_ongkir + $total }}
                                    </td>
                                    <td>{{ $transaksi->status == 'pending' ? 'Belum Terbayar' :  'Terbayar'}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Konfirmasi Pembayaran</td>
                                    <td>
                                        @if($transaksi->status == 'pending')
                                            <a class="btn btn-block btn-primary" href="{{ url("konfirmasi_pembayaran/".$transaksi->order_id) }}">
                                                Konfirmasi Pembayaran
                                            </a>
                                        @else 
                                            <span class="text-success">Sudah Terbayar</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
