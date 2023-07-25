<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\RoleRightService;
use App\Models\User;
use App\Http\Controllers\Controller;

class UtilizationController extends Controller
{
    public function __construct(RoleRightService $roleRightService) 
    {
        $this->roleRightService = $roleRightService;
    }
    
    public function dashboard()
    {   
        
        $rolesPermissions = $this->roleRightService->hasPermissions("Utilization Dashboard");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $date = date('y-m-d');
        $start = date("Y-m-01", strtotime($date));
        $end = date("Y-m-t", strtotime($date));
        
        return view('admin.utilization.index', compact(
            'start',
            'end',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    public function frequentDestination()
    {
       
    }
        
    public function index()
    {
        $users = User::all();
        return view('users', ['users' => $users]);
       
        $jsondata = array(
            "chart" => array(
                "caption" => "FREQUENT DESTINATIONS",
                "xAxisName" => "",
                "showValues" => "1",
                "theme" => "fusion"
            )
        );

        $jsondata["data"] = array();

        $query = "SELECT top 10 SUBSTRING(destination,CHARINDEX('-',destination),LEN(destination)) AS dest, COUNT(destination) AS total FROM dispatch GROUP BY destination ORDER BY total DESC";
        $result = DB::select($query);
        $result = (array) $result;

        foreach ($result as $value) {
            array_push($jsondata["data"], array(
                "label" => strtoupper($value->dest),
                "value" => str_replace('-', ' ', $value->total)
            ));
        }

        if (empty($result)) {
            array_push($jsondata["data"], array(
                "label" => 0,
                "value" => 0
            ));
        }

        return view('admin.utilization.frequent-destination', compact('jsondata'));
    }


    public function vehicleDistance()
    {
        
        $jsondata = array(
            "chart" => array(
                "caption" => "VEHICLE DISTANCE TRAVELLED",
                "xAxisName" => "",
                "showValues" => "1",
                "theme" => "fusion"
            )
        );

        $jsondata["data"] = array();

        $query = "SELECT type, odometer_start, odometer_end, odometer_end - odometer_start AS sub FROM dispatch ORDER BY sub DESC";
        $result = DB::select($query);
        $result = (array) $result;

        foreach ($result as $value) {
            array_push($jsondata["data"], array(
                "label" => strtoupper($value->type),
                "value" => str_replace('-', ' ', $value->sub)
            ));
        }

        if (empty($result)) {
            array_push($jsondata["data"], array(
                "label" => 0,
                "value" => 0
            ));
        }

        return view('admin.utilization.vehicle-distance', compact('jsondata'));
    }

    public function dispatchesDepartment()
    {
        
        $jsondata = array(
            "chart" => array(
                "caption" => "DISPATCH DISTRIBUTION PER DEPARTMENT",
                "xAxisName" => "",
                "showValues" => "1",
                "theme" => "fusion"
            )
        );

        $jsondata["data"] = array();

        $query = "SELECT deptId, count(deptId) AS total FROM dispatch GROUP BY deptId ORDER BY total DESC";
        $result = DB::select($query);
        $result = (array) $result;

        foreach ($result as $value) {
            array_push($jsondata["data"], array(
                "label" => strtoupper($value->deptId),
                "value" => $value->total
            ));
        }

        if (empty($result)) {
            array_push($jsondata["data"], array(
                "label" => 0,
                "value" => 0
            ));
        }

        return view('admin.utilization.dispatches-per-department', compact('jsondata'));
    }

    public function dispatchesVehicle()
    {
        
        $jsondata = array(
            "chart" => array(
                "caption" => "VEHICLE TOTAL NO. OF DISPATCHES",
                "xAxisName" => "",
                "showValues" => "1",
                "theme" => "fusion"
            )
        );

        $jsondata["data"] = array();

        $query = "SELECT TOP 10 type, count(type) AS total FROM dispatch GROUP BY type ORDER BY total DESC ";
        $result = DB::select($query);
        $result = (array) $result;

        foreach ($result as $value) {
            array_push($jsondata["data"], array(
                "label" => strtoupper($value->type),
                "value" => $value->total
            ));
        }

        if (empty($result)) {
            array_push($jsondata["data"], array(
                "label" => 0,
                "value" => 0
            ));
        }
        
        return view('admin.utilization.dispatches-per-department', compact('jsondata'));
    }
}
