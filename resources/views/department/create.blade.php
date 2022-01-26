
@extends('layouts.app')
@section('title','Create Department')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('department.store')}}" method='Post' enctype="multipart/form-data"  id="create-form" >
                @csrf
                <div class="row">
                    <div class="col-md-6">

                        <div class="md-form">
                            <label for="">Department</label>
                            <input type="text" name='title' class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-theme btn-sm btn-block " type="submit">Comfirm</button>
                            </div>
                 </div>


            </form>
           </div>
        </div>
        
@endsection
@section('script')

{!!JsValidator::formRequest('App\Http\Requests\StoreDepartment', '#create-form');!!}
<script>

</script>
@endsection
