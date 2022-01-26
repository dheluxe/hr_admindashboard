@extends('layouts.app')
@section('title','Attendance')
@section('content')
@section('extra_css')
@endsection

<div class="card mb-5">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">

                  <input type="text" class="form-control employee-name" placeholder="Enter Employee Name">
            </div>
            <div class="col-md-3">
                   <div class="form-group mb-1">
                       <select name="month" id="" class="form-control select-month ">
                           <option value="" selected>---Please Choice---</option>
                           <option value="01" @if(now()->format('m') == '01') selected @endif>January</option>
                           <option value="02" @if(now()->format('m') == '02') selected @endif>February</option>
                           <option value="03" @if(now()->format('m') == '03') selected @endif>March</option>
                           <option value="04" @if(now()->format('m') == '04') selected @endif>April</option>
                           <option value="05" @if(now()->format('m') == '05') selected @endif>May</option>
                           <option value="06" @if(now()->format('m') == '06') selected @endif>June</option>
                           <option value="07" @if(now()->format('m') == '07') selected @endif>July</option>
                           <option value="08" @if(now()->format('m') == '08') selected @endif>August</option>
                           <option value="09" @if(now()->format('m') == '09') selected @endif>September</option>
                           <option value="10" @if(now()->format('m') == '10') selected @endif>October</option>
                           <option value="11" @if(now()->format('m') == '11') selected @endif>November</option>
                           <option value="12" @if(now()->format('m') == '12') selected @endif>December</option>
                       </select>
                   </div>
             </div>
            <div class="col-md-3">
                <div class="form-group mb-3">
                    <select name="month" id="" class="form-control select-year ">
                        <option value="">S</option>
                       @for($i=0;$i<5;$i++)
                            <option value="{{now()->addYear($i)->format('Y')}}" @if(now()->format('Y') == now()->addYear($i)->format('Y') ) selected @endif>{{now()->addYear($i)->format('Y')}}</option>

                        @endfor
                    </select>

                </div>
            </div>
            <div class="col-md-3">
                <button class="btn btn-theme btn-sm btn-block btn-search"> Search</button>
            </div>
        </div>
       <div class="table-overview">

       </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('.select-month').select2({
                placeholder:'--Select Month--',
            });

            $('.select-year').select2({
                placeholder:'--Select Year--',
            });
            overviewtable();
            function overviewtable(){
                let month= $('.select-month').val();
                let year= $('.select-year').val();
                let employeename=$('.employee-name').val();
                $.ajax({
                    url:`/attendance-overview/table? employeename=${employeename}&month=${month} &year=${year}`,
                    type:'GET',
                    success:function (res){
                        $('.table-overview').html(res);
                    }

                })
            }
            $('.btn-search').on('click',function (event){
                event.preventDefault();

                overviewtable();
            });
        });




    </script>
@endsection
