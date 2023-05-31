<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RoleRightService;
use App\Services\RoleService;
use App\Services\PermissionService;
use App\Role;

class RoleRightController extends Controller
{
    private $roleRightService;
    private $roleService;
    private $permissionService;

    public function __construct(
        RoleRightService $roleRightService,
        RoleService $roleService,
        PermissionService $permissionService
    ) {
        $this->roleRightService = $roleRightService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }
    public function index()
    {        
        $rolesPermissions = $this->roleRightService->hasPermissions("Role Rights");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];


        $roles = auth()->user()->role;
        $roles =  $this->roleService->all()->where('active', '1')->where('name', '<>', 'ADMIN')->sortBy('name');
        $permissions = $this->permissionService->all()->where('active', '1')->sortBy('description');
        $modules = $this->permissionService->getModule()->sortBy('description');
                
        return view('admin.roleaccessrights',compact('roles', 'permissions', 'modules','create'));
    
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $roles_permissions = $this->roleRightService->getById($request->roleid);
            return $roles_permissions;
        }

        return $this->roleRightService->create($request);
    }
}
