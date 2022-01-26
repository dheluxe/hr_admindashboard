<div class="table-responsive">
    <table class="table table-bordered table-striped  " style="width:100%;">
        <thead>
        <th>Employee</th>
        @foreach($periods as $period )
            <th class=" text-center @if($period->format('D') == 'Sat' || $period->format('D') == 'Sun') alert-danger @endif">{{$period->format('d')}}
                <br> {{$period->format('D')}}</th>
        @endforeach
        </thead>
        <tbody>

        @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                @foreach ($periods as $period)
                    @php
                        $checkIn_icon='';
                        $checkOut_icon='';
                        $office_start_time=$period->format('Y-m-d').' '. $company->office_start_time;
                        $office_end_time=$period->format('Y-m-d').' '. $company->office_end_time;
                        $bread_start_time=$period->format('Y-m-d').' '. $company->bread_start_time;
                        $bread_end_time=$period->format('Y-m-d').' '. $company->bread_end_time;
                            $attendance=collect($attendances)->where('user_id',$user->id)->where('date',$period->format('Y-m-d'))->first();
                            if ($attendance){
                                if (!is_null($attendance->CheckIn)) {
                                          if ($attendance->CheckIn < $office_start_time) {
                                $checkIn_icon='<i class="far fa-check-circle text-success"></i>';
                            }elseif ($attendance->CheckIn >  $office_start_time && $attendance->CheckIn < $bread_start_time ) {
                                 $checkIn_icon='<i class="far fa-check-circle text-warning"></i>';
                            }else {
                                 $checkIn_icon='<i class="far fa-times-circle text-danger"></i>';
                            }
                                }else{
                                     $checkIn_icon='<i class="far fa-times-circle text-danger"></i>';
                                }

                                if ($attendance->CheckOut) {
                                        if ($attendance->CheckOut < $bread_end_time){
                                        $checkOut_icon='<i class="far  fa-times-circle  text-danger"></i>';
                                }elseif ( $attendance->CheckOut > $bread_end_time && $attendance->CheckOut < $office_end_time ){
                                       $checkOut_icon='<i class="far fa-check-circle text-warning "></i>';
                                }else{
                                         $checkOut_icon='<i class="far fa-check-circle text-success"></i>';
                                }
                                }else {
                               $checkOut_icon='<i class="far  fa-times-circle  text-danger"></i>';

                                }

                            }
                    @endphp
                    <td @if($period->format('D') == 'Sat' || $period->format('D') == 'Sun') class="alert-danger" @endif>
                        <p class="mb-0">{!! $checkIn_icon!!}</p>
                        <p class="mb-0">{!! $checkOut_icon!!}</p>
                    </td>
                @endforeach
            </tr>
        @endforeach


        </tbody>
    </table>
</div>
