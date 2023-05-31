<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class HRISAgusanEmployee extends Model
{
	protected $connection = 'sqlsrv_agn_hris';
    public $table = 'ViewHREmpMaster';

    public function deptDetails()
    {
    	return $this->belongsTo('\App\HRISAgusanDepartment','DeptID', 'DeptID');
    }

    public function posDetails()
    {
    	return $this->belongsTo('\App\HRISAgusanPosition','PositionID', 'PositionID');
    }

    public function comDetails()
    {
        return $this->belongsTo('\App\HRISAgusanCompany','CompanyID', 'CompanyID');
    }
	
}
