<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FMSIssuanceRequest extends Model
{
    protected $connection = "sqlsrv_fms";
    protected $table = 'issuance_request_tbl';
}

