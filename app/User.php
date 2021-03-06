<?php

namespace App;

use App\Salery;
use App\Department;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use DarkGhostHunter\Larapass\WebAuthnAuthentication;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DarkGhostHunter\Larapass\Contracts\WebAuthnAuthenticatable;


class User extends Authenticatable implements WebAuthnAuthenticatable
{
    use Notifiable, HasRoles,WebAuthnAuthentication;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department(){
        return $this->belongsTo(Department::class,'department_id','id');
    }
    public function img_path(){
        if($this->img_upload){
                return asset('storage/employee/'. $this->img_upload);
        }
        return null;
    }
    public function  salaries(){
        return $this->hasMany(Salery::class,'user_id','id');
    }
}
