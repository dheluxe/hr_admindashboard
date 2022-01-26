@extends('layouts.app')
@section('title','Profile')

@section('content')

        <div class="card ">
            <div class="card-body p-5">
                <div class="row">
                    <div class="col-md-6 align-items-center ">
                            <div class="d-flex justify-content-start align-items-center h-100" >
                                @if ($employee->img_path())
                             <img src="{{$employee->img_path()}}" class="img-info" alt="" srcset="" class="img-fluid">
                             @else
                             <img src="{{asset('image/profile.png')}}" class="img-info" alt="" srcset="" class="img-fluid">
                             @endif
                              <div class="px-4 mt-3">
                                <h5 class="mb-1">{{$employee->name}}</h5>
                                    <p class="mb-1"> <strong>Employee ID:</strong> &nbsp;{{$employee->employee_id}}</p>
                                    <p class="mb-0 badge badge-pill badge-light " >{{$employee->department ? $employee->department->title : "-" }}</p> <br>
                                @foreach ($employee->roles as $role )


                                    <p class="mt-2 badge badge-pill badge-primary">
                                            {{$role->name}}
                                    </p>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                     <div class="col-md-6 mt-2 ">

                            <p class="mb-3" ><strong>Email</strong>: &nbsp;{{$employee->email}}</p>
                            <p class="mb-3" ><strong>Phone</strong>: &nbsp;{{$employee->phone}}</p>
                            <p class="mb-3" ><strong>NRC Number</strong>: &nbsp;{{$employee->nrc_number}}</p>
                            <p class="mb-3" ><strong>Gender</strong>: &nbsp;{{$employee->gender}}</p>
                            <p class="mb-3" ><strong>Date Of Birth</strong>: &nbsp;{{$employee->birthday}}</p>
                            <p class="mb-3" ><strong>Address</strong>:&nbsp;{{$employee->address}}</p>
                            <p class="mb-3" ><strong>Gender</strong>: &nbsp;{{$employee->gender}}</p>
                            <p class="mb-3" ><strong>Date Of Join</strong>:&nbsp;{{$employee->date_of_join}}</p>
                            <p class="mb-" ><strong>Is Present</strong>: &nbsp;
                                @if ($employee->is_present ==1)
                                <span class="badge badge-primary badge-pill ">Present</span>
                            @else
                            <span class="badge badge-danger badge-pill ">Present</span>
                            @endif</p>
                                    {{-- <a href="{{route('employee.index')}}" class="btn btn-theme btn-block">Back</a> --}}
                     </div>



                </div>
            </div>
        </div>
        <div class="card  mt-2">
            <div class="card-body">
                <h3>Biometric Authentication</h3>
                   <span class="old-data"></span>

                    <a href="#" class="btn biometric-register-btn">
                        <i class="fas fa-fingerprint"></i>
                        <p class="mb-0"><i class="fas fa-plus-circle"></i></p>
                    </a>

            </div>
        </div>
        <div class="card mb-5 mt-3">
            <div class="card-body">
                <a href="/logout" class="btn btn-block btn-danger " id="logout" onclick="">
                    <p class="mb-0 d-flex align-items-center justify-content-center">
                        <i class="icofont-logout " style="font-size: 20px"></i>
                   <span class="ml-2"> LogOut</span>
                    </p>

                </a>
            </div>
        </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        biometricData();

          function biometricData(){
            $.ajax({
                url:'/profile/biometrics-data',
                type:'GET',
                success: function(res){
                        $('.old-data').html(res);
                }
            });
          }
    const register = (event) => {
        event.preventDefault()
        new Larapass({
            register: 'webauthn/register',
            registerOptions: 'webauthn/register/options'
        }).register()
          .then(function(response){
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your Fingerprint has been saved',
                showConfirmButton: false,
                timer: 1500
                })

                biometricData();
             })
          .catch(function(response){
              console.log(response);
          })
    }
    $('.biometric-register-btn').on('click',function(event){
            register(event);
    });
    $(document).on('click','.delete-biometric',function(e){
        e.preventDefault();
          var id=$(this).data('id');
          swal({
                 text: "Are you sure want to delete!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                            method: "DELETE",
                            url: `/profile/biometric/${id}`,

                            })
                            .done(function( res ) {
                                biometricData();
                            });
                } else {
                    swal("Your imaginary file is safe!");
                }
                });
    })
});
    // document.getElementById('biometric-form').addEventListener('submit', register)
</script>
@endsection
