<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleRightRepositoryInterface;
use App\Role;
use App\Permission;
use App\RolesPermissions;
use App\Services\RoleRightService;
use Illuminate\Support\Facades\DB;
use App\User;
use App\UsersPermissions;

class RoleRightRepository implements RoleRightRepositoryInterface
{
    protected $user;
    protected $action;

    public function __construct(
        RolesPermissions $rolesPermissions
    ) {
        $this->rolespermissions = $rolesPermissions;
    }

    public function getById($roleid)
    {
        return RolesPermissions::where('role_id', $roleid)->get();
    }

    public function getRoles()
    {
        return Role::where('active', '1')->get();
    }
    public function getPermissions()
    {
        return $permissions = Permission::where('active', '1')->get();
    }
    public function getModule()
    {
        $modules = DB::table('modules')->get();

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

        return $this->rolespermissions->create($fields);
    }

    public function destroy($id)
    {
        return $this->rolespermissions->find($id)->delete();
    }
    public function hasPermissions($description)
    {
        $userId = auth()->user()->id;
        $userPermissions = UsersPermissions::where('user_id', $userId)->get();

        $permission = Permission::where([['active', '1'], ['description', $description]])->first()['id'];
        if (count($userPermissions) > 0) {
            return UsersPermissions::where('user_id', $userId)->where('permission_id', $permission)->get();
        } else {

            $role = auth()->user()['role_id'];
            return $this->rolespermissions->where([['role_id', $role], ['permission_id', $permission]])->get();
        }
    }
}
