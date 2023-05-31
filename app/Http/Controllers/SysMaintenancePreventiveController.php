<?php

namespace App\Http\Controllers;

use App\RepairPreventive;
use Illuminate\Http\Request;
use App\Services\RoleRightService;
use Illuminate\Support\Facades\Session;

class SysMaintenancePreventiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Vehicle Maintenance");

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $preventive = RepairPreventive::all();
        return view('admin.maintenance.preventive', compact(
            'preventive',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        RepairPreventive::create([
            'name' => $request->get('name'),
            'active' => 1
        ]);

        Session::flash('success', " Preventive Maintenance Created Successfully...");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Vehicle Maintenance");

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $item = RepairPreventive::find($id);
        $preventive = RepairPreventive::all();

        return  view('admin.maintenance.preventive', compact(
            'item',
            'preventive',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $preventive = RepairPreventive::find($id);
        $preventive->name = request()->get('name');
        $preventive->save();

        return redirect()->back()->with('success', 'Preventive Maintenance has been updated!!');
    }
    
    public function destroy($id)
    {
        $preventive = RepairPreventive::find($id);

        if ($preventive) {
            RepairPreventive::destroy($id);
        }

        return redirect()->back();
    }
}
