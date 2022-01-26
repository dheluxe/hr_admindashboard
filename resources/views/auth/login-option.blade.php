@extends('layouts.app-plain')
@section('title','login-option')
@section('extra_css')
<style>
    .nav-pills .nav-link.active {
    color: black;
    background-color: #f5f5f5;
}
.nav-link{
    color: #8d468d;
}
</style>
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
                    <div class="text-center mt-3 mb-3">
                    <h5>Login</h5>
                    <span class="text-muted">Choose the Login option</span>
                    </div>


                        <ul class="nav nav-pills mb-3  nav-justified" id="pills-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="pills-password-tab" data-toggle="pill" href="#pills-password" role="tab"
                                aria-controls="pills-password" aria-selected="true">Password</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-biometric-tab" data-toggle="pill" href="#pills-biometric" role="tab"
                                aria-controls="pills-biometric" aria-selected="false">Biometric</a>
                            </li>

                          </ul>
                          <div class="tab-content pt-2 pl-1" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab">

                                  <form  action="{{route('login')}}" method="POST">



                                            @foreach ($errors->all() as $error)

                                            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                                <strong>{{ $error }}</strong>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                            @endforeach



                                    @csrf
                                        <input type="hidden" name="phone" value="{{request()->phone}}">
                                    <div class="md-form">
                                        <input type="password" name="password" class="form-control text-center" autofocus  placeholder="Enter Password">
                                        @error('password')
                                        <span class="alert alert-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                        <button type="submit" class="btn btn-block btn-outline-primary btn-theme waves-effect mt-4">Continue </button>

                                  </form>
                            </div>
                            <div class="tab-pane fade" id="pills-biometric" role="tabpanel" aria-labelledby="pills-biometric-tab">
                                   <div class="text-center" style="margin-bottom: 35px">
                                       <input type="hidden" value="{{request()->phone}}" id="phone" name="phone">
                                    <a href="#" class="btn biometric-login-btn">
                                        <i class="fas fa-fingerprint"></i>

                                    </a>
                                   </div>
                            </div>

                          </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    const login = (event) => {
        event.preventDefault()
        new Larapass({
            login: 'webauthn/login',
            loginOptions: 'webauthn/login/options'
        }).login({
            phone: document.getElementById('phone').value
        }).then(function(response){
                window.location.replace('/');
        })
          .catch(error => alert('Something went wrong, try again!'))
    }
        $('.biometric-login-btn').on('click',function(event){
            login(event);
        })
</script>

@endsection
