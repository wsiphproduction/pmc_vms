<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class RepairPreventive extends Model implements AuditableContract
{

    use Auditable;

    public $table = 'repair_preventive';

    protected $fillable = [
        'name',
        'active',
    ];
    protected $auditInclude = [
        'name',
        'active',
    ];  
}
