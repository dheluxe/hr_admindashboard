
@extends('layouts.app')
@section('title','Create Employee')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('employee.store')}}" method='Post' enctype="multipart/form-data"  id="create-form" >
                @csrf
                <div class="row">
                    <div class="col-md-6">

                        <div class="md-form">
                            <label for="">Employee ID</label>
                            <input type="text" name='employee_id' class="form-control" >
                        </div>

                        <div class="md-form">
                            <label for="">Name</label>
                            <input type="text" name='name' class="form-control" >
                        </div>

                        <div class="md-form">
                        <label for="">Email</label>
                        <input type="email" name='email' class="form-control" >
                        </div>

                        <div class="md-form">
                            <label for="">Phone</label>
                            <input type="number" name='phone' class="form-control" >
                        </div>

                        <div class="md-form">
                            <label for="">NRC Nummber</label>
                            <input type="text" name='nrc_number' class="form-control" >
                        </div>

                        <div class="md-form">
                            <label for="">PinCode</label>
                            <input type="number" name='pin_code' class="form-control" >
                        </div>
                        <div class="md-form">
                            <label for="">Password</label>
                            <input type="password" name='password' class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="">Upload Profile</label>
                            <input type="file" name='img_upload' class="form-control p-1 " id="profile_img" multiple >
                            <div class="img-preview my-2 mx-2 rounded">
                                    <img src="{{asset('image/profile.png')}}" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Gender</label>
                            <select class="form-control" name="gender" aria-label="Default select example">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-6">

                       <div class="md-form">
                            <label for="">Date Of Birth </label>
                            <input type="date" name='birthday' class="form-control  " >
                      </div>

                        <div class="md-form">
                            <textarea class="md-textarea form-control" name="address"></textarea>
                            <label for="form7">Address</label>
                        </div>

                        <div class="form-group">
                            <label for="">Department</label>
                            <select class="form-control" name="department_id" aria-label="Default select example">
                                @foreach($employers  as $employer)
                                <option value="{{$employer->id}}">{{$employer->title}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Role (or) Designation</label>
                            <select class="form-control custom-select" name="roles[]" aria-label="Default select example" multiple>
                                @foreach($roles  as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="md-form">
                            <label for="">Date Of Join </label>
                            <input type="date" name='date_of_join' class="form-control " >
                        </div>

                        <div class="form-group">
                            <label for="">Is Present</label>
                            <select class="form-control" name="is_present" aria-label="Default select example">
                            <option value="1">Present</option>
                            <option value="0">Absent</option>
                            </select>
                        </div>
                </div>
                </div>
             <div class="d-flex justify-content-center py-4">
                 <div class="col-md-6">
                 <button class="btn btn-theme btn-sm btn-block " type="submit">Comfirm</button>
                 </div>
             </div>

            </form>
           </div>
        </div>
@endsection
@section('script')

{!!JsValidator::formRequest('App\Http\Requests\StoreEmployee', '#create-form');!!}
<script>
   $(function() {
  $('.birthday').daterangepicker({
    "maxDate": moment(),
    "singleDatePicker": true,
  });
});
$('#profile_img').on('change',function(){
        var file_length=document.getElementById('profile_img').files.length;
        $('.img-preview').html('');
        for(var i=0;i < file_length; i++){
                $('.img-preview').append(`<img  src="${ URL.createObjectURL(event.target.files[i])}"/>`)
        }
});
</script>
@endsection
