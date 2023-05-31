<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class RolesPermissions extends Model implements AuditableContract
{

    use Auditable;

    protected $fillable = [
        'role_id',
        'permission_id',
        'module_id',
        'action',
    ]; 
    protected $auditInclude = [
        'role_id',
        'permission_id',
        'module_id',
        'action',
    ];

}
