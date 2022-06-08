@extends('layouts.landing')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Konfirmasi Barang Sampai</h1>
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
                        </table><br />
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
                        </table><br />
                        <h4>Pembayaran</h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Pembayaran</th>
                                    <th>VA</th>
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
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{ $transaksi->jasa_ongkir + $total }}
                                    </td>
                                    <td>{{ $transaksi->status == 'pending' ? 'Belum Terbayar' : 'Terbayar' }}</td>
                                </tr>
                            </tbody>
                        </table><br />
                        @if ($transaksi->status_sampai == 0)
                            <h4>Konfirmasi Barang Sampai</h4>
                            <form method="POST" action="{{ url('store_brg_sampai/' . $transaksi->kode) }}">
                                @csrf
                                <div class="form-group">
                                    <label>Status Barang :</label><br />
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="inlineRadio1" @if($transaksi->status_sampai == 0) checked @endif value="0">
                                        <label class="form-check-label" for="inlineRadio1">Belum Sampai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="inlineRadio2" value="1">
                                        <label class="form-check-label" for="inlineRadio2">Sampai</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="keterangan" placeholder="Keterangan apabila diperlukan"></textarea>
                                </div>
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </form>
                        @else
                            <div class="alert alert-success" role="alert">
                              Barang telah sampai
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
