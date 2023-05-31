<?php

namespace App\Services;

use App\Permission;
use App\User;
use App\UsersPermissions;
use App\Repositories\Interfaces\UserRightRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRightService
{
    protected $repository;
    protected $userService;

    public function __construct(
        UserRightRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }
    public function getUsers()
    {
        $users = $this->repository->getUsers();
        $data = collect();
        foreach ($users as $user) {
            $data->push([
                'id' => $user->id,
                'name' => $user->name,
            ]);
        }

        return $data;
    }
    public function getPermissions()
    {
        $permissions = Permission::where('active', '1')->orderBy('description', 'asc')->get();
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

        $modules = DB::table('modules')->orderBy('description', 'asc')->get();
        // dd($module);
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
        $userrights = false;
        UsersPermissions::where('user_id', '=', $fields->userid)->delete();
        $listOfPermissions = explode(',', $fields->users_permissions);
        foreach ($listOfPermissions as $permission) {

            $permissionarray = explode("_", $permission);
            if (count($permissionarray) == 3) {
                $data = [
                    'user_id' => $fields->userid,
                    'permission_id' => $permissionarray[0],
                    'module_id' => $permissionarray[1],
                    'action' => $permissionarray[2],
                ];
                $userrights = $this->repository->create($data);
            }
        }

        return redirect()->back()->with('success', 'User Access Right has been saved successfully!');
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
    public function getById($userid)
    {
        $userpermissions = $this->repository->getById($userid);

        $data = collect();
        foreach ($userpermissions as $userpermission) {
            $data->push([
                'user_id' => $userpermission->user_id,
                'permission_id' => $userpermission->permission_id,
                'module_id' => $userpermission->module_id,
                'action' => $userpermission->action,
            ]);
        }
        return $data;
    }
}
