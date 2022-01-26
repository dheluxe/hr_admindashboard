<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Department;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use App\Http\Requests\EditEmployee;
use App\Http\Requests\StoreEmployee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->can('view_employee')){
                abort(403,'Unauthorized action');
        }


        return view('employee.index');
    }

    public function ssd(Request $request){

        if(!auth()->user()->can('view_employee'))
        {
                    abort(403,'Unauthorized action');
            }
        $users= User::with('department');
        return Datatables::of($users)

       ->filterColumn('department_name',function($query,$keyword){
            $query->WhereHas('department',function($q1)  use ($keyword){
                    $q1->Where('title','like','%'.$keyword.'%');
            });
       })
        ->addColumn('department_name',function ($each){
           return $each->department ? $each->department->title : "-";
       })
        ->addColumn('plus-icon',function(){
        return null;
            })
         ->addColumn('action',function($each){

                $action_show='';
                $action_edit='';
                $action_del='';
                if(auth()->user()->can('view_profile'))
                {
                    $action_show= '<a  href="'.route('employee.show',$each->id).'" class="text-primary"><i class="fas fa-info-circle"></i></a>';

                    }
                if(auth()->user()->can('edit_employee'))
                {
                    $action_edit= '<a  href="'.route('employee.edit',$each->id).'" class="text-warning"><i class="fas fa-user-edit"></i></a>';

                 }
                    if(auth()->user()->can('delete_employee'))
                    {
                        $action_del='<a href="#" class="text-danger delete-employee" data-id='.$each->id.'><i class="icofont-trash"></i></a>';

                        }
                return '<div class="action-icon">'.$action_edit.$action_show.$action_del.'</div>';
                    })
        ->addColumn('roles',function($each){
            $output="";
            foreach ($each->roles as $role  ) {
                $output.='<spam class="badge badge-pill badge-primary p-1  ">'.$role->name.'</spam>';
            }
            return $output;
        })
        ->editColumn('is_present',function ($each){
            if($each->is_present == 1){
                return'<spam class="badge badge-pill badge-success ">Present</spam>';
            }else{
                return'<spam class="badge badge-pill badge-danger  ">Absent</spam>';
                 }
               })
               ->editColumn('img_upload',function ($each){
                   return '<img src="'.$each->img_path().'" class="img-dashboard"/> <p class="mb-0 mt-2 text-nowrap "><strong>'.$each->name.'</strong></p>';

               })
        ->editColumn('updated_at',function($each){
                   return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');

               })
        ->rawColumns(['is_present','action','email','img_upload','roles'])
        ->make(true);
            }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('create_employee'))
        {
                abort(403,'Unauthorized action');
                }
        $employers=Department::orderBy('title')->get();
        $roles=Role::all();

        return view(' employee.create ',compact('employers','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployee $request)
    {
        if(!auth()->user()->can('create_employee')){
            abort(403,'Unauthorized action');
    }
        $profile_img_name=null;
       if($request->hasFile('img_upload')){
           $img_file=$request->file('img_upload');
           $profile_img_name=uniqid().'-'.time() .'.'.$img_file->getClientOriginalExtension();
           Storage::disk('public')->put('employee/'.$profile_img_name, file_get_contents($img_file));
       }
         $employee=new User();
        $employee->employee_id=$request->employee_id;
        $employee->name=$request->name;
        $employee->email=$request->email;
        $employee->phone=$request->phone;
        $employee->nrc_number=$request->nrc_number;
        $employee->password=$request->password ? Hash::make($request->password): $employee->password;
        $employee->pin_code=$request->pin_code;
         $employee->gender=$request->gender;
        $employee->birthday=$request->birthday;
        $employee->address=$request->address;
        $employee->department_id=$request->department_id;
        $employee->date_of_join=$request->date_of_join;
        $employee->img_upload=$profile_img_name;
        $employee->is_present=$request->is_present;
        $employee->save();

        $employee->syncRoles($request->roles);
            return redirect()->route('employee.index')->with('success',"$request->name has been added ");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!auth()->user()->can('view_employee')){
            abort(403,'Unauthorized action');
    }
        $employee=User::findOrFail($id);
       return view('employee.show',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

     {
        if(!auth()->user()->can('edit_employee')){
            abort(403,'Unauthorized action');
    }
         $employer=User::findOrFail($id);
         $old_roles=$employer->roles->pluck('id')->toArray();
         $departments=Department::orderBy('title')->get();
         $role=Role::all();

        return view('employee.edit',compact('employer','departments','role','old_roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditEmployee $request, $id)
    {
        if(!auth()->user()->can('edit_employee')){
            abort(403,'Unauthorized action');
    }
        $employee= User::findOrFail($id);
        $profile_img_name=$employee->img_upload;
        if($request->hasFile('img_upload')){
            Storage::disk('public')->delete('employee/'.$employee->img_upload);
            $img_file=$request->file('img_upload');
            $profile_img_name=uniqid().'-'.time() .'.'.$img_file->getClientOriginalExtension();
            Storage::disk('public')->put('employee/'.$profile_img_name, file_get_contents($img_file));
        }

        $employee->employee_id=$request->employee_id;
        $employee->name=$request->name;
        $employee->email=$request->email;
        $employee->phone=$request->phone;
        $employee->nrc_number=$request->nrc_number;
        $employee->password=$request->password ? Hash::make($request->password) : $employee->password;
        $employee->pin_code=$request->pin_code;
        $employee->gender=$request->gender;
        $employee->birthday=$request->birthday;
        $employee->address=$request->address;
        $employee->department_id=$request->department_id;
        $employee->date_of_join=$request->date_of_join;
        $employee->is_present=$request->is_present;
        $employee->img_upload=$profile_img_name;
        $employee->syncRoles($request->roles);
        $employee->save();
            return redirect()->route('employee.index')->with('update',"Employee of $request->name  info has been Updated ");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->can('delete_employee')){
            abort(403,'Unauthorized action');
    }
        $employee=User::findOrFail($id);
        $employee->delete();
       return 'success';

    }

}
