<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Contracts\UserResolver;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements AuditableContract, UserResolver
{
    use Notifiable;
    use Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'id'; //making sure that id is primary key

    protected $fillable = [
        'fullname', 'email', 'dpassword','domain','isLocked','isApprover','dept','role','active', 'isdepartment','role_id','password'
    ];
    protected $auditInclude = [
        'fullname', 'email', 'dpassword','domain','isLocked','isApprover','dept','role','active', 'isdepartment','role_id','password'
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
    public static function resolve()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }
}
