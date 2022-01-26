<?php

namespace App\Http\Controllers;

use App\User;
use App\CheckInCheckOut;
use App\Company_settings;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;




class CheckInCheckOutController extends Controller
{
    public function checkIncheckOut(){

       $hash_value=Hash::make(date('Y-m-d'));
        return view('checkIn-checkOut',compact('hash_value'));
    }
    public function checkIncheckOutStore(Request $request){
        // return $request->pin_code;

        if (now()->format('D') == 'Sat' ||  now()->format('D') == 'Sun')
        {
            return[
                'status'=>'fail',
                'message'=>'Today is office off day',

            ];
        }
        $user=User::Where('pin_code',$request->pin_code)->first();
        if(!$user){
            return[
                'status'=>'fail',
                'message'=>'Pin Code is Wrong',

            ];
        }

        $checkin_checkout_data=CheckInCheckOut::firstOrCreate(
            [
                    'user_id'=>$user->id,
                    'date'=>now()->format('Y-m-d'),
        ]
        );
        if(!is_null($checkin_checkout_data->CheckIn) && !is_null($checkin_checkout_data->CheckOut)){
            return[
                'status'=>'fail',
                'message'=>"You have already Check Out today",
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
