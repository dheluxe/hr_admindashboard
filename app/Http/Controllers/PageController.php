<?php

namespace App\Http\Controllers;

use App\Department;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class PageController extends Controller
{
public function  home(){
    $employee=auth()->user();
    return view('home',compact('employee'));
}


}
