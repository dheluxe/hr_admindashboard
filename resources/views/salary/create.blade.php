
@extends('layouts.app')
@section('title','Create Salary')
@section('content')
        <div class="card">
           <div class="card-body">
           <form action="{{route('salary.store')}}" method='Post' enctype="multipart/form-data"  id="create-form" >
                @csrf
                <div class="row">
                    <div class="col-12">

                      <div class="form-group">
                          <div class="mb-3">
                              <label for="" >Employee Name</label>
                              <select name="user_id" class="custom-select form-control " id="">
                                  <option value=""  >Select an employee</option>

                                  @foreach ($employees as $employee )
                                      <option value="{{$employee->id}}" @if ( old('user_id') == $employee->id)

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
                                <option value="01" >January</option>
                                <option value="02" >February</option>
                                <option value="03" >March</option>
                                <option value="04" >April</option>
                                <option value="05" >May</option>
                                <option value="06" >June</option>
                                <option value="07" >July</option>
                                <option value="08" >August</option>
                                <option value="09" >September</option>
                                <option value="10" >October</option>
                                <option value="11" >November</option>
                                <option value="12" >December</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Year</label>
                            <select name="year" id="" class="form-control select-year ">
                                <option value="" selected>---Please Choice---</option>
                                @for($i=0;$i<5;$i++)
                                    <option value="{{now()->addYear($i)->format('Y')}}">{{now()->addYear($i)->format('Y')}}</option>

                                @endfor
                            </select>

                        </div>
                        <div class="md-form">
                            <label for="">Salary(MMK)</label>
                            <input type="number" class="form-control" name="amount">
                        </div>

                 </div>
                    <div class="col-12">
                        <button class="btn btn-theme btn-sm btn-block " type="submit">Comfirm</button>
                    </div>


            </form>
           </div>
        </div>

@endsection
@section('script')

{!!JsValidator::formRequest('App\Http\Requests\StoreSalary', '#create-form');!!}
<script>
    $('.select-month').select2({
        placeholder:'--Select Month--',
    });

    $('.select-year').select2({
        placeholder:'--Select Year--',
    });
</script>
@endsection
