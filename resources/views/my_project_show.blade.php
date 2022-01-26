
@extends('layouts.app')
@section('title',' Project Info')
@section('extra_css')
    <style>
        .alert-warning {
            background-color: #fff3cd88 !important;
        }
        .alert-info {
            background-color: #d1ecf188 !important;
        }
        .alert-success {
            background-color: #d4edda88 !important;
        }
        .task-item  {
            background: #fff;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 9px;
            padding: 10px ;
        }
        .add-item{
            display: block;
            color: #a11a1a;!important;
            padding: 10px;
            background: #ffff;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        .select2-container {
            z-index: 99999999!important;
        }
        .ghost{
            background: #eee;
            border: 2px dashed #333;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="">asdf : <span class="text-muted">{{$project->title}}</span> </h5>
                    <p class="font-weight-bolder mb-2">Start Date: <span  class="text-muted" >{{$project->start_date}}</span> | DeadLine : <span  class="text-muted">{{$project->deadline}}</span></p>
                    <p class="text-muted mb-2">
                        Priority :
                        @if($project->priority == 'high')
                            <span class="badge badge-danger"> High</span>
                        @elseif($project->priority == 'middle')
                            <span class="badge badge-info"> middle</span>
                        @elseif($project->priority == 'low')
                            <span class="badge badge-info"> Low</span>
                        @endif
                        |
                        Status :
                        @if($project->status == 'in_progress')
                            <span class="badge badge-info"> In Progress</span>
                        @elseif($project->status == 'pending')
                            <span class="badge badge-primary"> Pending</span>
                        @elseif($project->status == 'complete')
                            <span class="badge badge-success"> Complete</span>
                        @endif
                    </p>
                    <div class="">
                        <h5>Description </h5>
                        <p class="text-muted mb-2">
                            {{$project->description}}
                        </p>
                    </div>
                    <div class="mt-3 ">
                        <h5 >Leader</h5>
                        @foreach($project->leaders as $leader)
                            <img src="{{$leader->img_path()}}"  class="img-project ">
                        @endforeach
                    </div>
                    <hr>
                    <div class="mt-4">
                        <h5 class="">Member</h5>
                        @foreach($project->members as $member)
                            <img src="{{$member->img_path()}}" id="images" class="img-project ">
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card mb-2">
                <div class="card-header p-1">
                    <h5 class="text-center text-muted font-weight-bolder">IMAGE</h5>
                </div>
                <div class="card-body">
                    @if($project->images)
                        @foreach($project->images as $image)
                            <img src="{{asset('storage/project/'.$image)}}" id="images1" class="project-info-img" alt="" style="cursor:pointer">
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="card mt-4">

                <div class="card-header p-1">
                    <h5 class="text-center text-muted font-weight-bolder">FILES</h5>
                </div>
                <div class="card-body">
                    @if($project->files)
                        @foreach($project->files as $file)
                            <a href="{{asset('storage/project/'. $file)}}" target="_blank" class="pdf-thumbnail"><i class="far fa-file-pdf"></i><span style="display: inline;margin-left: 5px;" class="mt-4 text-nowrap">File {{$loop->iteration}}</span></a>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
        <div class="col-12 mt-5">
            <div class="card ">
                <div class="card-body">
                    <div class="taskData"></div>
                </div>
            </div>
        </div>

    </div>


@endsection
@section('script')

    <script>
        $(document).ready(function (){
            var leaders= @json($project->leaders);
            var   members= @json($project->members);
            var project_id="{{$project->id}}";
            new Viewer(document.getElementById('images1'));

            function taskdata(){
                $.ajax({
                    url:`/task-data?project_id=${project_id}`,
                    type:'GET',
                    success:function (res){
                        $('.taskData').html(res);
                        sortable();
                    }
                })
            }
            taskdata();
            function  sortable(){
                var pending = document.getElementById('pending');
                var progress = document.getElementById('progress');
                var complete = document.getElementById('complete');

                Sortable.create(pending,{
                    group: "task",
                    ghostClass: "ghost",
                    draggable: ".task-item",
                    animation: 350,
                    store: {
                        set: function (sortable){
                            var order = sortable.toArray();
                            localStorage.setItem('pending', order.join(','));

                        }
                    },
                    onSort: function (evt) {
                        setTimeout(function(){
                            var pendingTaskBoard = localStorage.getItem('pending');
                            console.log(pendingTaskBoard)
                            $.ajax({
                                url:`/taskDragrable?project_id=${project_id}&pendingTaskBoard=${pendingTaskBoard}`,
                                type:'GET',
                                success:function (res){

                                }
                            })
                        },1000);
                    }
                });

                Sortable.create(progress,{
                    group: "task",
                    ghostClass: "ghost",
                    draggable: ".task-item",
                    animation: 350,
                    store: {
                        set: function (sortable){
                            var order = sortable.toArray();
                            localStorage.setItem('progress', order.join(','));

                        }
                    },
                    onSort: function (evt) {
                        setTimeout(function(){
                            var progressTaskBoard = localStorage.getItem('progress');
                            $.ajax({
                                url:`/taskDragrable?project_id=${project_id}&progressTaskBoard=${progressTaskBoard}`,
                                type:'GET',
                                success:function (res){

                                }
                            })
                        },1000);
                    }


                });

                Sortable.create(complete,{
                    group: "task",
                    ghostClass: "ghost",
                    draggable: ".task-item",
                    animation: 350,
                    store: {
                        set: function (sortable){
                            var order = sortable.toArray();
                            localStorage.setItem('complete', order.join(','));

                        }
                    },
                    onSort: function (evt) {
                        setTimeout(function(){
                            var completeTaskBoard = localStorage.getItem('complete');
                            $.ajax({
                                url:`/taskDragrable?project_id=${project_id}&completeTaskBoard=${completeTaskBoard}`,
                                type:'GET',
                                success:function (res){

                                }
                            })
                        },1000);
                    }

                });
            }
            $(document).on('click','.add-panding',function (event){
                event.preventDefault();

                var task_option_member='';
                leaders.forEach(function (leader){
                    task_option_member +=`<option value="${leader.id}">${leader.name}</option>`;
                });
                members.forEach(function (member){
                    task_option_member +=`<option value="${member.id}">${member.name}</option>`;
                });
                Swal.fire({
                    title:"Pending Task",
                    showDenyButton: false,
                    html:`<form id="pending_task">
                            <input type="hidden" name="status" value='pending'>
                                <input type="hidden" name="project_id" value="${project_id}">
                       <div class="md-form">
                       <label for="">Title</label>
                       <input type="text" name="title" class="form-control">
                       </div>
                       <div class="md-form">
                       <label for="">Description</label>
                       <textarea name="description"  rows="3" cols="5" class="form-control md-textarea"></textarea>
                       </div>
                       <div class="md-form">
                       <label for="">Started Date</label>
                       <input type="date" name="start_date" class="form-control date" >
                       </div>
                       <div class="md-form">
                       <label for="">Dead Line</label>
                       <input type="date" name="deadline" class="form-control date" >
                       </div>
                       <div class="form-group text-left">
                       <label for="" class="">priority</label>
                       <select class="browser-default custom-select" name="priority">
                       <option selected disabled>Open this select priority</option>
                       <option value="high">High</option>
                        <option value="middle">Middle</option>
                        <option value="low">Low</option>
                       </select>
                        </div>
                      <div class="form-group text-left">
                       <label for="" class="">Member</label>
                       <select class="browser-default custom-select" name="members[]" multiple>
                       <option  disabled>Open  select Member</option>
                                    ${task_option_member}
                       </select>
                        </div>
                    </form>`
                    ,

                    showCancelButton: false,
                    confirmButtonText: 'Comfirm',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var form_date=$('#pending_task').serialize();
                        // console.log(form_date);
                        $.ajax({
                            url:'/task',
                            type:'POST',
                            data:form_date,
                            success:function (res){
                                taskdata();
                            }
                        })
                        Swal.fire('Done!', '', 'success')
                    }
                })
                $('.date').daterangepicker({
                    "singleDatePicker": true,
                    "autoApply": true,
                    "showDropdowns": true,
                    "locale": {
                        "format": "YYYY-MM-DD",
                    }
                });
                $('.custom-select').select2({
                    placeholder:'--Select Employee--',

                });
            })

            $(document).on('click','.add-progress',function (event){
                event.preventDefault();

                var task_option_member='';
                leaders.forEach(function (leader){
                    task_option_member +=`<option value="${leader.id}">${leader.name}</option>`;
                });
                members.forEach(function (member){
                    task_option_member +=`<option value="${member.id}">${member.name}</option>`;
                });
                Swal.fire({
                    title:"Pending Task",
                    showDenyButton: false,
                    html:`<form id="in_progress_task">
                            <input type="hidden" name="status" value='in_progress'>
                                <input type="hidden" name="project_id" value="${project_id}">
                       <div class="md-form">
                       <label for="">Title</label>
                       <input type="text" name="title" class="form-control">
                       </div>
                       <div class="md-form">
                       <label for="">Description</label>
                       <textarea name="description"  rows="3" cols="5" class="form-control md-textarea"></textarea>
                       </div>
                       <div class="md-form">
                       <label for="">Started Date</label>
                       <input type="date" name="start_date" class="form-control date" >
                       </div>
                       <div class="md-form">
                       <label for="">Dead Line</label>
                       <input type="date" name="deadline" class="form-control date" >
                       </div>
                       <div class="form-group text-left">
                       <label for="" class="">priority</label>
                       <select class="browser-default custom-select" name="priority">
                       <option selected disabled>Open this select priority</option>
                       <option value="high">High</option>
                        <option value="middle">Middle</option>
                        <option value="low">Low</option>
                       </select>
                        </div>
                      <div class="form-group text-left">
                       <label for="" class="">Member</label>
                       <select class="browser-default custom-select" name="members[]" multiple>
                       <option  disabled>Open  select Member</option>
                                    ${task_option_member}
                       </select>
                        </div>
                    </form>`
                    ,

                    showCancelButton: false,
                    confirmButtonText: 'Comfirm',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var form_date=$('#in_progress_task').serialize();
                        // console.log(form_date);
                        $.ajax({
                            url:'/task',
                            type:'POST',
                            data:form_date,
                            success:function (res){
                                taskdata();
                            }
                        })
                        Swal.fire('Done!', '', 'success')
                    }
                })
                $('.date').daterangepicker({
                    "singleDatePicker": true,
                    "autoApply": true,
                    "showDropdowns": true,
                    "locale": {
                        "format": "YYYY-MM-DD",
                    }
                });
                $('.custom-select').select2({
                    placeholder:'--Select Employee--',

                });
            })

            $(document).on('click','.add-complete',function (event){
                event.preventDefault();

                var task_option_member='';
                leaders.forEach(function (leader){
                    task_option_member +=`<option value="${leader.id}">${leader.name}</option>`;
                });
                members.forEach(function (member){
                    task_option_member +=`<option value="${member.id}">${member.name}</option>`;
                });
                Swal.fire({
                    title:"Pending Task",
                    showDenyButton: false,
                    html:`<form id="complete_task">
                            <input type="hidden" name="status" value='complete'>
                                <input type="hidden" name="project_id" value="${project_id}">
                       <div class="md-form">
                       <label for="">Title</label>
                       <input type="text" name="title" class="form-control">
                       </div>
                       <div class="md-form">
                       <label for="">Description</label>
                       <textarea name="description"  rows="3" cols="5" class="form-control md-textarea"></textarea>
                       </div>
                       <div class="md-form">
                       <label for="">Started Date</label>
                       <input type="date" name="start_date" class="form-control date" >
                       </div>
                       <div class="md-form">
                       <label for="">Dead Line</label>
                       <input type="date" name="deadline" class="form-control date" >
                       </div>
                       <div class="form-group text-left">
                       <label for="" class="">priority</label>
                       <select class="browser-default custom-select" name="priority">
                       <option selected disabled>Open this select priority</option>
                       <option value="high">High</option>
                        <option value="middle">Middle</option>
                        <option value="low">Low</option>
                       </select>
                        </div>
                      <div class="form-group text-left">
                       <label for="" class="">Member</label>
                       <select class="browser-default custom-select" name="members[]" multiple>
                       <option  disabled>Open  select Member</option>
                                    ${task_option_member}
                       </select>
                        </div>
                    </form>`
                    ,

                    showCancelButton: false,
                    confirmButtonText: 'Comfirm',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var form_date=$('#complete_task').serialize();
                        // console.log(form_date);
                        $.ajax({
                            url:'/task',
                            type:'POST',
                            data:form_date,
                            success:function (res){
                                taskdata();
                            }
                        })
                        Swal.fire('Done!', '', 'success')
                    }
                })
                $('.date').daterangepicker({
                    "singleDatePicker": true,
                    "autoApply": true,
                    "showDropdowns": true,
                    "locale": {
                        "format": "YYYY-MM-DD",
                    }
                });
                $('.custom-select').select2({
                    placeholder:'--Select Employee--',

                });
            })

            $(document).on('click','.edit_task_btn',function (event){
                event.preventDefault();
                let task_item=JSON.parse(atob($(this).data('task')));
                let task_member=JSON.parse(atob($(this).data('member')));
                console.log(task_item)
                var task_option_member='';
                leaders.forEach(function (leader){
                    task_option_member +=`<option value="${leader.id}" ${(task_member.includes(leader.id)? 'selected' : '-')}>${leader.name}</option>`;
                });
                members.forEach(function (member){
                    task_option_member +=`<option value="${member.id}" ${(task_member.includes(member.id)? 'selected' : '- ')}>${member.name}</option>`;
                });
                Swal.fire({
                    title:"Pending Task",
                    showDenyButton: false,
                    html:`<form id="edit_task">
                            <input type="hidden" name="status" value='complete'>
                                <input type="hidden" name="project_id" value="${project_id}">
                       <div class="md-form">
                       <label for="">Title</label>
                       <input type="text" name="title" value="${ task_item.title}" class="form-control" >
                       </div>
                       <div class="md-form">
                       <label for="">Description</label>
                       <textarea name="description"  rows="3" cols="5" class="form-control md-textarea">${ task_item.description}</textarea>
                       </div>
                       <div class="md-form">
                       <label for="">Started Date</label>
                       <input type="date" name="start_date" value="${ task_item.start_date}" class="form-control date" >
                       </div>
                       <div class="md-form">
                       <label for="">Dead Line</label>
                       <input type="date" name="deadline" value="${ task_item.deadline}" class="form-control date" >
                       </div>
                       <div class="form-group text-left">
                       <label for="" class="">priority</label>
                       <select class="browser-default custom-select" name="priority">
                       <option selected disabled>Open this select priority</option>
                       <option value="high" ${ (task_item.priority == 'high' ? 'selected' : '')}>High</option>
                        <option value="middle" ${ (task_item.priority == 'middle' ? 'selected' : '')}>Middle</option>
                        <option value="low" ${ (task_item.priority == 'low' ? 'selected' : '')}>Low</option>
                       </select>
                        </div>
                      <div class="form-group text-left">
                       <label for="" class="">Member</label>
                       <select class="browser-default custom-select" name="members[]" multiple>
                       <option  disabled>Open  select Member</option>
                                    ${task_option_member}
                       </select>
                        </div>
                    </form>`
                    ,

                    showCancelButton: false,
                    confirmButtonText: 'Comfirm',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var form_date=$('#edit_task').serialize();
                        // console.log(form_date);
                        $.ajax({
                            url:`/task/${task_item.id}`,
                            type:'PUT',
                            data:form_date,
                            success:function (res){
                                taskdata();
                            }
                        })
                        Swal.fire('Done!', '', 'success')
                    }
                })
                $('.date').daterangepicker({
                    "singleDatePicker": true,
                    "autoApply": true,
                    "showDropdowns": true,
                    "locale": {
                        "format": "YYYY-MM-DD",
                    }
                });
                $('.custom-select').select2({
                    placeholder:'--Select Employee--',

                });
            })
            $(document).on('click','.delete_task_btn',function(e){

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
                                url: `/task/${id}`,
                                success:function (res){
                                    taskdata();
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
        })

    </script>

@endsection
