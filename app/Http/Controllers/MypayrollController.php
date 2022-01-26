<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\CompanySetting;
use App\CheckInCheckOut;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MypayrollController extends Controller
{
    public function  Payrolltable(Request $request){

        $year=$request->year;
        $month=$request->month;
        $employeename=$request->employeename;
        $star_of_month=$year.'-'.$month.'-'.'01';
        $end_of_month=Carbon::parse($star_of_month)->endOfMonth()->format('Y-m-d');
        $dayOfMonth=Carbon::parse($star_of_month)->daysInMonth;

        $workdayOfMonth = Carbon::parse($star_of_month)->diffInDaysFiltered(function (Carbon $date)  {
            Log::info($date.'->'.$date->isWeekday());
            return $date->isWeekday() ;
        }, Carbon::parse($end_of_month)->addDays(1));

        $offDay=$dayOfMonth - $workdayOfMonth;
        $employees=User::where('id',auth()->user()->id)->get();
        $periods = new CarbonPeriod($star_of_month, $end_of_month);
        $attendances=CheckInCheckOut::whereMonth('date',$month)->whereYear('date',$year)->get();
        $company=CompanySetting::findOrfail(1);
        return view('components.payroll_overview',compact('employees','periods','attendances','company','dayOfMonth','workdayOfMonth','offDay','month','year'))->render();

    }
}
