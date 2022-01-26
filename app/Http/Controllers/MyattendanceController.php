<?php

namespace App\Http\Controllers;



use App\CheckInCheckOut;
use App\Company_settings;
use App\CompanySetting;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MyattendanceController extends Controller
{
    public function ssd(Request $request){

        $attendances= CheckInCheckOut::with('employee')->where('user_id',auth()->user()->id);
        if ($request->month){
            $attendance=$attendances->whereMonth('date',$request->month);
        }
        if ($request->year){
            $attendance=$attendances->whereYear('date',$request->year);
        }
        return Datatables::of($attendances)

            ->addColumn('plus-icon',function(){
                return null;
            })
            ->filterColumn('employee_name',function($query,$keyword){
                $query->whereHas('employee',function($q1) use($keyword){
                    $q1->where('name','like','%'.$keyword.'%');
                });

            })
            ->addColumn('employee_name',function($each){
                return $each->employee ?  $each->employee->name :'-';
            })
            ->editColumn('CheckIn',function($each){
                return Carbon::parse($each->CheckIn)->format('d-m-Y H:i:s') ;
            })
            ->editColumn('CheckOut',function($each){
                return Carbon::parse($each->CheckOut)->format('d-m-Y H:i:s') ;
            })


            ->make(true);
    }
            public function  OverTable(Request $request)
            {

                    $year=$request->year;
                    $month=$request->month;
                     $star_of_month=$year.'-'.$month.'-'.'01';
                    $end_of_month=Carbon::parse($star_of_month)->endOfMonth()->format('Y-m-d');
                    $users=User::where('id',auth()->user()->id)->get();
                    $periods = new CarbonPeriod($star_of_month, $end_of_month);
                    $attendances=CheckInCheckOut::whereMonth('date',$month)->whereYear('date',$year)->get();
                    $company=CompanySetting::findOrFail(1);
                    return view('components.tableoverview',compact('users','periods','attendances','company'))->render();

                     }

}
