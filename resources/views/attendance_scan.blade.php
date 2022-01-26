@extends('layouts.app')
@section('title','Attendance Scan')

@section('content')

        <div class="card mb-3 ">
            <div class="card-body text-center ">
                 <img src="{{asset('image/scan.png')}}" style="width: 250px" alt="">
                <h3 class="text-muted">Scan Your QR Code</h3>

            <button type="button" class="btn btn-theme" data-toggle="modal" data-target="#Scanmodel">
                Scan
            </button>
            </div>
        </div>
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="text-center text-muted">Attendance OverView</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <select name="month" id="" class="form-control select-year ">
{{--                                <option value="">S</option>--}}
                                @for($i=0;$i<5;$i++)
                                    <option value="{{now()->addYear($i)->format('Y')}}" @if(now()->format('Y') == now()->addYear($i)->format('Y') ) selected @endif>{{now()->addYear($i)->format('Y')}}</option>

                                @endfor
                            </select>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-theme btn-sm btn-block btn-search"> Search</button>
                    </div>
                </div>
                <div class="table-overview">

                </div>
            </div>
        </div>
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="text-center text-muted">Pay Roll</h5>
            </div>
            <div class="payroll"></div>
        </div>
        <div class="card mb-5" >
            <div class="card-header">
                <h5 class="text-center text-muted">Attendance OverView</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered Datatable " style="width:100%;">
                    <thead>
                    <th class="text-center no-sort no-search   "></th>
                    <th class="text-center font-weight-bolder no-sort ">Employee</th>
                    <th class="text-center font-weight-bolder no-search ">Date</th>
                    <th class="text-center font-weight-bolder no-search no-sort ">Check IN </th>
                    <th class="text-center font-weight-bolder no-search no-sort ">Check Out</th>
                     <th class="text-center font-weight-bolder hidden">Update At</th>

                    </thead>

                </table>
            </div>
        </div>
  <!-- Modal -->
  <div class="modal fade" id="Scanmodel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ScanmodelLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ScanmodelLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <video id="qr_scan" width="100%" height="300px"></video>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>


@endsection
@section('script')
<script src="{{asset('js/qr-scanner.umd.min.js')}}"></script>
<script>

 $(document).ready(function(){
    $('#Scanmodel').on('hidden.bs.modal', function (event) {
        qrScanner.stop();
        });

        $('#Scanmodel').on('shown.bs.modal', function (event) {
        qrScanner.start();
        }); $('.select-month').select2({
         placeholder:'--Select Month--',
     });

     $('.select-year').select2({
         placeholder:'--Select Year--',
     });
     var table=$('.Datatable').DataTable({
         responsive: true,
         processing: true,
         serverSide: true,
         ajax: '/my-attendance/datable/ssd',
         columns: [
             { data: 'plus-icon', name: 'plus-icon',class:"text-center   " },
             { data: 'employee_name', name: 'employee_name',class:"text-center  text-muted  " },
             { data: 'CheckIn', name: 'CheckIn',class:"text-center " },
             { data: 'CheckOut', name: 'CheckOut',class:"text-center" },
             { data: 'date', name: 'date',class:"text-center" },
             { data: 'updated_at', name: 'updated_at',class:"text-center"  },

         ],
         order:[[4,"desc"]]  ,
         columnDefs: [
             // {
             //     "targets": [ 7 ],
             //     "visible": false
             // },
             {
                 "targets": [ 0 ],
                 "class": "control"
             },
             {
                 "targets": 'no-search',
                 "searchable":false
             },
             {
                 'targets': 'no-sort',
                 "orderable":false
             },
             {
                 "targets": 'hidden',
                 "visible":false
             },

         ],
         language: {
             "paginate": {
                 "next": "<i class='fas fa-arrow-circle-right'></i>",
                 "previous": "<i class='fas fa-arrow-circle-left'></i>"
             },
             "processing": "<img src='/image/loading.gif'><p>Loading...</p>",
         }

     });
     overviewtable();
     function overviewtable(){
         let month= $('.select-month').val();
         let year= $('.select-year').val();

         $.ajax({
             url:`/my-attendance-overview/table?month=${month} &year=${year}`,
             type:'GET',
             success:function (res){
                 $('.table-overview').html(res);
             }

         });
         table.ajax.url( `/my-attendance/datable/ssd? month=${month}&year=${year }` ).load();
     };
     payroll();
     function payroll(){
         let month= $('.select-month').val();
         let year= $('.select-year').val();

         $.ajax({
             url:`/my-payroll-overview/table?&month=${month} &year=${year}`,
             type:'GET',
             success:function (res){
                 $('.payroll').html(res);
             }

         })
     }
     $('.btn-search').on('click',function (event){
         event.preventDefault();
         overviewtable();
         payroll();
     });

        let videoElem=document.getElementById('qr_scan');
        const qrScanner = new QrScanner(videoElem, function (result){
            if(result){
                $('#Scanmodel').modal('hide');
                // console.log(result);
                qrScanner.stop();
                $.ajax({
                    url:'/attendanceScan/store',
                    type:'POST',
                    data:{"hash_value": result},
                    success:function (res){
                    if (res.status == 'success' ) {
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: res.message
                        });
                    }

                    }
                });


            }
        });


 });
</script>
@endsection
