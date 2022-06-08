@extends('layouts.landing')
@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>E-Commerce</p>
                    <h1>Sign In/Sign Up</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->
<!-- contact form -->
<div class="contact-from-section mt-150 mb-150">
    <div class="container">
        @if ($errors->any())
        <div class="row mb-3">
            <div class="col-md-6 offset-md-3">
                <div class="card bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Error :</h5>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-title">
                            <div class="col-md-6 offset-md-3">
                                <ul class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-signin-tab" data-toggle="pill" href="#pills-signin" role="tab" aria-controls="pills-signin" aria-selected="true">Sign In</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-signup-tab" data-toggle="pill" href="#pills-signup" role="tab" aria-controls="pills-signup" aria-selected="false">Sign Up</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-signin" role="tabpanel" aria-labelledby="pills-signin-tab">
                                <div class="contact-form">
                                    <h5 class="text-center">Silahkan Login Dengan Email & Password Anda!</h5>
                                    <form action="{{route('login')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email :</label>
                                            <p>
                                                <input type="email" id="email" placeholder="Masukkan Email" name="email" style="width: 100%;" required>
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password :</label>
                                            <p>
                                                <input type="text" id="password" name="password" placeholder="Masukkan Password" style="width: 100%;" required>
                                            </p>
                                        </div>
                                        <p><input type="submit" value="Submit"></p>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-signup" role="tabpanel" aria-labelledby="pills-signup-tab">
                                <div class="contact-form">
                                    <h5 class="text-center">Silahkan Isi Data Diri Anda!</h5>
                                    <form action="{{route('customer.signup')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nama Lengkap :</label>
                                            <p>
                                                <input type="text" id="name" placeholder="Masukkan Nama Lengkap" name="name" style="width: 100%;" required>
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">No. Telepon :</label>
                                            <p>
                                                <input type="number" id="telepon" placeholder="Masukkan No. Telepon" name="telepon" style="width: 100%;">
                                            </p>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="exampleInputEmail1">Alamat :</label>
                                            <p><textarea name="alamat" id="alamat" cols="30" rows="10" placeholder="Masukkan Alamat"></textarea></p>
                                        </div> -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Username :</label>
                                            <p>
                                                <input type="text" id="username" placeholder="Masukkan Username" name="username" style="width: 100%;" required>
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email :</label>
                                            <p>
                                                <input type="email" id="email" placeholder="Masukkan Email" name="email" style="width: 100%;" required>
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password :</label>
                                            <p>
                                                <input type="text" id="password" name="password" placeholder="Masukkan Password" style="width: 100%;" required>
                                            </p>
                                        </div>
                                        <p><input type="submit" value="Submit"></p>
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
<!-- end contact form -->
@endsection
@push('scripts')
@endpush