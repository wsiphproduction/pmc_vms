<?php

namespace App\Services;

use App\Permission;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionService
{
    protected $repository;

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $permissions = $this->repository->all();

        $data = collect();
        foreach ($permissions as $permission) {
            $data->push([
                'id' => $permission->id,
                'module_type' => $permission->module_type,
                'description' => $permission->description,
                'active' => $permission->active,
            ]);
        }

        return $data;
    }

    public function getById($id)
    {
        $permission = $this->repository->getById($id);

        $data = [
            'id' => $permission->id,
            'module_type' => $permission->module_type,
            'description' => $permission->description,
            'active' => $permission->active,
        ];

        return $data;
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

}