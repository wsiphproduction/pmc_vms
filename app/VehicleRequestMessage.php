<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class VehicleRequestMessage extends Model  implements AuditableContract
{

    use Auditable;

    public $table = 'vehicle_request_message';

    public $fillable = [
        'vehicle_request_id',
        'message'
    ];
    public $auditInclude = [
        'vehicle_request_id',
        'message'
    ];
}
