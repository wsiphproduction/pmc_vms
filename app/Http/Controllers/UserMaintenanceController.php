<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\Notifications\EmailNotification;
use App\Services\UserService;
use App\Services\RoleRightService;

class UserMaintenanceController extends Controller
{
    public function __construct(
        UserService $userService,
        RoleRightService $roleRightService
    ) {
        $this->userService = $userService;
        $this->roleRightService = $roleRightService;
    }
    public function index(Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Users Maintenance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $userList = User::all()->where('isdepartment', 0);
        $name = $request->has('name') ? $request->input('name') : null;

        //if first variable has value already, skip. to avoid overwriting
        if (!$name) {
            $user = $request->has('id') ?

                User::find($request->input('id')) : null;
            if (!$user) {
                $name = null;
            } else {
                $name = $user['fullname'];
            }
        }

        $dept = $request->has('dept') ? $request->input('dept') : null;

        //if first variable has value already, skip. to avoid overwriting
        if (!$dept) {
            $dept = $request->has('id') ? User::find($request->input('id')) : null;
            if (!$dept) {
                $dept = null;
            } else {
                $dept = $user['dept'];
            }
        }

        $domain = $request->has('domain') ? $request->input('domain') : null;

        //if first variable has value already, skip. to avoid overwriting
        if (!$domain) {
            $domain = $request->has('id') ? User::find($request->input('id')) : null;

            if (!$domain) {
                $domain = null;
            } else {
                $domain = $user['domain'];
            }
        }

        $roleid = $request->has('role_id') ? $request->input('role_id') : null;
        if (!$roleid) {
            $roleid = $request->has('id') ? User::find($request->input('id')) : null;

            if (!$roleid) {
                $roleid = null;
            } else {
                $roleid = $user['role_id'];
            }
        }

        $email = $request->has('email') ? $request->input('email') : null;
        if (!$email) {
            $email = $request->has('id') ? User::find($request->input('id')) : null;

            if (!$email) {
                $email = null;
            } else {
                $email = $user['email'];
            }
        }

        $roles = Role::where('active', '1')->get();
        return view('admin.maintenance.account.user', compact(
            'userList',
            'name',
            'dept',
            'domain',
            'roleid',
            'email',
            'roles',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    public function updateUser(Request $request)
    {

        if ($request->has('unlock_user')) {

            $id = $request->input('id');
            $user = User::find($id);

            if (!$user) {
                Session::flash('error', "User Unlock Failed.");
                return redirect()->back();
            }

            $user->update(['isLocked' => 0]);

            Session::flash('success', "The User is unlocked.");
            return redirect()->back();
        }

        if ($request->has('lock_user')) {

            $id = $request->input('id');
            $user = User::find($id);

            if (!$user) {
                Session::flash('error', "User Lock Failed.");
                return redirect()->back();
            }

            $user->update(['isLocked' => 1]);

            Session::flash('success', "The User is locked.");
            return redirect()->back();
        }

        if ($request->has('deactivate')) {

            $id = $request->input('id');
            $user = User::find($id);

            if (!$user) {
                Session::flash('error', "User Deactivated Failed.");
                return redirect()->back();
            }

            $user->update(['active' => 0]);

            Session::flash('success', "A User is deactivated");
            return redirect()->back();
        }

        if ($request->has('activate')) {

            $id = $request->input('id');
            $user = User::find($id);

            if (!$user) {
                Session::flash('error', "User Activated Failed...");
                return redirect()->back();
            }

            $user->update(['active' => 1]);

            Session::flash('success', "A User is activated");
            return redirect()->back();
        }


        $roleArr = Role::find($request->input('role_id'));
        $role = $roleArr['name'];
        $role_id = $request->input('role_id');
        if ($request->has('e_user')) {

            $request->validate([

                'domain' => 'required',
                'email' => 'required',
                'fullname' => 'required',

            ]);
            $domain = $request->input('domain');
            $dept = $request->input('dept');
            $name = $request->input('fullname');
            $email = $request->input('email');
            $id = $request->query('id') ?? $request->id;


            $userAcc = User::find($id)->update([
                'domain' => $domain,
                'fullname' => $name,
                'role' => $role,
                'dept' => $dept,
                'email' => $email,
                'role_id' => $role_id,
            ]);

            Session::flash('success', "A User is updated.");
            return redirect()->back();
        }

        if ($request->has('a_user')) {

            $request->validate([

                'domain' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'fullname' => 'required',

            ]);
            $domain = $request->input('domain');
            $dept = $request->input('dept');
            $name = $request->input('fullname');
            $email = $request->input('email');
            $id = $request->query('id');
            // $password = '$2y$10$hUEQK2lrFRymaV34QJ/veOpIM5p8voBPGop/k89IF5wAPV.J6NzWy'; //123456
            // $password = '$2y$10$hHgFWBhvdvstgxBL9C9ivOHdmk7Lya9ghroNy1UtFreEmuDy5G0xu'; //password
            $password = \Hash::make("password");


            $userAcc = User::where('domain', $domain)->get();

            if ($userAcc->count() >= 1) {
                Session::flash('error', "Domain Already Exist...");
                return redirect()->back();
            }

            if (!$userAcc->count() >= 1) {
                $user = User::create([
                    'fullname' => $name,
                    'role' => $role,
                    'domain' => $domain,
                    'dept' => $dept,
                    'isLocked' => 0,
                    'active' => 1,
                    'role_id' => $role_id,
                    'email' => $email,
                    'dpassword' => $password,
                    'password' => $password,
                ]);

                if (!$user) {
                    Session::flash('error', "Failed To Create User...");
                    return redirect()->back();
                }
            }

            Session::flash('success', "A user is added.");
            if ($request->session()->get('success') == "A user is added.") {
                $user->notify(new EmailNotification($user));
            }
            return redirect()->back();
        }
    }
}
