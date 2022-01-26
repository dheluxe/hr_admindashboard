<?php

namespace App\Http\Controllers;

use App\CheckInCheckOut;

use App\CompanySetting;
use App\Department;
use App\Http\Requests\EditAttendance;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\Datatables\Datatables;
use App\Http\Requests\EditDepartment;

use App\Http\Requests\StoreRequest;
use App\User;
use Carbon\Carbon;

class PayrollController extends Controller
{

    public function  overview(Request $request){
        if(!auth()->user()->can('view_salary') ){
           abort(403);
        }
        return view('payroll-overview');




    }
    public function  OverTable(Request $request){

        $year=$request->year;
        $month=$request->month;
        $employeename=$request->employeename;
        $star_of_month=$year.'-'.$month.'-'.'01';
        $end_of_month=Carbon::parse($star_of_month)->endOfMonth()->format('Y-m-d');
        $dayOfMonth=Carbon::parse($star_of_month)->daysInMonth;
            Log::info($date.'->'.'$date->isWeekday()');
         $workdayOfMonth = Carbon::parse($star_of_month)->subDays('1')->diffInDaysFiltered(function (Carbon $date)  {
             return $date->isWeekday() ;
        }, Carbon::parse($end_of_month));

        $offDay=$dayOfMonth - $workdayOfMonth;
        $employees=User::where('name','like','%'.$employeename.'%')->get();
        $periods = new CarbonPeriod($star_of_month, $end_of_month);
        $attendances=CheckInCheckOut::whereMonth('date',$month)->whereYear('date',$year)->get();
        $company=CompanySetting::findOrfail(1);
        return view('components.payroll_overview',compact('employees','periods','attendances','company','dayOfMonth','workdayOfMonth','offDay','month','year'))->render();

    }

}
