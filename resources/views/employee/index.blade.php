@extends('layouts.app')
@section('title','Employee')
@section('content')
@section('extra_css')
<style>
    .index-table{
        height: 100vh!important;
    }
</style>
@endsection
@can('create_employee')
    <div class="">
        <a href="{{route('employee.create')}}" class="btn btn-theme"> <i class="fas fa-plus"></i> Create Employee</a>
    </div>
    @endcan
<div class="card">
                <div class="card-body">
                    <table class="table table-bordered Datatable " style="width:100%;">
                        <thead>
                            <th class="text-center no-sort no-search "></th>
                             <th class="text-center font-weight-bolder no-sort "></th>
                            <th class="text-center font-weight-bolder no-search ">Employee ID</th>
                            <th class="text-center font-weight-bolder  no-sort ">Email</th>
                            <th class="text-center font-weight-bolder  no-sort ">Phone</th>
                            <th class="text-center font-weight-bolder no-sort">Employee Department</th>
                            <th class="text-center font-weight-bolder no-sort">Role(or)Designation</th>
                             <th class="text-center font-weight-bolder no-search no-sort ">Is Present</th>
                            <th class="text-center font-weight-bolder no-search no-sort ">Action</th>
                            <th class="text-center font-weight-bolder hidden">Update At</th>

                        </thead>

                    </table>
                </div>
            </div>
@endsection
@section('script')
<script>
    $(function() {
    var table=$('.Datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: '/employee/datable/ssd',
        columns: [
            { data: 'plus-icon', name: 'plus-icon',class:"text-center" },
            { data: 'img_upload', name: 'img_upload',class:"text-center" },
            { data: 'employee_id', name: 'employee_id',class:"text-center"  },
            { data: 'email', name: 'email',class:"text-center"  },
            { data: 'phone', name: 'phone',class:"text-center"  },
            { data: 'department_name', name: 'department_name',class:"text-center"  },
            { data: 'roles', name: 'roles',class:"text-center"  },
            { data: 'is_present', name: 'is_present',class:"text-center"  },
            { data: 'action', name: 'action',class:"text-center"  },
            { data: 'updated_at', name: 'updated_at',class:"text-center"  },

          ],
          order:[[8,"desc"]]  ,
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

    });
           @if(session('success'))
                        Swal.fire({
                        title:"SuccessFully Created",
                        text:'{{session('success')}}',
                        icon:'success',
                            })
            @endif
            @if(session('update'))
                  Swal.fire({
                title:"SuccessFully Created",
                text:'{{session('update')}}',
                icon:'success',
            })
            @endif

     $(document).on('click','.delete-employee',function(e){

          e.preventDefault();
          var id=$(this).data('id');
          swal({

                text: "Are you sure want to delete!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                            method: "DELETE",
                            url: `/employee/${id}`,
                            success:function (res){
                                table.ajax.reload();
                            }
                            })
                            // .done(function( res ) {
                            //    table.ajax.reload();
                            // });
                } else {
                    swal("Your imaginary file is safe!");
                }
                });

        });
    });
</script>
@endsection
