<?php

namespace App\Http\Controllers;



use App\Department;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\EditDepartment;
use App\Http\Requests\StoreDepartment;




class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->can('view_department')){
            abort(403);
    }
        return view('department.index');
    }

    public function ssd(Request $request){
        if(!auth()->user()->can('view_department')){
            abort(403);
        }
        $users= Department::query();
        return Datatables::of($users)

        ->addColumn('plus-icon',function(){
        return null;
            })
         ->addColumn('action',function($each){
             $action_del='';
             $action_edit='';
             if(auth()->user()->can('edit_department')){
                $action_edit= '<a  href="'.route('department.edit',$each->id).'" class="text-warning"><i class="fas fa-user-edit"></i></a>';

             }
             if(auth()->user()->can('delete_department')){
                $action_del='<a href="#" class="text-danger delete-department" data-id='.$each->id.'><i class="icofont-trash"></i></a>';

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
    {
        return view(' department.create ');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreDepartment $request)
    {

         $departments=new Department();
        $departments->title=$request->title;

        $departments->save();
            return redirect()->route('department.index')->with('success',"$request->title has been Created ");

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
         $department=Department::findOrFail($id);
        return view('department.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditDepartment $request, $id)
    {
        $departments= Department::findOrFail($id);
         $departments->title=$request->title;
         $departments->save();
            return redirect()->route('department.index')->with('update'," $request->title   has been Updated ");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $departments=Department::findOrFail($id);
        $departments->delete();
       return 'success';

    }

}
