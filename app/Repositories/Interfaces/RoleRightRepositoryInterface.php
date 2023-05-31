<?php

namespace App\Repositories\Interfaces;

interface RoleRightRepositoryInterface
{
    public function getRoles();
    public function getPermissions();
    public function getModule();
    public function create($fields);
    public function destroy($role_id);
    public function getById($roleId);
    public function hasPermissions($description);

}
