
@extends('layouts.app')
@section('title','Create Permission')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('permission.store')}}" method='Post' enctype="multipart/form-data"  id="create-form" >
                @csrf
                <div class="row">
                    <div class="col-md-6">

                        <div class="md-form">
                            <label for="">Permission</label>
                            <input type="text" name='name' class="form-control" >
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-theme btn-sm btn-block " type="submit">Comfirm</button>
                            </div>
                 </div>

                </div>
            </form>
           </div>
        </div>

@endsection
@section('script')

{!!JsValidator::formRequest('App\Http\Requests\StorePermission', '#create-form');!!}
<script>

</script>
@endsection
