@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Anda Sudah Login!') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->
                    @if(Auth::user()->role=='customer')
                    <a href="{{route('customer.dashboard')}}"> Klik Disini...</a>
                    @else
                    <a href="{{route('admin.dashboard')}}"> Klik Disini...</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection