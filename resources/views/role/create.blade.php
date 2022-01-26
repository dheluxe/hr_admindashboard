
@extends('layouts.app')
@section('title','Create Role')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('role.store')}}" method='Post' enctype="multipart/form-data"  id="create-form" >
                @csrf
                <div class="row">
                    <div class="col-md-12">

                        <div class="md-form">
                            <label for="">Role</label>
                            <input type="text" name='name' class="form-control" >
                        </div>

                      </div>

                </div>
                <div class="row mt-2">

                    @foreach ($permissions as $permission )


                    <div class="col-md-3 col-6">

                          <div class="custom-control custom-checkbox p-2">
                            <input type="checkbox" name="permissions[]" class="custom-control-input" id="{{$permission->id}}" value="{{$permission->name}}">
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

{!!JsValidator::formRequest('App\Http\Requests\StoreRole', '#create-form');!!}
<script>

</script>
@endsection
