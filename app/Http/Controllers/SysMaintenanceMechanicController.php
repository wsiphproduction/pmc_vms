<?php

namespace App\Http\Controllers;

use App\Mechanic;
use Illuminate\Http\Request;
use App\Services\RoleRightService;
use Illuminate\Support\Facades\Session;

class SysMaintenanceMechanicController extends Controller
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

        $mechanics = Mechanic::all();
        return view('admin.maintenance.mechanic', compact(
            'mechanics',
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
        Mechanic::create([
            'name' => $request->get('name'),
            'active' => 1
        ]);

        Session::flash('success', " Mechanic Created Successfully...");
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
        $item = Mechanic::find($id);
        $mechanics = Mechanic::all();
        return  view('admin.maintenance.mechanic', compact(
            'item',
            'mechanics',
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
        $mechanic = Mechanic::find($id);
        $mechanic->name = request()->get('name');
        $mechanic->save();

        return redirect()->back()->with('success', 'Mechanic has been updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mechanic = Mechanic::find($id);

        if ($mechanic) {
            Mechanic::destroy($id);
        }

        return redirect()->back();
    }
}
