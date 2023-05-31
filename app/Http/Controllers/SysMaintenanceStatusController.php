<?php

namespace App\Http\Controllers;

use App\UnitStatus;
use Illuminate\Http\Request;
use App\Services\RoleRightService;
use Illuminate\Support\Facades\Session;

class SysMaintenanceStatusController extends Controller
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

        $status = UnitStatus::all();
        return view('admin.maintenance.status', compact(
            'status',
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
        UnitStatus::create([
            'status' => $request->get('name'),
            'active' => 1
        ]);

        Session::flash('success', " Status Created Successfully...");
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

        $item = UnitStatus::find($id);
        $status = UnitStatus::all();
        return  view('admin.maintenance.status', compact(
            'item',
            'status',
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
        $status = UnitStatus::find($id);
        $status->status = request()->get('name');
        $status->save();

        return redirect()->back()->with('success', 'Status has been updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = UnitStatus::find($id);

        if ($status) {
            UnitStatus::destroy($id);
        }

        return redirect()->back();
    }
}
