<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Unit extends Model implements AuditableContract
{

    use Auditable;

    public $table = 'unit';
    
    protected $fillable = [
        'name',
        'type',
        'required_availability_hours',
        'active',
        'dept','model',
        'plateno',
        'chassisno',
        'engineno',
        'color',
        'datasource',
        'vehicle_code',
        'isECS',
        'odo_status',
        'is_dispose',
        'date_acquired',
        'date_registered',
        'date_deactivated'
    ];
    protected $auditInclude = [
        'name',
        'type',
        'required_availability_hours',
        'active',
        'dept','model',
        'plateno',
        'chassisno',
        'engineno',
        'color',
        'datasource',
        'vehicle_code',
        'isECS',
        'odo_status',
        'is_dispose'
    ];

    public function dispatches(){
        return $this->hasMany('App\Dispatch', 'unitId');
    }
}
