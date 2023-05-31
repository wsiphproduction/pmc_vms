<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class UsersPermissions extends Model  implements AuditableContract
{
    
    use Auditable;
    protected $fillable = [
        'user_id', 
        'permission_id', 
        'module_id',
        'action',
    ];
    protected $auditInclude = [
        'user_id', 
        'permission_id', 
        'module_id',
        'action',
    ];

    
}
