<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ReportRepositoryInterface;
use \OwenIt\Auditing\Models\Audit;

class ReportRepository implements ReportRepositoryInterface
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