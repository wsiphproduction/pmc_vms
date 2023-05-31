<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\User;

class RoleService
{
    protected $repository;

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $roles = $this->repository->all();

        $data = collect();
        foreach ($roles as $role) {
            $data->push([
                'id' => $role->id,
                'name' => $role->name,
                'description' => $role->description,
                'active' => $role->active,
            ]);
        }

        return $data;
    }

    public function getById($id)
    {
        $role = $this->repository->getById($id);
        $data = [
            'id' => $role->id,
            'name' => $role->name,
            'description' => $role->description,
            'active' => $role->active,
        ];

        return $data;
    }
}