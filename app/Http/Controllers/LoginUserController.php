<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\CssSelector\Node\FunctionNode;
use App\Services\RoleRightService;

class LoginUserController extends Controller
{

    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }

    public function changePassword()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Change Password");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $id = \Auth::user()->id;

        return view('auth.passwords.change', compact(
            'id',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }
    public function updatePassword(Request $request)
    {

        $user = \Auth::user();
        $hasher = app('hash');

        $validate = $request->validate([
            'current_password'      => 'required',
            'new_password'          => [
                'required', 'string', 'min:8', 'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&._]/'
            ],
            'new_confirm_password'  => 'same:new_password'
        ]);

        if ($hasher->check($request->current_password, $user->dpassword)) {

            $user->update([
                'dpassword'    => Hash::make($request->new_password),
                'password' => Hash::make($request->new_password),
            ]);

            \Auth::logout();
            return redirect('/');
        }

        \Session::flash('error_message', 'Something is wrong while trying to change the password');

        return back();
    }
}
