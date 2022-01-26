<?php

namespace App\Http\Controllers;

use App\CheckInCheckOut;

use App\CompanySetting;
use App\Department;
use App\Http\Requests\EditAttendance;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\EditDepartment;

use App\Http\Requests\StoreRequest;
use App\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!auth()->user()->can('view_attendance')){
            abort(403);
    }
        return view('attendance.index');
    }

    public function ssd(Request $request){
        if(!auth()->user()->can('view_attendance')){
            abort(403);
        }
        $attendances= CheckInCheckOut::with('employee');
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
         ->addColumn('action',function($each){
             $action_del='';
             $action_edit='';
             if(auth()->user()->can('edit_attendance')){
                $action_edit= '<a  href="'.route('attendance.edit',$each->id).'" class="text-warning"><i class="fas fa-user-edit"></i></a>';

             }
             if(auth()->user()->can('delete_attendance')){
                $action_del='<a href="#" class="text-danger delete-attendance" data-id='.$each->id.'><i class="icofont-trash"></i></a>';

             }
                return '<div class="action-icon d-flex align-content-center justify-content-center">'.$action_edit.$action_del.'</div>';
                    })
         ->rawColumns(['action'])
        ->make(true);
            }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   if(!auth()->user()->can('create_attendance')){
        abort(403);
    }
        $employees=User::orderBy('employee_id')->get();
        return view(' attendance.create ',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreRequest $request)
    {
          if(!auth()->user()->can('create_attendance')){
            abort(403);
        }
        if (CheckInCheckOut::where('user_id', $request->user_id)->where('date', $request->date)->exists()) {
            return back()->withErrors(['fail' => 'Already defined.'])->withInput();
        }
        $attendance = new CheckInCheckOut();
        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->CheckIn = $request->date . ' ' . $request->CheckIn;
        $attendance->CheckOut = $request->date . ' ' . $request->CheckOut;
        $attendance->save();
            return redirect()->route('attendance.index')->with('success',"CheckIn time has been Created ");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

     {
        if(!auth()->user()->can('edit_attendance')){
            abort(403);
        }
        $attendance= CheckInCheckOut::findOrFail($id);
         $employees=User::all();
        return view('attendance.edit',compact('attendance','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditAttendance $request, $id)
    {
        if(!auth()->user()->can('edit_attendance')){
            abort(403);
        }
        $attendances= CheckInCheckOut::findOrFail($id);

        if (CheckInCheckOut::where('user_id', $request->user_id)->where('id','!=',$attendances->id)->where('date', $request->date)->exists()) {
           return back()->withErrors(['fail' => 'Already defined.'])->withInput();
       }
       $attendances->user_id = $request->user_id;
       $attendances->date = $request->date;
       $attendances->CheckIn = $request->date . ' ' . $request->CheckIn;
       $attendances->CheckOut = $request->date . ' ' . $request->CheckOut;
       $attendances->save();

            return redirect()->route('attendance.index')->with('update'," Attendance   has been Updated ");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendances=CheckInCheckOut::findOrFail($id);
        $attendances->delete();
       return 'success';

    }
    public function  overview(Request $request){

        return view('attendance.attendance-overview');

    }
    public function  OverTable(Request $request){

        $year=$request->year;
        $month=$request->month;
        $employeename=$request->employeename;
        $star_of_month=$year.'-'.$month.'-'.'01';
        $end_of_month=Carbon::parse($star_of_month)->endOfMonth()->format('Y-m-d');
        $users=User::where('name','like','%'.$employeename.'%')->get();
        $periods = new CarbonPeriod($star_of_month, $end_of_month);
        $attendances=CheckInCheckOut::whereMonth('date',$month)->whereYear('date',$year)->get();
        $company=CompanySetting::findOrfail(1);
        return view('components.tableoverview',compact('users','periods','attendances','company'))->render();

    }

}
