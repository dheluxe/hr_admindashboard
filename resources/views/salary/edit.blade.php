
@extends('layouts.app')
@section('title','Edit Salary')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('salary.update',$salaries->id)}}" method='Post' id="edit-form" enctype="multipart/form-data" multiple>
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">

                        <div class="form-group">
                            <div class="mb-3">
                                <label for="" >Employee Name</label>
                                <select name="user_id" class="custom-select form-control " id="">
                                    <option value=""  >Select an employee</option>

                                    @foreach ($employees as $employee )
                                        <option value="{{$employee->id}}" @if ( old('user_id',$salaries->user_id) == $employee->id)

                                        selected

                                            @endif >({{$employee->employee_id}}){{$employee->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Month</label>
                            <select name="month" id="" class="form-control select-month ">
                                <option value="" selected>---Please Choice---</option>
                                <option value="01" @if( $salaries->month== '01') selected @endif>January</option>
                                <option value="02" @if($salaries->month == '02') selected @endif>February</option>
                                <option value="03" @if($salaries->month == '03') selected @endif>March</option>
                                <option value="04" @if( $salaries->month== '04') selected @endif>April</option>
                                <option value="05" @if( $salaries->month== '05') selected @endif>May</option>
                                <option value="06" @if($salaries->month== '06') selected @endif>June</option>
                                <option value="07" @if($salaries->month == '07') selected @endif>July</option>
                                <option value="08" @if($salaries->month == '08') selected @endif>August</option>
                                <option value="09" @if($salaries->month =='09') selected @endif>September</option>
                                <option value="10" @if($salaries->month =='10') selected @endif>October</option>
                                <option value="11" @if($salaries->month == '11') selected @endif>November</option>
                                <option value="12" @if($salaries->month == '12') selected @endif>December</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Year</label>
                            <select name="year" id="" class="form-control select-year ">
                                <option value="" selected>---Please Choice---</option>
                                @for($i=0;$i<5;$i++)
                                    <option value="{{now()->addYear($i)->format('Y')}}" @if($salaries->year == now()->addYear($i)->format('Y') ) selected @endif>{{now()->addYear($i)->format('Y')}}</option>

                                @endfor
                            </select>

                        </div>
                        <div class="md-form">
                            <label for="">Salary(MMK)</label>
                            <input type="number" class="form-control" name="amount" value="{{$salaries->amount}}">
                        </div>

                    </div>
                    <div class="col-12">
                        <button class="btn btn-theme btn-sm btn-block " type="submit">Comfirm</button>
                    </div>

                </div>
            </form>
           </div>
        </div>
@endsection
@section('script')

{!!JsValidator::formRequest('App\Http\Requests\EditSalary', '#edit-form');!!}
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
