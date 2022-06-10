@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Data Alamat Toko</h4>
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
                    <form action="{{route('admin.alamat-toko-update')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="action" id="action" value="">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Provinsi :</label>
                                        <p>
                                            <select onchange="pilihProvinsi()" style="width: 100%; padding: 10px;" class="provinsi form-control" name="province_id" id="province_id" required>
                                                <option value="">Pilih Salah Satu</option>
                                                @foreach ($provinces as $item)
                                                <option value="{{ $item->province_id }}">{{ $item->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Kota :</label>
                                        <p>
                                            <select style="width: 100%; padding: 10px;" class="provinsi form-control" name="city_id" id="city_id" required>
                                            </select>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" form-control-label">Kode Pos :</label>
                                        <input type="number" id="kode_pos" name="kode_pos" placeholder="Masukkan Kode Pos" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class=" form-control-label">Alamat :</label>
                                        <textarea id="alamat" name="alamat" placeholder="Masukkan Alamat" class="form-control" rows="4" cols="50"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
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

        $.get('alamat-toko/' + data_id + '/edit', function(data) {
            $('#id').val(data.id);
            $('#province_id').val(data.province_id).trigger('change');;
            $('#city_id').val(data.city_id).trigger('change');;
            $('#kode_pos').val(data.kode_pos);
            $('#alamat').val(data.alamat);
        })
    });

    function pilihProvinsi() {
        var provinsi = $("#province_id").val();
        loadKota(provinsi);
    }

    loadKota("");

    function loadKota(provinsi_id) {
        $("#city_id").select2({
            placeholder: "Contoh: Kediri",
            closeOnSelect: false,
            allowClear: true,
            delay: 250, // wait 250 milliseconds before triggering the request
            ajax: {
                url: "{{ url('get_kota') }}" + "?provinsi=" + provinsi_id,
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
                    })
                    return {
                        results: results
                    };
                }
            }
        });
    }
</script>
@endpush