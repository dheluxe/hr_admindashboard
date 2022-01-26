<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

        <!-- Google Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">

        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">


        {{-- pic_code --}}
        <link rel="stylesheet" href="{{asset('css/pincode.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        @yield('extra_css')
</head>
<body>
    <div id="app">


        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>

<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

{{-- Larapass  --}}
<script src="{{ asset('vendor/larapass/js/larapass.js') }}"></script>

{{-- pin_code --}}
<script src="{{asset('js/pincode.js')}}"></script>

 <!-- sweetalert2 -->
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- sweeslert --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
       const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
                let token =document.head.querySelector('meta[name="csrf-token"]');
                if(token){
                    $.ajaxSetup({
                            headers:{
                                'X-CSRF-TOKEN':token.content
                            }
                });

                }else{
                    console.error('Token Not Found');
                }

</script>
@yield('script');
</body>
</html>
