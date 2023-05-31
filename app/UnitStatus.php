<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class UnitStatus extends Model implements AuditableContract
{

    use Auditable;
    public $table = 'unit_status';

    protected $fillable = [
        'status',
    ];
    protected $auditInclude = [
        'status',
    ];
}
