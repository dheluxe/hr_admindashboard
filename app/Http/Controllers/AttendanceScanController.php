<?php

namespace App\Http\Controllers;

use App\CheckInCheckOut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AttendanceScanController extends Controller
{
    public function scan(){

        return view('attendance_scan');
    }
    public function scanStore(Request $request){
        if (now()->format('D') == 'Sat' ||  now()->format('D') == 'Sun')
        {
            
            return[
                'status'=>'fail',
                'message'=>'Today is office off day',

            ];
        }
        if(!Hash::check(date('Y-m-d'), $request->hash_value)){
            return[
                'status'=>'fail',
                'message'=>'Qr Code is Wrong',

            ];
        }
        $user=auth()->user();


        $checkin_checkout_data=CheckInCheckOut::firstOrCreate(
            [
                    'user_id'=>$user->id,
                    'date'=>now()->format('Y-m-d'),
        ]
        );
        if(!is_null($checkin_checkout_data->CheckIn) && !is_null($checkin_checkout_data->CheckOut)){
            return[
                'status'=>'fail',
                'message'=>"You have already Check In today",
        ];
        }
        if (is_null($checkin_checkout_data->CheckIn)) {
            $checkin_checkout_data->CheckIn = now();
            $message = 'Successfully check in at ' . now();
        } else {
            if (is_null($checkin_checkout_data->CheckOut)) {
                $checkin_checkout_data->CheckOut = now();
                $message = 'Successfully check out at ' . now();
            }
        }
        $checkin_checkout_data->update();


        return[
                'status'=>'success',
                'message'=>$message,
        ];


    }

}
