<?php

namespace App\Http\Controllers;




use Illuminate\Http\Request;
use App\Http\Requests\EditRole;
use App\Http\Requests\StoreRole;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;






class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(!auth()->user()->can('view_role')){
//            abort(403);
//        }
        return view('role.index');
    }

    public function ssd(Request $request){
//        if(!auth()->user()->can('view_role')){
//            abort(403);
//        }
        $roles= Role::query();
        return Datatables::of($roles)

        ->addColumn('plus-icon',function(){
        return null;
            })
            ->addColumn('permissions',function($each){
               $output='';
               foreach ($each->permissions as $permission) {
                    $output .= '<span class="badge badge-info m-1 text-secondary">'.$permission->name.'</span>';
               }
               return $output;
            })
         ->addColumn('action',function($each){
                $action_edit='';
                $action_del='';
             if(auth()->user()->can('edit_role')){
                $action_edit= '<a  href="'.route('role.edit',$each->id).'" class="text-warning"><i class="fas fa-user-edit"></i></a>';
                 }
                if(auth()->user()->can('delete_role')){
                    $action_del='<a href="#" class="text-danger delete-role" data-id='.$each->id.'><i class="icofont-trash"></i></a>';

                }
                return '<div class="action-icon d-flex align-content-center justify-content-center">'.$action_edit.$action_del.'</div>';
                    })
         ->rawColumns(['action','permissions'])
        ->make(true);
            }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
//        if(!auth()->user()->can('create_role')){
//            abort(403);
//        }
         $permissions=Permission::all();
        return view(' role.create ',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreRole $request)
    {
//        if(!auth()->user()->can('create_role')){
//            abort(403);
//        }
         $roles=new Role();
        $roles->name=$request->name;
        $roles->givePermissionTo($request->permissions);

        $roles->save();
            return redirect()->route('role.index')->with('success',"$request->name has been Created ");

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
//        if(!auth()->user()->can('edit_role')){
//            abort(403);
//        }
         $roles=Role::findOrFail($id);
         $oldpermissions=  $roles->permissions->pluck('id')->toArray();
         $permissions=Permission::all();
         return view('role.edit',compact('roles','permissions','oldpermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRole $request, $id)
    {
//        if(!auth()->user()->can('edit_role')){
//            abort(403);
//        }
        $roles= Role::findOrFail($id);
         $roles->name=$request->name;
         $roles->save();
         $oldpermissions=  $roles->permissions->pluck('name')->toArray();
         $roles->revokePermissionTo($oldpermissions);
         $roles->givePermissionTo($request->permissions);
            return redirect()->route('role.index')->with('update'," $request->name   has been Updated ");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        if(!auth()->user()->can('delete_role')){
//            abort(403);
//        }
        $roles=Role::findOrFail($id);
        $roles->delete();
       return 'success';

    }

}
