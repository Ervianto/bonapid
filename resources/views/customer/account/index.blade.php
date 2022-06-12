@extends('layouts.landing')
@section('content')
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <h1>Akun</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cart-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body">
                    <form method="POST" action="{{ url('update_akun') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Identitas :</h4>
                                <div class="form-group">
                                    <label>Nama :</label>
                                    <input class="form-control" name="name" value="{{ $user->name }}" />
                                </div>
                                <div class="form-group">
                                    <label>Email :</label>
                                    <input class="form-control" name="email" value="{{ $user->email }}" />
                                </div>
                                <div class="form-group">
                                    <label>Telepon :</label>
                                    <input class="form-control" name="telepon" value="{{ $user->telepon }}" />
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Provinsi :</label>
                                    <p>
                                        <select onchange="pilihProvinsi()" style="width: 100%; padding: 10px;"
                                            class="provinsi form-control" name="province_id" id="province_id" required>
                                            <option value="">Pilih Salah Satu</option>
                                            @foreach ($provinces as $item)
                                                <option value="{{ $item->province_id }}">{{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kota :</label>
                                    <p>
                                        <select style="width: 100%; padding: 10px;"
                                            class="provinsi form-control" name="city_id" id="city_id" required>
                                            @foreach($cities as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Akun :</h4>
                                <div class="form-group">
                                    <label>Username :</label>
                                    <input class="form-control" name="username" value="{{ $user->username }}" />
                                </div>
                                <h6>Ganti Password</h6>
                                <div class="form-group">
                                    <label>Password :</label>
                                    <input class="form-control" type="password" name="password" />
                                </div>
                                <div class="form-group">
                                    <label>Konfirmasi Password :</label>
                                    <input class="form-control" type="password" name="password_confirmation" />
                                </div>
                                <div class="form-group">
                                    <label>Password Anda : <span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="current_password" required />
                                </div>
                                <div class="alert alert-info" role="alert">
                                    Kolom password anda wajib diisi untuk melakukan update data!
                                </div>
                            </div>
                            <div class="col-md-6">
                                <a class="btn btn-block btn-warning" href="{{ url()->previous() }}">Kembali</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-block btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.provinsi').select2();
            $('.provinsi').val('{{ $user->province_id }}').trigger('change.select2');
            $("#city_id").select2();
            $('#city_id').val('{{ $user->city_id }}').trigger('change.select2');
        });

        function pilihProvinsi(){
            var provinsi = $("#province_id").val();
            loadKota(provinsi);
        }

        function loadKota(provinsi_id){
            $("#city_id").select2({
                placeholder: "Contoh: Malang",
                closeOnSelect: false,
                allowClear: true,
                delay: 250, 
                ajax: {
                    url: "{{ url('get_kota') }}"+"?provinsi="+provinsi_id,
                    dataType: "json",
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, item) {
                            results.push({
                                id: item.id,
                                text: item.name,
                                value: item.id
                            })
                        });
                        return {
                            results: results
                        };
                    }
                }
            });
        }
    </script>
@endpush
