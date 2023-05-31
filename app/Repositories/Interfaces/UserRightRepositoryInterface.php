<?php

namespace App\Repositories\Interfaces;

interface UserRightRepositoryInterface
{
    public function getUsers();
    public function getPermissions();
    public function getModule();
    public function create($fields);
    public function destroy($user_id);
    public function getById($id);
        
}
