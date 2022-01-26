
@extends('layouts.app')
@section('title','Edit Project')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('project.update',$project->id)}}" method='Post' id="edit-form" enctype="multipart/form-data" multiple>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">

                        <div class="md-form">
                            <label for="">Project</label>
                            <input type="text" name='title' class="form-control" value="{{old('title ',$project->title)}}" >
                        </div>

                        <div class="md-form">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control md-textarea" id="" cols="" rows="3">{{old('description',$project->description)}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Upload Image</label>
                            <input type="file" name='images[]' class="form-control p-1 " id="profile_img"  multiple accept="image/*" >
                            <div class="img-preview m-2  rounded">
                                @if($project->images)
                                @foreach($project->images as $image)
                                        <img src="{{asset('storage/project/'.$image)}}" alt="">
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Upload Files</label>
                            <input type="file" name='files[]' class="form-control p-1 "  multiple accept="application/pdf" >
                            @if($project->files)
                                @foreach($project->files as $file)
                                    <a href="{{asset('storage/project/'. $file)}}" class="pdf-thumbnail"><i class="far fa-file-pdf"></i></a>
                                @endforeach
                            @endif
                        </div>
                        <div class="">
                            <label for="">Start Date</label>
                            <input type="date" name='start_date' class="form-control date  " value="{{old('start_date',\Carbon\Carbon::parse($project->start_date)->format('Y-m-d'))}}" >
                        </div>
                        <div class="mt-2">
                            <label for="" class="mb-">Dead Line</label>
                            <input type="date" name='deadline' class="form-control date  " value="{{old('deadline',\Carbon\Carbon::parse($project->deadline)->format('Y-m-d'))}}" >
                        </div>
                        <div class="form-group">
                            <label class="">Leader</label>
                            <select class="browser-default custom-select" name="leaders[]" multiple>

                                @foreach($employees as $employee)
                                    <option value="{{$employee->id}}" @if(in_array($employee->id,collect($project->leaders)->pluck('id')->toArray())) selected @endif>{{$employee->employee_id}} {{$employee->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="">Member</label>
                            <select class="browser-default custom-select" name="members[]" multiple>

                                @foreach($employees as $employee)
                                    <option value="{{$employee->id}}" @if(in_array($employee->id,collect($project->members)->pluck('id')->toArray())) selected @endif>{{$employee->employee_id}} {{$employee->name}} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">	priority</label>
                            <select class="browser-default custom-select" name="priority">
                                <option selected disabled>Open this select priority</option>
                                <option value="high" @if($project->priority == 'high') selected @endif>High</option>
                                <option value="middle" @if($project->priority == 'middle') selected @endif>Middle</option>
                                <option value="low" @if($project->priority == 'low') selected @endif>Low</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">	Status</label>
                            <select class="browser-default custom-select" name="status">
                                <option selected disabled>Open this select Status</option>
                                <option value="pending" @if($project->status == 'pending') selected @endif>Pending</option>
                                <option value="in_progress"@if($project->status == 'in_progress') selected @endif>In Progress</option>
                                <option value=" complete"@if($project->status == 'complete') selected @endif >Complete</option>
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

{!!JsValidator::formRequest('App\Http\Requests\EditProject', '#edit-form');!!}
<script>

    $('#profile_img').on('change',function (){
        let file= document.getElementById('profile_img').files.length;
        for(var i=0; i<file;i++){
            $('.img-preview').html("");
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
