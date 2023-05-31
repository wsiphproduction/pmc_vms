<?php

namespace App\Repositories\Interfaces;

interface ApplicationRepositoryInterface
{
    public function all();

    public function create($fields);

    public function update($fields, $id);

    public function destroy($id);
    
    public function getById($id);
    public function hasSchedule();
    public function updateSystem($status);
    
}