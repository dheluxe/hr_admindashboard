<div class="row ">
    <div class="col-12 col-md-4" >
        <div class="card mt-4">
            <div class="card-header bg-warning text-center">Pending</div>
            <div class="card-body alert-warning" >
               <div id="pending">
                   @foreach(collect($project->task)->sortBy('serial_number')->where('status','pending') as $task)
                       <div class="task-item" data-id="{{$task->id}}">
                           <div class="d-flex justify-content-between">
                               <h6>{{$task->title}}</h6>

                               <div class="task-action mb-3">
                                   <a class="edit_task_btn text-warning " href="#" data-task="{{base64_encode(json_encode($task))}}"  data-member="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}">
                                       <i class="fas fa-user-edit"></i>
                                   </a>
                                   <a class="delete_task_btn text-danger" data-id="{{$task->id}}" href="#" >
                                       <i class="icofont-trash"></i>
                                   </a>


                               </div>
                           </div>
                           <div class="d-flex justify-content-between">
                               <div class="">
                                   <p class="mb-0 " ><i class="fas fa-clock"></i>{{\Carbon\Carbon::parse($task->start_date)->format('M d')}}</p>
                                   @if($task->priority == 'high')
                                       <span class="badge badge-danger ">High</span>
                                   @elseif($task->priority == 'middle')
                                       <span class="badge badge-info ">Middle</span>
                                   @elseif($task->priority == 'low')
                                       <span class="badge badge-dark ">Low</span>
                                   @endif
                               </div>
                               <div class="">
                                   @foreach( $task->members as $member )
                                       <img src="{{$member->img_path()}}" class="img-project" alt="">
                                   @endforeach
                               </div>
                           </div>
                       </div>
                   @endforeach
               </div>

                <div class="text-center">
                    <a href="" class="add-item add-panding">
                        <i class="fas fa-plus "></i>
                        ADD TASK
                    </a>
                </div>
            </div>

        </div>
    </div>
    <div class="col-12 col-md-4" >
        <div class="card mt-4">
            <div class="card-header bg-info text-center">In Progress</div>
            <div class="card-body alert-info" >
                <div  id="progress">
                    @foreach(collect($project->task)->sortBy('serial_number')->where('status','in_progress') as $task)
                        <div class="task-item" data-id="{{$task->id}}">
                            <div class="d-flex justify-content-between">
                                <h6>{{$task->title}}</h6>
                                <div class="task-action mb-3">
                                    <a class="edit_task_btn text-warning " href="#" data-task="{{base64_encode(json_encode($task))}}"  data-member="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}">
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                    <a class="delete_task_btn text-danger" data-id="{{$task->id}}" href="#" >
                                        <i class="icofont-trash"></i>
                                    </a>


                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <p class="mb-0 " ><i class="fas fa-clock"></i>{{\Carbon\Carbon::parse($task->start_date)->format('M d')}}</p>
                                    @if($task->priority == 'high')
                                        <span class="badge badge-danger ">High</span>
                                    @elseif($task->priority == 'middle')
                                        <span class="badge badge-info ">Middle</span>
                                    @elseif($task->priority == 'low')
                                        <span class="badge badge-dark ">Low</span>
                                    @endif
                                </div>
                                <div class="">
                                    @foreach( $task->members as $member )
                                        <img src="{{$member->img_path()}}" class="img-project" alt="">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center">
                    <a href="" class="add-item add-progress">
                        <i class="fas fa-plus "></i>
                        ADD TASK
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4" >
        <div class="card mt-4">
            <div class="card-header bg-success text-center">Complete</div>
            <div class="card-body alert-success">
                <div  id="complete">
                    @foreach(collect($project->task)->sortBy('serial_number')->where('status','complete') as $task)
                        <div class="task-item" data-id="{{$task->id}}">
                            <div class="d-flex justify-content-between">
                                <h6>{{$task->title}}</h6>
                                <div class="task-action mb-3">
                                    <a class="edit_task_btn text-warning " href="#" data-task="{{base64_encode(json_encode($task))}}"  data-member="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}">
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                    <a class="delete_task_btn text-danger" data-id="{{$task->id}}" href="#" >
                                        <i class="icofont-trash"></i>
                                    </a>


                                </div>

                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <p class="mb-0 " ><i class="fas fa-clock"></i>{{\Carbon\Carbon::parse($task->start_date)->format('M d')}}</p>
                                    @if($task->priority == 'high')
                                        <span class="badge badge-danger ">High</span>
                                    @elseif($task->priority == 'middle')
                                        <span class="badge badge-info ">Middle</span>
                                    @elseif($task->priority == 'low')
                                        <span class="badge badge-dark ">Low</span>
                                    @endif
                                </div>
                                <div class="">
                                    @foreach( $task->members as $member )
                                        <img src="{{$member->img_path()}}" class="img-project" alt="">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="text-center">
                    <a href="" class="add-item add-complete">
                        <i class="fas fa-plus "></i>
                        ADD TASK
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form action=""></form>
</div>
