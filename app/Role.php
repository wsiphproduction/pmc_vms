<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Role extends Model implements AuditableContract
{

    use Auditable;


	protected $guarded = [];

    protected $fillable = [
        'name', 
        'description', 
        'active',
    ];
    protected $auditInclude = [
        'name', 
        'description', 
        'active',
    ];
}
