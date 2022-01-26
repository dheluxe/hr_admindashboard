<?php

namespace App\Http\Controllers;



use App\Department;
use App\Http\Requests\EditSalary;
use App\Salery;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

use App\Http\Requests\StoreSalary;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->can('view_salary')){
            abort(403);
    }
        return view('salary.index');
    }

    public function ssd(Request $request){
        if(!auth()->user()->can('view_salary')){
            abort(403);
        }
        $salaries= Salery::with('employee');
        return Datatables::of($salaries)

          ->filterColumn('employee_name',function ($query,$keyword){
              $query->whereHas('employee',function ($q1) use ($keyword){
                 $q1->where('name','like','%'.$keyword.'%');
              });
          })


        ->addColumn('employee_name',function ($each){
          return  $each->employee ? $each->employee->name : '-';
        })
        ->addColumn('plus-icon',function(){
        return null;
            })
         ->addColumn('action',function($each){
             $action_del='';
             $action_edit='';
             if(auth()->user()->can('edit_salary')){
                $action_edit= '<a  href="'.route('salary.edit',$each->id).'" class="text-warning"><i class="fas fa-user-edit"></i></a>';

             }
             if(auth()->user()->can('delete_salary')){
                $action_del='<a href="#" class="text-danger delete-salary" data-id='.$each->id.'><i class="icofont-trash"></i></a>';

             }
                return '<div class="action-icon d-flex align-content-center justify-content-center">'.$action_edit.$action_del.'</div>';
                    })
            ->editColumn('amount',function ($each){
                return number_format($each->amount).' '.'MMK';
            })

            ->editColumn('month',function ($each){
                return Carbon::parse('2021-'.$each->month.'-01')->format('F');
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
    {
        $employees=User::all();
        return view(' salary.create ',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreSalary $request)
    {

         $salaries=new Salery();
        $salaries->user_id=$request->user_id;
        $salaries->year=$request->year;
        $salaries->month=$request->month;
        $salaries->amount=$request->amount;


        $salaries->save();
            return redirect()->route('salary.index')->with('success',"Salary has been Created ");

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
         $employees=User::all();
         $salaries=Salery::findOrFail($id);
        return view('salary.edit',compact('salaries','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditSalary $request, $id)
    {
        $salaries= Salery::findOrFail($id);
        $salaries->user_id=$request->user_id;
        $salaries->month=$request->month;
        $salaries->year=$request->year;
        $salaries->amount=$request->amount;
        $salaries->update();
            return redirect()->route('salary.index')->with('update'," $request->title   has been Updated ");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salaries=Salery::findOrFail($id);
        $salaries->delete();
       return 'success';

    }

}
