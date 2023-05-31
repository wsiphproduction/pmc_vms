<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserRightService;
use App\Services\UserService;
use App\Services\PermissionService;
use App\Services\RoleRightService;
use App\Services\RoleService;

class UserRightController extends Controller
{
    private $userrightService;
    private $userService;
    private $permissionService;

    public function __construct(
        UserRightService $userrightService,
        UserService $userService,
        PermissionService $permissionService,
        RoleService $roleService,
        RoleRightService $roleRightService
    ) {
        $this->userrightService = $userrightService;
        $this->userService = $userService;
        $this->permissionService = $permissionService;
        $this->roleService = $roleService;
        $this->roleRightService = $roleRightService;
    }
    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("User Rights");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
                
        $roles = auth()->user()->role;
        $roles =  $this->roleService->all()->where('active', '1')->where('name', '<>', 'ADMIN')->sortBy('name');

        $users =  $this->userService->all()
        ->where('active', '1')
        ->where('domain', '<>', '')
        ->where('role', '<>', 'ADMIN')
        ->where('role', '<>', 'admin')
        ->where('role', '<>', 'Admin')        
        ->sortBy('domain');
        $permissions = $this->permissionService->all()->where('active', '1')->sortBy('description');
        $modules = $this->permissionService->getModule()->sortBy('description');
               

        return view('admin.useraccessrights',compact('users', 'permissions', 'modules','create'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $users_permissions = $this->userrightService->getById($request->userid);
            return $users_permissions;
        }

        return $this->userrightService->create($request);
    }
}
