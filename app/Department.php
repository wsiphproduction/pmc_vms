<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Enums\DispatchStatusEnum;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Department extends Model implements AuditableContract
{

    use Auditable;
    public $table = 'department';
    
    public $fillable = [
        'name'
    ]; public $auditInclude = [
        'name'
    ];  

    public function dispatch(){
        return $this->hasMany('App\Dispatch', 'deptId');
    }

    public function scopeDispatches($query){
        return $query->with([
            'dispatch'
        ])
        ->whereHas('dispatch', function($query){
            $query->where('status', '<>', DispatchStatusEnum::CANCELLED);
        });
    }
}
