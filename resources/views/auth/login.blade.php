@extends('layouts.app-plain')
@section('title','login')
@section('extra_css')

@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center align-content-center "style="height:100vh;" >
        <div class="col-md-6">
        <div class="text-center" >
                        <img src="{{asset('image/JusWise.png')}}" alt="" >
                    </div>
            <div class="card">


                <div class="card-body">
                    <div class="text-center mt-3">
                    <h5>Login</h5>
                    <span class="text-muted">Please fill out the form</span>
                    </div>
                    <form method="GET" action="{{route('login-options')}}" autocomplete="off">
                        <div class="md-form mb-5">

                            <input type="number" class="form-control text-center @error('phone') is-invalid @enderror" name="phone"
                                value="{{ old('phone') }}" autofocus placeholder="Enter Phone Nummber">

                            @error('phone')
                            <p class="text-danger text-center">{{$message}}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-theme btn-block">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
