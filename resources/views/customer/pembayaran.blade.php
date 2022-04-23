@extends('layouts.landing')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Pembayaran</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                Pembayaran
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Detail Transaksi</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="order-details-body">
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                        @php $berat = 0; @endphp
                                        @foreach ($cart as $row)
                                            @php $berat = $berat + $row->attributes->weight; @endphp
                                            <tr>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ rupiah($row->price) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody class="order-details-body">
                                        <tr>
                                            <th>Ongkir</th>
                                            <th>Total</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $kurir }}</td>
                                            <td>{{ rupiah($jasaOngkir) }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody class="checkout-details">
                                        <tr>
                                            <td>Berat (gram) </td>
                                            <td id="totalBerat">{{ $berat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Perkiraan Sampai </td>
                                            <td>{{ $lamaSampai }}</td>
                                        </tr>
                                        <tr>
                                            <td>Subtotal</td>
                                            <td><strong>{{ rupiah(Cart::getTotal() + $jasaOngkir) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" id="pay-button" class="btn btn-primary">Bayar</button>
                            </div>
                            <form action="{{ url('payment_midtrains') }}" id="submitForm" method="POST">
                                @csrf
                                <input type="hidden" name="json" id="json_callback" />
                                <input type="hidden" name="kurir" id="kurir" value="{{ $kurir }}" />
                                <input type="hidden" name="lama_sampai" id="lama_sampai" value="{{ $lamaSampai }}" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    sendResponseToForm(result);
                },
                onPending: function(result) {
                    sendResponseToForm(result);
                },
                onError: function(result) {
                    console.log(result);
                    sendResponseToForm(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });

        function sendResponseToForm(result){
            document.getElementById("json_callback").value = JSON.stringify(result);
            $("#submitForm").submit();
            // console.log(document.getElementById("json_callback").value);
        }
    </script>
@endpush
