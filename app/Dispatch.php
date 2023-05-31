<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Enums\DispatchStatusEnum;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Dispatch extends Model implements AuditableContract
{

    use Auditable;
    public $table = 'dispatch';

    public $fillable = [
        'unitId',
        'deptId',
        'dateStart',
        'dateEnd',
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
        'fuel_requested_qty',
        'itemCode',
        'uom',
        'numberOfTrips',
        'vehicle_cost_code',
        'do',
        'app_date',
        'unitId',
		'addedBy',
		'addedDate'
    ];
    public $auditInclude = [
        'unitId',
        'deptId',
        'dateStart',
        'dateEnd',
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
        'fuel_requested_qty',
        'itemCode',
        'uom',
        'numberOfTrips',
        'vehicle_cost_code',
        'do',
        'app_date',
        'unitId',
		'addedBy',
		'addedDate'
    ];
    public function driver(){
        return $this->belongsTo('App\Drivers', 'driver_id');
    }

    public function fuel_type(){
        return $this->belongsTo('App\FuelTypes', 'fuel_added_type');
    }

    public function unit(){
        return $this->belongsTo('App\Unit', 'unitId');
    }

    public function request(){
        return $this->belongsTo('App\VehicleRequest', 'request_id');
    }

    public function scopeDistanceTravelled($query){
        return $query->selectRaw('odometer_start - odometer_end as distance, dispatch.id, dispatch.unitId, dispatch.odometer_start, dispatch.odometer_end')
        ->where('status', DispatchStatusEnum::COMPLETE)
        ->with(['unit:id,type'])
        ->orderBy('distance', 'desc')
        ->limit(10);
    }

}
