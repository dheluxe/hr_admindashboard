<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;



use Yajra\Datatables\Datatables;
use App\Http\Requests\EditPermission;
use App\Http\Requests\StorePermission;
use Spatie\Permission\Models\Permission;






class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(!auth()->user()->can('view_permission')){
//                abort(403);
//        }
        return view('permission.index');
    }

    public function ssd(Request $request){
        $permission= Permission::query();
//        if(!auth()->user()->can('view_permission')){
//            abort(403);
//    }
        return Datatables::of($permission)

        ->addColumn('plus-icon',function(){
        return null;
            })
         ->addColumn('action',function($each){
             $action_del='';
             $action_edit='';
            if(auth()->user()->can('edit_permission')){
                $action_edit= '<a  href="'.route('permission.edit',$each->id).'" class="text-warning"><i class="fas fa-user-edit"></i></a>';

                }
        if(auth()->user()->can('edit_permission')){
            $action_del='<a href="#" class="text-danger delete-permission" data-id='.$each->id.'><i class="icofont-trash"></i></a>';

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
//        if(!auth()->user()->can('create_permission')){
//            abort(403);
//    }
        return view(' permission.create ');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( StorePermission $request)
    {
//        if(!auth()->user()->can('create_permission')){
//            abort(403);
//    }
         $permission=new Permission();
        $permission->name=$request->name;

        $permission->save();
            return redirect()->route('permission.index')->with('success',"$request->name has been Created ");

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
//        if(!auth()->user()->can('edit_permission')){
//            abort(403);
//    }
         $permission=Permission::findOrFail($id);
        return view('permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPermission $request, $id)
    {
//        if(!auth()->user()->can('edit_permission')){
//            abort(403);
//    }
        $permission= Permission::findOrFail($id);
         $permission->name=$request->name;
         $permission->save();
            return redirect()->route('permission.index')->with('update'," $request->name   has been Updated ");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        if(!auth()->user()->can('delete_permission')){
//            abort(403);
//    }
        $permission=Permission::findOrFail($id);
        $permission->delete();
       return 'success';

    }

}
