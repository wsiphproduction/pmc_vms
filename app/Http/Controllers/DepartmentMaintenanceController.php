<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Services\RoleRightService;
use App\Role;

class DepartmentMaintenanceController extends Controller
{
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
    public function index(Request $request)
    {

        $rolesPermissions = $this->roleRightService->hasPermissions("Department Maintenance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $user = $request->has('id') ? User::find($request->input('id')) : null;
        if (!$user) {
            $dept = null;
        } else {
            $dept = $user['dept'];
        }
        if (!$user) {
            $roleid = null;
        } else {
            $roleid = $user['role_id'];
        }
        if (!$user) {
            $dpassword = null;
        } else {
            $dpassword = $user['dpassword'];
        }
        if (!$user) {
            $dpassword = null;
        } else {
            $dpassword = $user['dpassword'];
        }
        // $dept = $request->has('dept') ? $request->input('id') : null;


        $userList = User::all()->where('isdepartment', 1);


        $roles = Role::where('active', '1')->get();
        return view('admin.maintenance.account.department', compact(
            'dept',
            'roleid',
            'roles',
            'dpassword',
            'userList',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    public function updateDept(Request $request)
    {

        // dd($request);
        if ($request->has('lock_user')) {

            $id = $request->input('id');
            $user = User::find($id);

            if (!$user) {
                Session::flash('error', "User Lock Failed...");
                return redirect()->back();
            }

            $user->update(['isLocked' => 1]);

            Session::flash('success', "User has been Locked...");
            return redirect()->back();
        }

        if ($request->has('unlock_user')) {
            $id = $request->input('id');
            $user = User::find($id);

            if (!$user) {
                Session::flash('error', "User Unlock Failed...");
                return redirect()->back();
            }

            $user->update(['isLocked' => 0]);

            Session::flash('success', "User has been Unlocked...");
            return redirect()->back();
        }

        if ($request->has('activate')) {
            $id = $request->input('id');
            $user = User::find($id);

            if (!$user) {
                Session::flash('errorMsg', "User Activation Failed...");
                return redirect()->back();
            }

            $user->update(['active' => 1]);

            Session::flash('success', "User has been Activated...");
            return redirect()->back();
        }


        if ($request->has('deactivate')) {
            $id = $request->input('id');
            $user = User::find($id);

            if (!$user) {
                Session::flash('errorMsg', "User Deactivation Failed...");
                return redirect()->back();
            }

            $user->update(['active' => 0]);

            Session::flash('success', "User has been Deactivated...");
            return redirect()->back();
        }

        $roleArr = Role::find($request->input('role_id'));
        $role = $roleArr['name'];
        $role_id = $request->input('role_id');
        if ($request->has('e_user')) {
            $dept = $request->input('dept');
            $domain = $request->input('dept');
            $fullname = $request->input('dept');
            $dpassword = $request->input('dpassword');

            $id = $request->query('id') ?? $request->id;
            $user = User::find($id);

            if (!$user) {
                Session::flash('error', "User Update Failed...");
                return redirect()->back();
            }

            $user->update([
                'role' => $role,
                'dept' => $dept,
                'domain' => $dept,
                'fullname' => $fullname,
                'dpassword' => $dpassword,
                'role_id' => $role_id,
            ]);

            Session::flash('success', 'User Updated Successfully...');
            return redirect()->back();
        }

        if ($request->has('a_user')) {
            $dept = $request->input('dept');
            $domain = $request->input('dept');
            $fullname = $request->input('dept');
            $isLocked = 0;
            $active = 1;
            $department = 1;
            // $password   = base64_encode($request->input('dpassword'));
            $password   = Hash::make($request->input('dpassword'));
            $id = $request->query('id');

            $userAcc = User::where('domain', $domain)->get();

            if ($userAcc->count() >= 1) {
                Session::flash('error', "Domain Already Exist...");
                return redirect()->back();
            }

            if (!$userAcc->count() >= 1) {
                $user = User::create([
                    'fullname' => $fullname,
                    'role' => $role,
                    'role_id' => $role_id,
                    'domain' => $domain,
                    'dept' => $dept,
                    'isLocked' => $isLocked,
                    'active' => $active,
                    'isdepartment' => $department,
                    'dpassword' => $password
                ]);

                if (!$user) {
                    Session::flash('error', "Failed To Create User...");
                    return redirect()->back();
                }
            }

            Session::flash('success', "User Created Successfully...");
            return redirect()->back();
        }
    }
}
