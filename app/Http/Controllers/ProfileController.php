<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
   public function profile(){
       $employee=auth()->user();
       $biometrics=DB::table('web_authn_credentials')->where('user_id',$employee->id)->get();
      return view('profile.profile',compact('employee','biometrics'));
   }
   public function logout(){
       Auth::logout();
       return redirect('login');
   }
   public function biometricdata(){
    $employee=auth()->user();
    $biometrics=DB::table('web_authn_credentials')->where('user_id',$employee->id)->get();
   return view('components.old-biometric',compact('employee','biometrics'))->render();
   }
   public function biometricDelete($id){
    $employee=auth()->user();
    $biometrics=DB::table('web_authn_credentials')->where('id',$id)->where('user_id',$employee->id)->delete();
    return 'success';
   }
}
