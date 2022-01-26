<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WebAuthnRegisterController;
use App\Http\Controllers\Auth\WebAuthnLoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/login-option','Auth\LoginController@loginOption')
    ->name('login-options');

Route::post('webauthn/register/options', [WebAuthnRegisterController::class, 'options'])
     ->name('webauthn.register.options');
Route::post('webauthn/register', [WebAuthnRegisterController::class, 'register'])
     ->name('webauthn.register');

Route::post('webauthn/login/options', [WebAuthnLoginController::class, 'options'])
     ->name('webauthn.login.options');
Route::post('webauthn/login', [WebAuthnLoginController::class, 'login'])
     ->name('webauthn.login');

Route::get('checkIn-checkOut', 'CheckInCheckOutController@checkIncheckOut');

Route::post('checkin-checkout/store','CheckInCheckOutController@checkIncheckOutStore');


Route::middleware('auth')->group(function(){
    Route::get('/','PageController@home')->name('home');

    Route::resource('employee','EmployeeController');
    Route::get('/employee/datable/ssd','EmployeeController@ssd');

    Route::resource('department','DepartmentController');
    Route::get('/department/datable/ssd','DepartmentController@ssd');

    Route::resource('role','RoleController');
    Route::get('/role/datable/ssd','RoleController@ssd');

    Route::resource('permission','PermissionController');
    Route::get('/permission/datable/ssd','PermissionController@ssd');

    Route::get('/profile','ProfileController@profile')->name('profile');
    Route::get('/profile/biometrics-data','ProfileController@biometricdata');
    Route::delete('/profile/biometric/{id}', 'ProfileController@biometricDelete');

   Route::get('/logout', 'ProfileController@logout');

   Route::resource('companysetting','CompanysettingController')->only(['edit','show','update']);

   Route::resource('attendance','AttendanceController');
   Route::get('/attendance/datable/ssd','AttendanceController@ssd');

   Route::get('attendance-overview','AttendanceController@overview')->name('attendance-overview');
    Route::get('attendance-overview/table','AttendanceController@OverTable')->name('attendance-overview-table');

   Route::get('attendance-scan','AttendanceScanController@scan')->name('attendanceScan');
   Route::post('attendanceScan/store','AttendanceScanController@scanStore')->name('attendanceScanStore');

    Route::get('/my-attendance/datable/ssd','MyattendanceController@ssd');
    Route::get('my-attendance-overview/table','MyattendanceController@OverTable');

    Route::resource('salary','SalaryController');
    Route::get('/salary/datable/ssd','SalaryController@ssd');

    Route::get('payroll-overview','PayrollController@overview')->name('payroll-overview');
    Route::get('payroll/table','PayrollController@OverTable')->name('payroll-table');

    Route::get('my-payroll/datable/ssd','MypayrollController@ssd');
    Route::get('my-payroll-overview/table','MypayrollController@Payrolltable');

    Route::resource('project','ProjectController');
    Route::get('/project/datable/ssd','ProjectController@ssd');

    Route::resource('my-project','MyProjectController');
    Route::get('my-project/datatable/ssd','MyProjectController@ssd');

    Route::resource('task','TaskController');
    Route::get('task-data','TaskController@TaskData');
    Route::get('taskDragrable','TaskController@Dragrable');
});
