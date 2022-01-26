
@extends('layouts.app')
@section('title','Edit Employee')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('employee.update',$employer->id)}}" method='Post' id="edit-form" enctype="multipart/form-data" multiple>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">

                        <div class="md-form">
                            <label for="">Employee ID</label>
                            <input type="text" name='employee_id' value="{{$employer->employee_id}}" class="form-control" >
                        </div>

                        <div class="md-form">
                            <label for="">Name</label>
                            <input type="text" name='name' class="form-control" value="{{$employer->name}}">
                        </div>

                        <div class="md-form">
                        <label for="">Email</label>
                        <input type="email" name='email' class="form-control" value="{{$employer->email}}" >
                        </div>

                        <div class="md-form">
                            <label for="">Phone</label>
                            <input type="number" name='phone' class="form-control" value="{{$employer->phone}}" >
                        </div>

                        <div class="md-form">
                            <label for="">NRC Nummber</label>
                            <input type="text" name='nrc_number' class="form-control" value="{{$employer->nrc_number}}" >
                        </div>

                        <div class="md-form">
                            <label for="">PinCode</label>
                            <input type="number" name='pin_code' class="form-control" value="{{$employer->pin_code}}" >
                        </div>
                        <div class="md-form">
                            <label for="">Password</label>
                            <input type="password" name='password' class="form-control" >
                        </div>

                        <div class="form-group">
                            <label for="">Gender</label>
                            <select class="form-control" name="gender" aria-label="Default select example">
                            <option value="male" @if( $employer->gender == 'Male') selected @endif  >Male</option>
                            <option value="female" @if( $employer->gender == 'Female') selected @endif >Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">

                       <div class="">
                            <label for="">Date Of Birth </label>
                            <input type="date" name='birthday'  class="form-control birthday" value="{{$employer->birthday}}"  >
                      </div>

                        <div class="md-form">
                            <textarea class="md-textarea form-control" name="address">{{$employer->address}}</textarea>
                            <label for="form7">Address</label>
                        </div>
                        <div class="form-group">
                            <label for="">Department</label>
                            <select class="form-control" name="department_id" aria-label="Default select example">
                                @foreach($departments  as $department)
                                <option value="{{$department->id}} " @if($employer->department_id == $department->id) selected @endif>{{$department->title}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Role (or) Designation</label>
                            <select class="form-control custom-select" name="roles[]" aria-label="Default select example" multiple>
                                @foreach($role  as $roles)
                                <option value="{{$roles->name}}"  @if(in_array($roles->id,$old_roles)) selected  @endif>{{$roles->name}} </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="">
                            <label for="">Date Of Join </label>
                            <input type="date" name='date_of_join' value="{{$employer->date_of_join}}" class="form-control " >
                        </div>

                        <div class="form-group">
                            <label for="">Is Present</label>
                            <select class="form-control" name="is_present" aria-label="Default select example">
                            <option value="1" @if($employer->is_present == 1)selected @endif>Present</option>
                            <option value="0" @if($employer->is_present == 0)selected @endif>Absent</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Upload Profile</label>
                            <input type="file" name='img_upload' class="form-control p-1 " id="profile_img" multiple  >
                            <div class="img-preview my-2 mx-2 rounded">
                                  @if ($employer->img_upload)
                                      <img src="{{$employer->img_path()}}" alt="" srcset="">
                                    @else
                                    <img src="{{asset('image/profile.png')}}" alt="">
                                  @endif
                            </div>
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

{!!JsValidator::formRequest('App\Http\Requests\EditEmployee', '#edit-form');!!}
<script>
$('#profile_img').on('change',function(){
        var file_length=document.getElementById('profile_img').files.length;
        $('.img-preview').html('');
        for(var i=0;i < file_length; i++){
                $('.img-preview').append(`<img  src="${ URL.createObjectURL(event.target.files[i])}"/>`)
        }
});
</script>
@endsection
