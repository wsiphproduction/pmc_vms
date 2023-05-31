<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface
{
    public function all();
    
    public function getById($id);
}