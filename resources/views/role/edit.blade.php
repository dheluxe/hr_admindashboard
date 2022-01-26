
@extends('layouts.app')
@section('title','Edit Department')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('role.update',$roles->id)}}" method='Post' id="edit-form" enctype="multipart/form-data" multiple>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">

                        <div class="md-form">
                            <label for="">Role  </label>
                            <input type="text" name='name' value="{{$roles->name}}" class="form-control" >
                        </div>



                        </div>

                </div>
                <div class="row mt-2">

                    @foreach ($permissions as $permission )


                    <div class="col-md-3 col-6">

                          <div class="custom-control custom-checkbox p-2">
                            <input type="checkbox" name="permissions[]" class="custom-control-input" id="{{$permission->id}}"
                             @if (in_array($permission->id,$oldpermissions))
                                checked
                            @endif value="{{$permission->name}}">
                            <label class="custom-control-label" for="{{$permission->id}}">{{$permission->name}}</label>
                        </div>

                    </div>
                    @endforeach
                </div>
                <div class="col-md-12 mt-3">
                    <button class="btn btn-theme btn-sm btn-block " type="submit">Comfirm</button>
                 </div>
            </form>
           </div>
        </div>
@endsection
@section('script')

{!!JsValidator::formRequest('App\Http\Requests\EditRole', '#edit-form');!!}
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
