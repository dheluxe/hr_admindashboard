<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class MyProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('my_project');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ssd(Request $request){

        $projects= Project::with('leaders','members')->whereHas('leaders',function ($query){
            $query->where('user_id',auth()->user()->id);
        })->orWhereHas('members',function ($query){
            $query->where('user_id',auth()->user()->id);
        });
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



                    $action_show= '<a  href="'.route('my-project.show',$each->id).'" class="text-primary"><i class="fas fa-info-circle"></i></a>';


                return '<div class="action-icon d-flex align-content-center justify-content-center">'.$action_show.'</div>';
            })
            ->rawColumns(['action','priority','status','leaders','member'])
            ->make(true);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with('leaders', 'members','task')
            ->where('id', $id)
           ->where(function($query){
               $query->whereHas('leaders',function ($q1){
                   $q1->where('user_id',auth()->user()->id);
               })->orWhereHas('members',function ($q1){
                   $q1->where('user_id',auth()->user()->id);
               });
           })
            ->firstOrFail();
        return view('my_project_show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
