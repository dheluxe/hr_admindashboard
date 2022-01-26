<?php

namespace Database\Seeders;

use App\User;
use Carbon\Carbon;
use App\CheckInCheckOut;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach($users as $user){
            $periods = new CarbonPeriod('2022-01-1', '2022-12-31');
            foreach($periods as $period){
                    if ($period->format('D') != 'Sat' && $period->format('D') != 'Sun'){
                        $attendance =new CheckInCheckOut() ;
                        $attendance->user_id = $user->id;
                        $attendance->date = $period->format('Y-m-d');
                        $attendance->CheckIn = Carbon::parse($period->format('Y-m-d') . ' ' . '09:00:00')->addMinutes(rand(1, 55));
                        $attendance->CheckOut = Carbon::parse($period->format('Y-m-d') . ' ' . '17:00:00')->subMinutes(rand(1, 55));
                        $attendance->save();
                    }

                }

        }
    }
}
