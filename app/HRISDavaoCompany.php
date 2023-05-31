<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class HRISDavaoCompany extends Model
{
	protected $connection = 'sqlsrv_dvo_hris';
    public $table = 'HRCompany';

   
}
