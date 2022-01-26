@extends('layouts.app')
@section('title','Employee Of Info')

@section('content')

        <div class="card ">
            <div class="card-body p-5">
                <div class="row">
                    <div class="col-md-6 align-items-center ">
                            <div class="d-flex justify-content-start align-items-center h-100" >
                             <img src="{{$employee->img_path()}}" class="img-info" alt="" srcset="" class="img-fluid">
                              <div class="px-4 mt-3">
                                <h5 class="mb-1">{{$employee->name}}</h5>
                                    <p class="mb-1"> <strong>Employee ID:</strong> &nbsp;{{$employee->employee_id}}</p>
                                    <p class="mb-0 badge badge-pill badge-light " >{{$employee->department ? $employee->department->title : "-" }}</p>
                                </div>
                            </div>

                        </div>
                     <div class="col-md-6 mt-2 ">

                            <p class="mb-3" ><strong>Email</strong>: &nbsp;{{$employee->email}}</p>
                            <p class="mb-3" ><strong>Phone</strong>: &nbsp;{{$employee->phone}}</p>
                            <p class="mb-3" ><strong>NRC Number</strong>: &nbsp;{{$employee->nrc_number}}</p>
                            <p class="mb-3" ><strong>Gender</strong>: &nbsp;{{$employee->gender}}</p>
                            <p class="mb-3" ><strong>Date Of Birth</strong>: &nbsp;{{$employee->birthday}}</p>
                            <p class="mb-3" ><strong>Address</strong>:&nbsp;{{$employee->address}}</p>
                            <p class="mb-3" ><strong>Gender</strong>: &nbsp;{{$employee->gender}}</p>
                            <p class="mb-3" ><strong>Date Of Join</strong>:&nbsp;{{$employee->date_of_join}}</p>
                            <p class="mb-" ><strong>Is Present</strong>: &nbsp;
                                @if ($employee->is_present ==1)
                                <span class="badge badge-primary badge-pill ">Present</span>
                            @else
                            <span class="badge badge-danger badge-pill ">Present</span>
                            @endif</p>
                                    <a href="{{route('employee.index')}}" class="btn btn-theme btn-block">Back</a>
                     </div>
                </div>
            </div>
        </div>
@endsection
