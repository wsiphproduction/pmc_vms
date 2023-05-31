<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Services\RoleRightService;

class RoleMaintenanceController extends Controller
{
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
    public function index(Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Roles Maintenance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $roles = $request->has('id') ? Role::find($request->input('id')) : null;
        $roleList = Role::orderBy('name')->get();

        return view('admin.maintenance.account.role', compact(
            'roleList',
            'roles',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    public function updateRole(Request $request)
    {

        if ($request->has('a_role')) {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);

            $name = $request->input('name');
            $description = $request->input('description');
            $active = 1;
            $id = $request->query('id');

            if (Role::where('name', strtoupper($name))
                ->exists()
            ) {
                Session::flash('error', " Role Name! already exists.");
                return redirect()->back();
            } else {
                $role = Role::create([
                    'name' => strtoupper($name),
                    'description' => $description,
                    'active' => $active
                ]);

                Session::flash('success', "The role is added.");
                return redirect()->back();
            }
        }

        if ($request->has('e_role')) {
            $name = $request->input('name');
            $description = $request->input('description');

            $id = $request->query('id') ?? $request->id;
            $role = Role::find($id);

            if (!$role) {
                Session::flash('error', "Role Update Failed...");
                return redirect()->back();
            }

            if (Role::where('name', strtoupper($name))
                ->where('id', '<>', $id)
                ->exists()
            ) {
                Session::flash('error', " Role Name! already exists.");
                return redirect()->back();
            } else {

                Role::find($id)->update([
                    'name' => strtoupper($name),
                    'description' => $description
                ]);

                return redirect()->route('maintenance.role')->with('success', 'The Role is updated.');
            }
        }

        if ($request->has('activate')) {
            $id = $request->input('id');
            $role = Role::find($id);

            if (!$role) {
                Session::flash('error', "Role Activation Failed...");
                return redirect()->back();
            }

            $role->update(['active' => 1]);

            Session::flash('success', "The Role is activated.");
            return redirect()->back();
        }


        if ($request->has('deactivate')) {
            $id = $request->input('id');
            $role = Role::find($id);

            if (!$role) {
                Session::flash('error', "Role Deactivation Failed...");
                return redirect()->back();
            }

            $role->update(['active' => 0]);

            Session::flash('success', "The Role is deactivated.");
            return redirect()->back();
        }
    }
}
