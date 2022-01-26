@extends('layouts.app')
@section('title','Admin DashBoard')

@section('content')

        <div class="card ">
            <div class="card-body p-5">
                <div class="row">
                    <div class="col-12  ">
                            <div class="text-center h-100" >
                             @if ($employee->img_path())
                             <img src="{{$employee->img_path()}}" class="img-info" alt="" srcset="" class="img-fluid">
                             @else
                             <img src="{{asset('image/profile.png')}}" class="img-info" alt="" srcset="" class="img-fluid">
                             @endif
                              <div class="px-4 mt-3">
                                <h5 class="mb-1">{{$employee->name}}</h5>
                                    <p class="mb-1"> <strong>Employee ID:</strong> &nbsp;{{$employee->employee_id}}| <span class="text-muted ml-2">{{$employee->phone}}</span></p>
                                    <p class="mb-0 badge badge-pill badge-light " >{{$employee->department ? $employee->department->title : "-" }}</p> <br>
                                    @foreach ($employee->roles as $role )


                                    <p class="mt-2 badge badge-pill badge-primary">
                                            {{$role->name}}
                                    </p>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                </div>
            </div>
        </div>
@endsection
