<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserMaintenanceController extends Controller
{
    public function index(Request $request) {

        $userList = User::all()->where('isdepartment', 0);
        $name = $request->has('name') ? $request->input('name') : null;

        //if first variable has value already, skip. to avoid overwriting
        if(! $name) {
            $user = $request->has('id') ? User::find($request->input('id')) : null;
            $name = $user['fullname'];
        }

        $dept = $request->has('dept') ? $request->input('dept') : null;

        //if first variable has value already, skip. to avoid overwriting
        if(! $dept) {
            $dept = $request->has('id') ? User::find($request->input('id')) : null;
            $dept = $dept['dept'];
        }

        $domain = $request->has('domain') ? $request->input('domain') : null;

        //if first variable has value already, skip. to avoid overwriting
        if(! $domain) {
            $domain = $request->has('id') ? User::find($request->input('id')) : null;
            $domain = $domain['domain'];
        }

        $role = $request->has('role') ? $request->input('role') : null;
        if(! $role) {
            $role = $request->has('id') ? User::find($request->input('id')) : null;
            $role = $role['role'];
        }

        return view('admin.maintenance.account.user', compact('userList','name','dept','domain','role'));
    }

    public function updateUser(Request $request) {                  
        
        if($request->has('unlock_user'))
        {
            
            $id = $request->input('id');
            $user = User::find($id);

            if(! $user)
            {
                Session::flash('error',"User Unlock Failed...");
                return redirect()->back();
            }

            $user->update(['isLocked' => 0]);

            Session::flash('success',"User has been Unlocked...");
            return redirect()->back();
        }
        
        if($request->has('lock_user'))
        {

            $id = $request->input('id');
            $user = User::find($id);

            if(! $user)
            {
                Session::flash('error',"User Lock Failed... ");
                return redirect()->back();
            }

            $user->update(['isLocked' => 1]);

            Session::flash('success',"User has been Locked... ");
            return redirect()->back();
        }

        if($request->has('deactivate'))
        {
            
            $id = $request->input('id');
            $user = User::find($id);

            if(! $user)
            {
                Session::flash('error',"User Deactivated Failed...");
                return redirect()->back();
            }

            $user->update(['active' => 0]);

            Session::flash('success',"User Deactivation Successfully...");
            return redirect()->back();
        }

        if($request->has('activate'))
        {
            
            $id = $request->input('id');
            $user = User::find($id);

            if(! $user)
            {
                Session::flash('error',"User Activated Failed...");
                return redirect()->back();
            }

            $user->update(['active' => 1]);

            Session::flash('success',"User Activation Successfully...");
            return redirect()->back();
        }

        if($request->has('e_user'))
        {

            $role = $request->input('u_role');
            $domain = $request->input('domain');
            $dept = $request->input('dept');
            $name = $request->input('firstName');
            $id = $request->query('id') ?? $request->id;

            $userAcc = User::find($id)->update([
                'domain' => $domain,
                'fullname' => $name,
                'role' => $role,
                'dept' => $dept,
            ]);

            Session::flash('success',"User Updated Successfully...");
            return redirect()->back();
        }

        if($request->has('a_user'))
        {

            $role = $request->input('u_role');
            $domain = $request->input('domain');
            $dept = $request->input('dept');
            $name = $request->input('firstName');
            $id = $request->query('id');
            // $password = '$2y$10$hUEQK2lrFRymaV34QJ/veOpIM5p8voBPGop/k89IF5wAPV.J6NzWy'; //123456
            $password='$2y$10$hHgFWBhvdvstgxBL9C9ivOHdmk7Lya9ghroNy1UtFreEmuDy5G0xu'; //password

            
            $userAcc = User::where('domain', $domain)->get();

            if( $userAcc->count() >= 1)
            {
                Session::flash('error',"Domain Already Exist...");
                return redirect()->back();
            }

            if(! $userAcc->count() >= 1)
            {
                $user = User::create([
                    'fullname' => $name,
                    'role' => $role,
                    'domain' => $domain,
                    'dept' => $dept,
                    'isLocked' => 0,
                    'active' => 1,
                    'dpassword' => $password
                ]);

                if(! $user)
                {
                    Session::flash('error',"Failed To Create User...");
                    return redirect()->back();
                }
            }
          
            Session::flash('success',"User Created Successfully...");
            return redirect()->back();
        }
    }
}