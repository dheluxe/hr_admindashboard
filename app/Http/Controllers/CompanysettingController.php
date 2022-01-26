<?php

namespace App\Http\Controllers;

use App\Company_setting;
use App\Company_settings;
use App\CompanySetting;
use Illuminate\Http\Request;
use App\Http\Requests\EditCompanySetting;

class CompanysettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $settings=CompanySetting::findOrFail($id);
        return view('companysetting.show',compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(! auth()->user()->can('edit_company_setting') ){
                abort(403);
        }


       $settings=CompanySetting::findOrFail($id);
       return view('companysetting.edit',compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCompanySetting $request, $id)
    {
        $settings=CompanySetting::findOrFail($id);
        $settings->company_name=$request->company_name;
        $settings->company_phone=$request->company_phone;
        $settings->company_email=$request->company_email;
        $settings->company_address=$request->company_address;
        $settings->office_start_time=$request->office_start_time;
        $settings->office_end_time=$request->office_end_time;
        $settings->bread_start_time=$request->bread_start_time;
        $settings->bread_end_time=$request->bread_end_time;
        $settings->save();
        return redirect()->route('companysetting.show',$settings->id)->with('success',"Company setting has been  edited");
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
