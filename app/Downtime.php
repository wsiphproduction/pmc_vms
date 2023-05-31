<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Downtime extends Model implements AuditableContract
{

    use Auditable;
    public $table = 'downtime';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'dateStart',
        'dateEnd',
        'remarks',
        'addedBy',
        'addedDate',
        'unitId',
        'isScheduled',
        'shop',
        'workOrder',
        'repairType',
        'workDetails',
        'mechanics',
        'reportedDate',
        'status',
        'from12',
        'from7',
        'trepair_days',
        'trepair_hours',
        'shop_days',
        'shop_hours',
        'man_hours',
        'required_daily_availability',
        'tdowntime',
        'assignedTo',
        'active',
        'downtimeCategory',
        'created_at',
        'updated_at',
    ];
    
    protected $auditInclude = [
        'dateStart',
        'dateEnd',
        'remarks',
        'addedBy',
        'addedDate',
        'unitId',
        'isScheduled',
        'shop',
        'workOrder',
        'repairType',
        'workDetails',
        'mechanics',
        'reportedDate',
        'status',
        'from12',
        'from7',
        'trepair_days',
        'trepair_hours',
        'shop_days',
        'shop_hours',
        'man_hours',
        'required_daily_availability',
        'tdowntime',
        'assignedTo',
        'active',
        'downtimeCategory',
        'created_at',
        'updated_at',
    ];
}
