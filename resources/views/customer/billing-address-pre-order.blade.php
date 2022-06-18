@extends('layouts.landing')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Checkout Belanja</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Billing Address
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample" style="">
                                    <div class="card-body">
                                        <div class="billing-address-form">

                                            <div class="form-group">
                                                <label>Penerima</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ Auth::user()->name }}" />
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ Auth::user()->email }}" />
                                            </div>
                                            <div class="form-group">
                                                <label>Telepon</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ Auth::user()->telepon }}" />
                                            </div>
                                            <form method="POST" action="{{ url('payment_pre_order') }}">
                                                @csrf
                                                <input type="hidden" name="kode_pesanan" value="{{ $preOrder->kode_pesanan }}" />
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <textarea name="bill" class="form-control" readonly
                                                        id="bill">{{ getAlamatLengkap(Auth::user()->alamat_user_id) }}</textarea>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label>Pilih Bank Tranfer</label>
                                                    <select class="custom-select" required name="bank_id">
                                                        <option>Pilih Salah Satu Bank</option>
                                                        @foreach ($bank as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->nama_bank . ' ' . $item->no_rekening }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}
                                                @php $berat = 0; @endphp
                                                @foreach ($detPreOrder as $row)
                                                    @php $berat = $berat + $row->berat_produk; @endphp
                                                @endforeach
                                                <div class="form-group">
                                                    <label>Total Berat Barang (gram)</label>
                                                    <input id="totalBerat" class="form-control" readonly value="{{ $berat }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Pilih Jasa Pengiriman</label>
                                                    <div class="input-group">
                                                        <select class="custom-select" required name="kurir"
                                                            id="jasaPengiriman">
                                                            <option value="">Pilih Jasa Pengiriman</option>
                                                            <option value="jne">JNE</option>
                                                            <option value="tiki">TIKI</option>
                                                            <option value="pos">POS</option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-warning" id="cekOngkir">Cek
                                                                Ongkir</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lama_sampai" id="lama_sampai" />
                                                <div class="form-group hidden" id="areaLoading">
                                                    <label>Data sedang dimuat.....</label>
                                                </div>

                                                <div class="form-group hidden" id="areaPengiriman">
                                                    <label>Pilih Salah Satu</label><br />
                                                    <div class="form-check" id="listOngkir"></div>
                                                </div>
                                                <button type="submit" disabled id="lanjutPembayaran" class="btn btn-primary">Lanjut ke Pembayaran</button>
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
    </div>
@endsection
@push('scripts')
    <script>
        const cekOngkir = document.querySelector("#cekOngkir");
        const totalBerat = document.querySelector("#totalBerat");
        const jasaPengiriman = document.querySelector("#jasaPengiriman");
        const lanjutPembayaran = document.querySelector("#lanjutPembayaran");
    
        function pilihJasaKirim() {
            lanjutPembayaran.removeAttribute("disabled");
        }

        cekOngkir.addEventListener("click", function() {
            $("#areaLoading").removeClass("hidden");
            $.ajax({
                url: "{{ url('check_ongkir') }}",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: {
                    city_origin: '{{ getCityToko() }}',
                    city_destination: '{{ getKotaId(Auth::user()->alamat_user_id) }}',
                    weight: $("#totalBerat").val(),
                    courier: $("#jasaPengiriman").val()
                },
                success: function(res) {
                    $('#listOngkir').empty();
                    $("#areaPengiriman").removeClass("hidden");
                    $("#areaLoading").addClass("hidden");
                    res.data.forEach(e => {
                        e.costs.forEach(row => {
                            console.log(row);
                            console.log(row.cost[0]);
                            $("#listOngkir").append(
                                '<div><input class="form-check-input" type="radio" onclick="pilihJasaKirim()" name="jasa_ongkir" id="inlineRadio' +
                                row.service + '" value="' + row.cost[0].value +
                                '"> <label class="form-check-label" for="inlineRadio' +
                                row.service + '">' + row.description + ' ' + row
                                .cost[0].etd + ' hari, Rp.' + row.cost[0].value +
                                '</label></div>');
                            $("#lama_sampai").val(row.cost[0].etd + ' hari');
                        })
                    });
                }
            });
        });
    </script>
@endpush
