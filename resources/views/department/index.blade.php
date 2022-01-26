@extends('layouts.app')
@section('title','Department')
@section('content')
@section('extra_css')
<style>
    .index-table{
        height: 100vh!important;
    }
</style>
@endsection
    @can('create_department')
    <div class="">
        <a href="{{route('department.create')}}" class="btn btn-theme"> <i class="fas fa-plus"></i> Create Department</a>
    </div>
    @endcan


<div class="card">
                <div class="card-body">
                    <table class="table table-bordered Datatable " style="width:100%;">
                        <thead>
                            <th class="text-center no-sort no-search "></th>
                            <th class="text-center font-weight-bolder no-search ">Department</th>
                              <th class=" font-weight-bolder no-search no-sort ">Action</th>
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
        ajax: '/department/datable/ssd',
        columns: [
            { data: 'plus-icon', name: 'plus-icon',class:"text-center" },
            { data: 'title', name: 'title',class:"text-center" },
           { data: 'action', name: 'action'  },
            { data: 'updated_at', name: 'updated_at',class:"text-center"  },

          ],
          order:[[3,"desc"]]  ,
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

     $(document).on('click','.delete-department',function(e){

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
                            url: `/department/${id}`,

                            })
                            .done(function( res ) {
                               table.ajax.reload();
                            });
                } else {
                    swal("Your imaginary file is safe!");
                }
                });

        });
    });
</script>
@endsection
