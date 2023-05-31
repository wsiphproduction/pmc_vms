<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Assigned extends Model implements AuditableContract
{

    use Auditable;
    protected $table = 'assigned';
    protected $fillable = [
        'name',
        'active',
    ];
    protected $auditInclude = [
        'name',
        'active',
    ];
}
