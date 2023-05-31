<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class RepairBreakdown extends Model implements AuditableContract
{

    use Auditable;

    public $table = 'repair_breakdown';

    protected $fillable = [
        'name',
        'active',
    ];
    protected $auditInclude = [
        'name',
        'active',
    ];  
}
