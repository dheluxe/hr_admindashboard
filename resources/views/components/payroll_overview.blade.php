<div class="table-responsive">
    <table class="table table-bordered table-striped  " style="width:100%;">
        <thead>
        <th class="text-nowrap text-center">Employee</th>
        <th class="text-nowrap text-center">Role</th>
        <th class="text-nowrap text-center">Day Of Month</th>
        <th class="text-nowrap text-center">Working Day</th>
        <th class="text-nowrap text-center">Off Day</th>
        <th class="text-nowrap text-center">Attendance Day</th>
        <th class="text-nowrap text-center">Leave</th>
        <th class="text-nowrap text-center">One day of Net(MMK)</th>
        <th class="text-nowrap text-center">Total(MMK)</th>
        </thead>
        <tbody>

        @foreach($employees as $employee)
            @php
                 $attendenceDay=0;
                $salary=collect($employee->salaries)->where('month',$month)->where('year',$year)->first();
                $perDay= $salary ? ( $salary->amount / $workdayOfMonth) : 0;
            @endphp
            @foreach ($periods as $period)
                @php
                      $office_start_time=$period->format('Y-m-d').' '. $company->office_start_time;
                    $office_end_time=$period->format('Y-m-d').' '. $company->office_end_time;
                    $bread_start_time=$period->format('Y-m-d').' '. $company->bread_start_time;
                    $bread_end_time=$period->format('Y-m-d').' '. $company->bread_end_time;
                        $attendance=collect($attendances)->where('user_id',$employee->id)->where('date',$period->format('Y-m-d'))->first();
                        if ($attendance){
                            if (!is_null($attendance->CheckIn )){
                                  if ($attendance->CheckIn < $office_start_time) {
                            $attendenceDay +=0.5;
                        }elseif ($attendance->CheckIn >  $office_start_time && $attendance->CheckIn < $bread_start_time ) {
                             $attendenceDay +=0.5;
                        }else {
                             $attendenceDay +=0;
                        }
                            }else {
                                 $attendenceDay +=0;
                            }

                        if (!is_null($attendance->CheckOut)) {

                            if ($attendance->CheckOut < $bread_end_time){
                                    $attendenceDay +=0;
                            }elseif ( $attendance->CheckOut > $bread_end_time && $attendance->CheckOut < $office_end_time ){
                                  $attendenceDay +=0.5;
                            }else{
                                    $attendenceDay +=0.5;
                            }
                        }else {
                             $attendenceDay +=0;
                        }
                        }
                     @endphp
                 @endforeach
                        @php
                            $leaveDay= $workdayOfMonth  -  $attendenceDay;
                            $total= $attendenceDay * $perDay;
                        @endphp
            <tr>
                <td class="text-nowrap">{{$employee->name}}</td>
                <td >{{implode(',',$employee->roles->pluck('name')->toArray())}}</td>
                <td class="text-center">{{$dayOfMonth}}</td>
                <td>{{$workdayOfMonth}}</td>
                <td>{{$offDay}}</td>
                 <td>{{$attendenceDay}}</td>
                <td>{{$leaveDay}}</td>
                <td>{{number_format($perDay)}}</td>
                <td>{{number_format($total)}}</td>

            </tr>

        @endforeach


        </tbody>
    </table>
</div>
