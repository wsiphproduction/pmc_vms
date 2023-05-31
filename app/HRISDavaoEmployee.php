<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class HRISDavaoEmployee extends Model
{
	protected $connection = 'sqlsrv_dvo_hris';
    public $table = 'ViewHREmpMaster';

	public function deptDetails()
    {
    	return $this->belongsTo('\App\HRISDavaoDepartment','DeptID', 'DeptID');
    }

    public function posDetails()
    {
    	return $this->belongsTo('\App\HRISDavaoPosition','PositionID', 'PositionID');
    }

    public function comDetails()
    {
        return $this->belongsTo('\App\HRISDavaoCompany','CompanyID', 'CompanyID');
    }
}
