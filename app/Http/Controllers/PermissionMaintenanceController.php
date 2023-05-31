<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Services\RoleRightService;

class PermissionMaintenanceController extends Controller
{
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
    public function index(Request $request)
    {
        
        $rolesPermissions = $this->roleRightService->hasPermissions("Permissions Maintenance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $permissions = $request->has('id') ? Permission::find($request->input('id')) : null;
        $modules = Module::orderBy('description', 'asc')->get();
        $permissionList = Permission::orderBy('module_type')
            ->orderBy('description')
            ->get();

        return view('admin.maintenance.account.permission', compact(
            'permissionList',
            'permissions',
            'modules',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    public function updatePermission(Request $request)
    {

        if ($request->has('a_permission')) {
            $request->validate([
                'module_type' => 'required',
                'description' => 'required',
            ]);

            $module_type = $request->input('module_type');
            $description = $request->input('description');
            $active = 1;
            $id = $request->query('id');

            if (Permission::where('module_type', $module_type)
                ->where('description', $description)
                ->exists()
            ) {
                Session::flash('error', " Permission Name! already exists.");
                return redirect()->back();
            } else {
                $permission = Permission::create([
                    'module_type' => $module_type,
                    'description' => $description,
                    'active' => $active
                ]);

                Session::flash('success', "The permission is added.");
                return redirect()->back();
            }
        }

        if ($request->has('e_permission')) {
            $module_type = $request->input('module_type');
            $description = $request->input('description');

            $id = $request->query('id') ?? $request->id;
            $permission = Permission::find($id);

            if (!$permission) {
                Session::flash('error', "Permission Update Failed...");
                return redirect()->back();
            }

            if (Permission::where('module_type', $module_type)
                ->where('description', $description)
                ->where('id', '<>', $id)
                ->exists()
            ) {
                Session::flash('error', " Permission Name! already exists.");
                return redirect()->back();
            } else {

                Permission::find($id)->update([
                    'module_type' => $module_type,
                    'description' => $description
                ]);

                return redirect()->route('maintenance.permission')->with('success', 'The Permission is updated.');
            }
        }

        if ($request->has('activate')) {
            $id = $request->input('id');
            $permission = Permission::find($id);

            if (!$permission) {
                Session::flash('error', "Permission Activation Failed...");
                return redirect()->back();
            }

            $permission->update(['active' => 1]);

            Session::flash('success', "The Permission is activated.");
            return redirect()->back();
        }


        if ($request->has('deactivate')) {
            $id = $request->input('id');
            $permission = Permission::find($id);

            if (!$permission) {
                Session::flash('error', "Permission Deactivation Failed...");
                return redirect()->back();
            }

            $permission->update(['active' => 0]);

            Session::flash('success', "The Permission is deactivated.");
            return redirect()->back();
        }
    }
}
