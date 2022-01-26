@extends('layouts.app')
@section('title','Project')
@section('content')
@section('extra_css')
    <style>
        .index-table{
            height: 100vh!important;
        }
    </style>
@endsection




<div class="card">
    <div class="card-body">
        <table class="table table-bordered Datatable " style="width:100%;">
            <thead>
            <th class="text-center no-sort no-search "></th>
            <th class="text-center font-weight-bolder no-sort ">Title</th>
            <th class="text-center font-weight-bolder no-sort ">Description</th>
            <th class="text-center font-weight-bolder no-search  no-sort text-nowrap  ">Started Date</th>
            <th class="text-center font-weight-bolder no-search   ">DeadLine</th>
            <th class="text-center font-weight-bolder no-search no-sort">Leader</th>
            <th class="text-center font-weight-bolder no-search no-sort">Members</th>
            <th class="text-center font-weight-bolder  ">Priority</th>
            <th class="text-center font-weight-bolder   ">Stauts</th>
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
                ajax: '/my-project/datatable/ssd',
                columns: [
                    { data: 'plus-icon', name: 'plus-icon',class:"text-center" },
                    { data: 'title', name: 'title',class:"text-center" },
                    { data: 'description', name: 'description',class:"text-center" },
                    { data: 'start_date', name: 'started_date',class:"text-center" },
                    { data: 'deadline', name: 'deadline',class:"text-center" },
                    { data: 'leaders', name: 'leaders',class:"text-center" },
                    { data: 'member', name: 'member',class:"text-center" },
                    { data: 'priority', name: 'priority',class:"text-center" },
                    { data: 'status', name: 'status',class:"text-center" },
                    { data: 'action', name: 'action'  },
                    { data: 'updated_at', name: 'updated_at',class:"text-center"  },

                ],
                // order:[[10,"desc"]]  ,
                columnDefs: [
                    {
                        "targets": [ 0 ],
                        "orderable": false
                    },
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

            $(document).on('click','.delete-project',function(e){

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
                                url: `/project/${id}`,

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
