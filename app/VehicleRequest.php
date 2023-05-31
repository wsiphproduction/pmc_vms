<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class VehicleRequest extends Model implements AuditableContract
{

    use Auditable;
    use SoftDeletes;

    public $table = 'vehicle_request';

    public $fillable = [
        'dept',
        'date_needed',
        'addedAt',
        'purpose',
        'email',
        'costCode',
        'addedAt',
        'Cancelled_at',
        'status',
        'lastStatusChanged',
        'dept_id',
        'message_id'
    ];
    public $auditInclude = [
        'dept',
        'date_needed',
        'addedAt',
        'purpose',
        'email',
        'costCode',
        'addedAt',
        'Cancelled_at',
        'status',
        'lastStatusChanged',
        'dept_id',
        'message_id'
    ];

    // Rules for validating vehicle request forms
    public static $rules_create = [
        'dept' => 'required|string',
        'date_needed' => 'required|date',
        'purpose' => 'required|string',
        'costCode' => 'required|string'
    ];

    public static $rules_update = [
        'dept' => 'string',
        'date_needed' => 'date',
        'purpose' => 'string',
        'costCode' => 'string'
    ];

    public function department(){
        return $this->belongsTo('App\Department', 'dept_id');
    }

    public function status(){
        return $this->belongsTo('App\VehicleRequestStatus', 'status');
    }

    public function message(){
        return $this->hasOne('App\VehicleRequestMessage', 'vehicle_request_id')->latest();
    }

    public function tripTicket(){
        return $this->hasMany('App\Dispatch', 'request_id');
    }

    public function requestOtherInfo(){
        return $this->hasOne('App\RequestOtherInfo', 'request_id');
    }

    public function getDateNeededAttribute($value){
        return str_replace(' 00:00:00', '', $value);
    }
}
