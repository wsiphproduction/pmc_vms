<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AuditRepositoryInterface;
use \OwenIt\Auditing\Models\Audit;

class AuditRepository implements AuditRepositoryInterface
{
    protected $audit;

    public function __construct(Audit $audit)
    {
        $this->audit = $audit;
    }

    public function create($fields)
    {
        return $this->audit->create($fields);
    }   
}