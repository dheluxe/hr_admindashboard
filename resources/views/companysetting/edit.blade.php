
@extends('layouts.app')
@section('title','Edit Employee')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('companysetting.update',$settings->id)}}" method='Post' id="edit-form" enctype="multipart/form-data" multiple>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">

                        <div class="md-form">
                            <label for="">Company Name</label>
                            <input type="text" name='company_name' value="{{$settings->company_name}}" class="form-control" >
                        </div>

                        <div class="md-form">
                            <label for="">Company Email</label>
                            <input type="text" name='company_email' class="form-control" value="{{$settings->company_email}}">
                        </div>

                        <div class="md-form">
                        <label for="">Company Phone</label>
                        <input type="email" name='company_phone' class="form-control" value="{{$settings->company_phone}}" >
                        </div>

                        <div class="md-form">
                            <label for="">Company Address</label>
                            <input type="text" name='company_address' class="form-control" value="{{$settings->company_address}}" >
                        </div>

                        <div class="md-form">
                            <label for="">Office Start Time</label>
                            <input type="text" name='office_start_time' class="form-control" value="{{$settings->office_start_time}}" >
                        </div>

                        <div class="md-form">
                            <label for="">Office End Time</label>
                            <input type="text" name='office_end_time' class="form-control"  value="{{$settings->office_end_time}}">
                        </div>

                        <div class="md-form">
                            <label for="">Bread Start Time</label>
                            <input type="text" name='bread_start_time' class="form-control" value="{{$settings->bread_start_time}}" >
                        </div>

                        <div class="md-form">
                            <label for="">Bread End Time</label>
                            <input type="text" name='bread_end_time' class="form-control" value="{{$settings->bread_end_time}}" >
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

{!!JsValidator::formRequest('App\Http\Requests\EditCompanySetting', '#edit-form');!!}
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
