<?php

namespace App\Services;

use App\Permission;
use App\Role;
use App\RolesPermissions;
use App\Repositories\Interfaces\RoleRightRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RoleRightService
{
    protected $repository;
    protected $userService;

    public function __construct(
        RoleRightRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }
    public function getRoles()
    {
        $roles = $this->repository->getRoles();
        $data = collect();
        foreach ($roles as $role) {
            $data->push([
                'id' => $role->id,
                'name' => $role->name,
            ]);
        }

        return $data;
    }
    public function getPermissions()
    {
        $permissions = $this->repository->getPermissions();
        $data = collect();
        foreach ($permissions as $permission) {
            $data->push([
                'id' => $permission->id,
                'description' => $permission->description,
                'module_type' => $permission->module_type,
            ]);
        }

        return $data;
    }
    public function getModule()
    {

        $modules = $this->repository->getModule();
        $data = collect();
        foreach ($modules as $module) {
            $data->push([
                'id' => $module->id,
                'description' => $module->description,
            ]);
        }

        return $data;
    }
    public function create($fields)
    {
        $rolerights = false;

        RolesPermissions::where('role_id', '=', $fields->roleid)->delete();
        $listOfPermissions = explode(',', $fields->roles_permissions);

        foreach ($listOfPermissions as $permission) {

            $permissionarray = explode("_", $permission);
            if (count($permissionarray) == 3) {
                $data = [
                    'role_id' => $fields->roleid,
                    'permission_id' => $permissionarray[0],
                    'module_id' => $permissionarray[1],
                    'action' => $permissionarray[2],
                ];
                $rolerights = $this->repository->create($data);
            }
        }
        return redirect()->back()->with('success', 'Role Access Right has been saved successfully!');
    }

    public function destroy($id)
    {
        $user = $this->repository->destroy($id);

        if ($user) {
            return redirect()->back()->with('success', 'User has been removed successfully!');
        } else {
            return redirect()->back()->with('success', 'Failed removing user!');
        }
    }
    public function getById($roleId)
    {
        $rolepermissions =  $this->repository->getById($roleId);

        $data = collect();
        foreach ($rolepermissions as $rolepermission) {
            $data->push([
                'role_id' => $rolepermission->role_id,
                'permission_id' => $rolepermission->permission_id,
                'module_id' => $rolepermission->module_id,
                'action' => $rolepermission->action,
            ]);
        }
        return $data;
    }
    public function hasPermissions($description)
    {
        $roles_permissions = $this->repository->hasPermissions($description);
        $data = collect();
        $access = false;
        $role = auth()->user()->role;
        if ($role == "ADMIN" || $role == "admin")   {
            $access = true;
        }
        $create = $access;
        $edit = $access;
        $delete = $access;
        $view = $access;
        $print = $access;
        $search = $access;
        $upload = $access;
        $pagination = $access;
        foreach ($roles_permissions as $roles_permission) {
            if ($roles_permission['action'] == "create") {
                $create = true;
            } elseif ($roles_permission['action'] == "edit") {
                $edit = true;
            } elseif ($roles_permission['action'] == "delete") {
                $delete = true;
            } elseif ($roles_permission['action'] == "view") {
                $view = true;
            } elseif ($roles_permission['action'] == "print") {
                $print = true;
            } elseif ($roles_permission['action'] == "search") {
                $search = true;
            } elseif ($roles_permission['action'] == "upload") {
                $upload = true;
            } elseif ($roles_permission['action'] == "pagination") {
                $pagination = true;
            }
        }

        $data->push([
            'create' => $create,
            'edit' => $edit,
            'delete' => $delete,
            'view' => $view,
            'print' => $print,
            'search' => $search,
            'upload' => $upload,
            'pagination' => $pagination,
        ]);

        return $data->first();
    }
}
