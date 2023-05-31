<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $users = $this->repository->all();

        $data = collect();
        foreach ($users as $user) {
            $data->push([
                'id' => $user->id,
                'fullname' => $user->fullname,
                'domain' => $user->domain,
                'role' => $user->role,
                'active' => $user->active,
                'role_id' => $user->role_id,
                'email' => $user->email
            ]);
        }

        return $data;
    }

    public function create($fields)
    {
        $roles = $this->repository->GetRoleName($fields->role_id);

        if($roles->role_name == "ADMIN" || $roles->role_name == "admin" )
        {
            
            $open_sequence = 1;
        }
        else
        {
            $open_sequence = 0;
        }
                
        $data = [
            'fullname' => $fields->firstname . ' ' . $fields->lastname,
            'username' => strtoupper($fields->username),
            'password' => \Hash::make("password"),
            'role' => $roles->role_name,
            'remember_token' => Str::random(60),
            'role_id' => $fields->role_id,
            'email' => $fields->email,
            'active' => 1,
            'can_open_sequence' => $open_sequence,
            'firstname' => $fields->firstname,
            'lastname' => $fields->lastname,
        ];

        $user = $this->repository->create($data);

        if ($user) 
        {            
            //return redirect()->back()->with('success', 'User has been added successfully! ' . $open_sequence);

            return redirect()->back()->with('success', 'User has been added successfully!');
        } 
        else 
        {
            return redirect()->back()->with('errorMesssage', 'Adding user failed.');
        }
    }

    public function update($fields)    
    {
        $roles = $this->repository->GetRoleName($fields->role_id);

            $data = [
                'username' => strtoupper($fields->username),
                'role' => $roles->role_name,
                'role_id' => $fields->role_id,
                'email' => $fields->email,
                'firstname' => $fields->firstname,
                'lastname' => $fields->lastname,
           ];
        $user = $this->repository->update($data, $fields->id);

        if ($user) 
        {
             return redirect()->back()->with('success', 'User has been updated successfull!');
        } 
        else 
        {
             return redirect()->back()->with('errors', 'Updating user failed.');
        }
    }

    public function getById($id)
    {
        $user = $this->repository->getById($id);

        $data = [
            'id' => $user->id,
            'role' => $user->role,
            'username' => $user->username,            
            'role_id' => $user->role_id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,            
        ];
        return $data;
    }

    public function lock($fields, $id)
    {
        $data = [
            'locked' => $fields->status,
            'locked_at' => now(),
        ];

        $user = $this->repository->update($data, $id);

        if ($user) {
            return redirect()->back()->with('success', 'User lock has been updated successfully!');
        } else {
            return redirect()->back()->with('success', 'User lock update failed!');
        }
    }

    public function changeStatus($fields, $id)
    {
        $data = [
            'active' => $fields->status,
        ];

        $user = $this->repository->update($data, $id);

        if ($user) {
            return redirect()->back()->with('success', 'User status has been updated successfully!');
        } else {
            return redirect()->back()->with('success', 'User status update failed!');
        }
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

    public function getUserActions($fields)
    {
        $actions = $this->repository->getUserActions($fields);

        $data = collect();
        foreach ($actions as $action) {
            $old = json_decode($action->old_value) ?? $action->old_value;
            $new = json_decode($action->new_value) ?? $action->new_value;

            $data->push([
                'user' => strtoupper($action->user),
                'driver_id' => $action->driver_id,
                'old_value' => gettype($old) === 'array' ? implode(', ', $old) : $old,
                'new_value' => gettype($new) === 'array' ? implode(', ', $new) : $new,
                'field' => $action->field,
                'created_at' => date('m-d-Y h:i A', strtotime($action->created_at)),
                'action' => $action->action,
            ]);
        }

        return $data;
    }
}
