<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Drivers extends Model implements AuditableContract
{

    use Auditable;
    public $table = 'drivers';

    public $fillable = [
        'driver_name',
        'type',
        'isActive'
    ];
    
    public $auditInclude = [
        'driver_name',
        'type',
        'isActive'
    ];
}
