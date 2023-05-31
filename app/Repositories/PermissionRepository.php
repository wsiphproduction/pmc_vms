<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function all()
    {
        return $this->permission->all();
    }

    public function getById($id)
    {
        return $this->permission->find($id);
    }

    public function getModule(){

        return $this->permission->getModule();
    }

   
}