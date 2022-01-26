
@extends('layouts.app')
@section('title','Edit Department')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('department.update',$department->id)}}" method='Post' id="edit-form" enctype="multipart/form-data" multiple>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">

                        <div class="md-form">
                            <label for="">Department </label>
                            <input type="text" name='title' value="{{$department->title}}" class="form-control" >
                        </div>

                 <button class="btn btn-theme btn-sm btn-block " type="submit">Comfirm</button>

                </div>
             {{-- <div class="d-flex justify-content-center py-4">
                 <div class="col-md-6">
                 </div>
             </div> --}}
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
