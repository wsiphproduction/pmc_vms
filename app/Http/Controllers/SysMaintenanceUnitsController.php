<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Department;
use App\HRISAgusanDepartment;
use Illuminate\Http\Request;
use DB;
use App\Services\RoleRightService;

class SysMaintenanceUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(
        RoleRightService $roleRightService) 
        {
        $this->roleRightService = $roleRightService;
    }
    public function fms_index()
    {
        
        $units = Unit::where('isECS', 0)->get();

        $localDept = Department::get();
        $hrisDept = HRISAgusanDepartment::select(DB::raw('DISTINCT DeptDesc as name'))->orderBy('DeptDesc', 'asc')->get();
        $departments = array_merge($localDept->toArray(), $hrisDept->toArray());
        $dept = $departments;

        return view('admin.requests.reports.fms-vehicle-report', compact(
            'dept',
            'units'
        ));
    }

    public function fms_vehicles(Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Vehicle Master File");

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $localDept = Department::get();
        $hrisDept = HRISAgusanDepartment::select(DB::raw('DISTINCT DeptDesc as name'))->orderBy('DeptDesc', 'asc')->get();
        $departments = array_merge($localDept->toArray(), $hrisDept->toArray());
        $dept = $departments;


        if ($request != null) {

            $units = Unit::where('isECS', 0)->where('dept', $request->dept)->get();
        }

        return view('admin.requests.reports.fms-vehicle-report', compact(
            'dept',
            'units',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    public function vms_vehicles()
    {
       
        $rolesPermissions = $this->roleRightService->hasPermissions("Vehicle Master File");

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $units = Unit::where('isECS', null)->get();
        return view('admin.requests.reports.vms-vehicle-report', compact(
            'units',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }
}
