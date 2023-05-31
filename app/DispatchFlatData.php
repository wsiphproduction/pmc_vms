<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class DispatchFlatData extends Model implements AuditableContract
{

    use Auditable;
    public $table = 'dispatchFlatData';

    public $fillable = [
        'unitId',
        'deptId',
        'date',
        'mins',
        'purpose',
        'type',
        'dispatchId',
        'tripTicket',
        'destination',
        'passengers',
        'odometer_start',
        'odometer_end',
        'fuel_consumption',
        'fuel_added_qty',
        'fuel_added_type',
        'request_id',
        'driver_id',
        'Cancelled_by',
        'Cancelled_at',
        'Closed_by',
        'Status',
        'isPrinted',
        'RQ',
        'fuel_requested_qty'
    ];
    public $auditInclude = [
        'unitId',
        'deptId',
        'date',
        'mins',
        'purpose',
        'type',
        'dispatchId',
        'tripTicket',
        'destination',
        'passengers',
        'odometer_start',
        'odometer_end',
        'fuel_consumption',
        'fuel_added_qty',
        'fuel_added_type',
        'request_id',
        'driver_id',
        'Cancelled_by',
        'Cancelled_at',
        'Closed_by',
        'Status',
        'isPrinted',
        'RQ',
        'fuel_requested_qty'
    ];
}
