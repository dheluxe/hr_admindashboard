
@extends('layouts.app')
@section('title','Edit Attendance')
@section('content')
        <div class="card">
            @foreach ($errors->all() as $error)

            <div class="alert alert-danger alert-dismissible fade show text-center " role="alert">
                <strong>{{ $error }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endforeach
           <div class="card-body">
           <form action="{{route('attendance.update',$attendance->id)}}" method='Post' id="edit-form" enctype="multipart/form-data" multiple>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <div class="mb-3">
                                <label for="" >Employee Name</label>
                            <select name="user_id" class="custom-select form-control " id="">
                                <option value=""  >Select an employee</option>

                                @foreach ($employees as $employee )
                                <option value="{{$employee->id}}" @if ( old('user_id',$attendance->user_id) == $employee->id)

                                        selected

                                @endif >({{$employee->employee_id}}){{$employee->name}} </option>
                                @endforeach
                            </select>
                            </div>
                            <div class="mb-3">
                                <label for="">Choose Date</label>
                                <input type="date" class="form-control date" name="date" value="{{old('date',$attendance->date)}}" >
                            </div>
                            <div class="mb-3">
                                <label for="">Check In Time</label>
                                <input type="text" class="form-control timepicker" value="{{old('CheckIn',  Carbon\Carbon::parse($attendance->CheckIn)->format('H:i:s'))}}" name="CheckIn" >
                            </div>
                            <div class="mb-3">
                                <label for="">Check Out Time</label>
                                <input type="text" class="form-control timepicker"  value="{{old('CheckOut', Carbon\Carbon::parse($attendance->CheckOut)->format('H:i:s'))}}" name="CheckOut" >
                            </div>

                        </div>

                 </div>
                 <div class="col-md-12 mt-3">
                    <button class="btn btn-theme btn-sm btn-block " type="submit">Comfirm</button>
                 </div>
            </form>
           </div>
        </div>
@endsection
@section('script')

{!!JsValidator::formRequest('App\Http\Requests\EditAttendance', '#edit-form');!!}
<script>
$(document).ready(function(){
        $('.date').daterangepicker({
            "singleDatePicker": true,
            "autoApply": true,
            "showDropdowns": true,
            "locale": {
                "format": "YYYY-MM-DD",
            }
        });
        $('.timepicker').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "autoApply": true,
            "locale": {
                "format": "HH:mm:ss",
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find('.calendar-table').hide();
        });
    });
</script>
@endsection
