<?php

namespace App\Http\Controllers;

use App\Assigned;
use Illuminate\Http\Request;
use App\Services\RoleRightService;
use Illuminate\Support\Facades\Session;

class SysMaintenanceAssignedController extends Controller
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

        $assigned = Assigned::all();
        return view('admin.maintenance.assigned', compact(
            'assigned',
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
        Assigned::create([
            'name' => $request->get('name'),
            'active' => 1
        ]);

        Session::flash('success', " Owner Created Successfully...");
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
        $item = Assigned::find($id);
        $assigned = Assigned::all();

        return  view('admin.maintenance.assigned', compact(
            'item',
            'assigned',
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
        $assigned = Assigned::find($id);
        $assigned->name = request()->get('name');
        $assigned->save();

        return redirect()->back()->with('success', 'Owner has been updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assigned = Assigned::find($id);

        if ($assigned) {
            Assigned::destroy($id);
        }

        return redirect()->back();
    }
}
