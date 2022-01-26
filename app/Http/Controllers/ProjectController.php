<?php

namespace App\Http\Controllers;



use App\Http\Requests\EditProject;
use App\Project;
use App\Department;
use App\ProjectLeader;
use App\Projectmember;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;
use App\Http\Requests\StoreProject;
use App\Http\Requests\EditDepartment;
use App\Http\Requests\StoreDepartment;
use Illuminate\Support\Facades\Storage;




class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->can('view_project')){
            abort(403);
    }
        return view('project.index');
    }

    public function ssd(Request $request){
        if(!auth()->user()->can('view_project')){
            abort(403);
        }
        $projects= Project::with('leaders');
        return Datatables::of($projects)

        ->addColumn('plus-icon',function(){
        return null;
            })
            ->addColumn('leaders',function ($each){
                $output='';
                foreach ($each->leaders as $leader){
                    $output .='<img src="'.$leader->img_path().'" class="img-project ">';
                }
                return '<div class="d-flex align-items-center justify-content-center">'.$output.'</div>';
            })
            ->addColumn('member',function ($each){
                $output='';
                foreach ($each->members as $member){
                    $output .='<img src="'.$member->img_path().'" class="img-project">';
                }
                return '<div class="d-flex align-items-center justify-content-center ">'.$output.'</div>';

            })
            ->editColumn('description',function ($each){
               return Str::limit($each->description, 40);
            })

            ->editColumn('priority',function ($each){
                if ($each->priority == 'middle'){
                    return '<spam class="badge badge-info"> middle</spam>';
                }
                if ($each->priority == 'high'){
                    return '<spam class="badge badge-danger"> High</spam>';
                }
                if ($each->priority == 'low'){
                    return '<spam class="badge badge-dark"> Low</spam>';
                }
            })
            ->editColumn('status',function ($each){
                if ($each->status == 'in_progress'){
                    return '<spam class="badge badge-info"> In Progress</spam>';
                }
                if ($each->status == 'pending'){
                    return '<spam class="badge badge-primary"> Pending</spam>';
                }
                if ($each->status == 'complete'){
                    return '<spam class="badge badge-success"> Complete</spam>';
                }
            })
         ->addColumn('action',function($each){
             $action_del='';
             $action_edit='';
             $action_show='';
             if(auth()->user()->can('edit_project')){
                $action_edit= '<a  href="'.route('project.edit',$each->id).'" class="text-warning"><i class="fas fa-user-edit"></i></a>';

             }
             if(auth()->user()->can('show_project')){
                 $action_show= '<a  href="'.route('project.show',$each->id).'" class="text-primary"><i class="fas fa-info-circle"></i></a>';
             }
             if(auth()->user()->can('delete_project')){
                $action_del='<a href="#" class="text-danger delete-project" data-id='.$each->id.'><i class="icofont-trash"></i></a>';

             }
                return '<div class="action-icon d-flex align-content-center justify-content-center">'.$action_edit.$action_del.$action_show.'</div>';
                    })
         ->rawColumns(['action','priority','status','leaders','member'])
        ->make(true);
            }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      $employees=User::all();
        return view(' project.create ',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProject $request)
    {
        $image_names=null;
        if($request->hasFile('images')){
            $image_names=[];
             $img_files=$request->file('images');
                foreach ($img_files as $img_file){
                    $img_name=uniqid().'-'.time().'.'.$img_file->getClientOriginalExtension();
                    Storage::disk('public')->put('project/' .$img_name,file_get_contents($img_file));
                    $image_names[]=$img_name;
                }
        }
        $file_names=null;
        if($request->hasFile('files')){
            $file_names=[];
            $files=$request->file('files');
            foreach ($files as $file){
                $file_name=uniqid().'-'.time(). '.' .$file->getClientOriginalExtension();
                Storage::disk('public')->put('project/'. $file_name,file_get_contents($file));
                $file_names[]=$file_name;
            }
        }
         $projects=new Project();
        $projects->title=$request->title;
        $projects->description=$request->description;
        $projects->images=$image_names;
        $projects->files=$file_names;
        $projects->start_date=$request->start_date;
        $projects->deadline=$request->deadline;
        $projects->priority=$request->priority;
        $projects->status=$request->status;
         $projects->save();

        $projects->leaders()->sync($request->leaders);
        $projects->members()->sync($request->members);
//         foreach (($request->leaders ?? []) as $leader){
//                $project_leaders=new ProjectLeader();
//                $project_leaders->user_id=$leader;
//             $project_leaders->project_id=$projects->id;
//             $project_leaders->save();
//                            }
//        foreach (($request->members ?? []) as $member){
//            $project_members=new Projectmember();
//            $project_members->user_id=$member;
//            $project_members->project_id=$projects->id;
//            $project_members->save();
//        }
         return redirect()->route('project.index')->with('success',"$request->title has been Created ");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $project=Project::findOrFail($id);
            return view('project.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

     {
         $project=Project::findOrFail($id);
         $employees=User::all();
        return view('project.edit',compact('project','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditProject $request, $id)
    {       $projects=Project::findOrFail($id);
        $image_names=$projects->images;
        if($request->hasFile('images')){
            $image_names=[];
            $img_files=$request->file('images');
            foreach ($img_files as $img_file){

                $img_name=uniqid().'-'.time().'.'.$img_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' .$img_name,file_get_contents($img_file));
                $image_names[]=$img_name;
            }
        }
        $file_names=$projects->files;
        if($request->hasFile('files')){
            $file_names=[];
            $files=$request->file('files');
            foreach ($files as $file){

                $file_name=uniqid().'-'.time(). '.' .$file->getClientOriginalExtension();
                Storage::disk('public')->put('project/'. $file_name,file_get_contents($file));
                $file_names[]=$file_name;
            }
        }

        $projects->title=$request->title;
        $projects->description=$request->description;
        $projects->images=$image_names;
        $projects->files=$file_names;
        $projects->start_date=$request->start_date;
        $projects->deadline=$request->deadline;
        $projects->priority=$request->priority;
        $projects->status=$request->status;
        $projects->update();

        $projects->leaders()->sync($request->leaders);
        $projects->members()->sync($request->members);
//        foreach (($request->leaders ?? []) as $leader){
//          ProjectLeader::firstOrCreate([
//              'project_id'=>$projects->id,
//              'user_id'=> $leader
//
//
//          ]);
//
//
//        }
//        foreach (($request->members ?? []) as $member){
//            Projectmember::firstOrCreate(
//                ['project_id'=>$projects->id,
//                'user_id'=> $member]);
//
//
//        }
            return redirect()->route('project.index')->with('update'," $request->title   has been Updated ");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projects=Project::findOrFail($id);

        $project_leaders=ProjectLeader::where('project_id',$projects->id)->get();
        foreach ($project_leaders as $leader){
            $leader->delete();
        }
        $project_members=Projectmember::where('project_id',$projects->id)->get();
        foreach ($project_members as $member){
            $member->delete();
        }
        $projects->delete();
       return 'success';

    }

}
