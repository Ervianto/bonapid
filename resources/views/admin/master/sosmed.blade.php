@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Data Sosmed</h4>
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
                    <form action="{{route('admin.sosmed-update')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" form-control-label">Facebook :</label>
                                        <input type="text" id="fb" name="fb" placeholder="Masukkan FB" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" form-control-label">Instagram :</label>
                                        <input type="text" id="ig" name="ig" placeholder="Masukkan IG" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" form-control-label">WA :</label>
                                        <input type="text" id="wa" name="wa" placeholder="Masukkan WA" class="form-control">
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
    $(function() {
        $.get('sosmed/edit', function(data) {
            console.log(data);
            $('#id').val(data.id);
            $('#fb').val(data.fb);
            $('#wa').val(data.wa);
            $('#ig').val(data.ig);
        })
    });
</script>
@endpush