
@extends('layouts.app')
@section('title','Create Project')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('project.store')}}" method='Post' enctype="multipart/form-data"  id="create-form" >
                @csrf
                <div class="row">
                    <div class="col-md-12">

                        <div class="md-form">
                            <label for="">Project</label>
                            <input type="text" name='title' class="form-control" >
                        </div>

                        <div class="md-form">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control md-textarea" id="" cols="" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Upload Image</label>
                            <input type="file" name='images[]' class="form-control p-1 " id="profile_img"  multiple accept="image/*" >
                            <div class="img-preview m-2  rounded">
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="">Upload Files</label>
                            <input type="file" name='files[]' class="form-control p-1 "  multiple accept="application/pdf" >

                        </div>
                        <div class="">
                            <label for="">Start Date</label>
                            <input type="date" name='start_date' class="form-control date  " >
                        </div>
                        <div class="mt-2">
                            <label for="" class="mb-">Dead Line</label>
                            <input type="date" name='deadline' class="form-control date " >
                        </div>
                        <div class="form-group">
                            <label class="">Leader</label>
                            <select class="browser-default custom-select" name="leaders[]" multiple>

                                @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->employee_id}} {{$employee->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                           <label class="">Member</label>
                            <select class="browser-default custom-select" name="members[]" multiple>

                               @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->employee_id}} {{$employee->name}} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">	priority</label>
                            <select class="browser-default custom-select" name="priority">
                                <option selected disabled>Open this select priority</option>
                                <option value="high">High</option>
                                <option value="middle">Middle</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">	Status</label>
                            <select class="browser-default custom-select" name="status">
                                <option selected disabled>Open this select Status</option>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value=" complete">Complete</option>
                            </select>
                        </div>
                         <div class="text-center">
                             <button class="btn btn-theme    text-center " type="submit">Comfirm</button>
                         </div>

                 </div>


        </div>
            </form>
           </div>
        </div>

@endsection
@section('script')

{!!JsValidator::formRequest('App\Http\Requests\StoreProject', '#create-form');!!}
<script>
    $('#profile_img').on('change',function (){
         let file= document.getElementById('profile_img').files.length;
        for(var i=0; i<file;i++){

            $('.img-preview').append(`<img class=" shadow-lg"  style="margin-right:20px!important; " src="${URL.createObjectURL(event.target.files[i])}" alt="">`)
        }
    });
    $('.date').daterangepicker({
        "singleDatePicker": true,
        "autoApply": true,
        "showDropdowns": true,
        "locale": {
            "format": "YYYY-MM-DD",
        }
    });
</script>
@endsection
