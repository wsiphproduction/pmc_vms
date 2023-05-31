<?php

namespace App\Http\Controllers;

use App\User;
use App\Department;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function index()
    {
        return view('admin.login.index');
    }

    public function login(Request $request)
    {
        $verify = null;
        $username = $request->get('username');
        $password = $request->get('password');
        
        $departments = Department::all();
        // Check if domain account is correct.
        $user = User::whereIn('role', ['admin','approver'])
        ->where([
            'active' => 1,
            'domain' => $username,
        ])->first();

        if($user) 
        {
            // Check if password is correct.
            $verify = Hash::check($request->get('password'), $user->dpassword);            
        }
            
        if($verify)
        {
            //Add session when user exists
            $this->AddSession($user);            
            Auth::login($user);

            return view('admin.home.index', [
                'departments' => $departments
            ]);
        }

        if(! $user && !$verify)
        {
            //insert log here
            Session::flash('error','Invalid Account!');
            return redirect()->back();
        }

        return view('admin.login.index', [
            'departments' => $departments
        ]);
    }

    public function AddSession($user)
    {
        if( $user) {
            if( $user->role == 'approver' || $user->role == 'admin' )
            {
                Session::put('esdvms_username', request()->get('username'));
                Session::put('esdvms_name', $user->fullname);
                Session::put('esdvms_dept', $user->dept);
                Session::put('esdvms_role', $user->role);
                
                return true;
            }
        }

        if(! $user) {
            return false;
        }
    }

    public function Logout()
    {
        session()->flush();
        Auth::logout();
        return redirect()->route('login');
    }


    public function genAccDummy()
    {
        $username = "test";
        $password = Hash::make('test');

        User::create([
            'fullname' => $username,
            'domain' => $username,
            'isLocked' => 0,
            'isApprover' => 1,
            'dept' => 1,
            'role' => 'admin',
            'active' => 1,
            'email' => 'testaccount@mail.com',
            'dpassword' => $password,
        ]);

        return view('admin.login.index');
    }


    public function requestorIndex()
    {
        return view('admin.login.requestor.index');
    }

    public function requestorLogin(Request $request)
    {
        //Requestor can also be logged by an admin role
        $verify = null;
        $isLogged = null;
        $username = $request->get('username');
        $password = $request->get('password');

        $user = User::whereIn('role', ['admin','requestor'])
        ->where([
            'active' => 1,
            'domain' => $username,
        ])->first();

        if( $user)
        {
            // Check if password is correct.
            $verify = Hash::check($password, $user->dpassword);
            $isLogged = $this->AddSessionRequestor($user, $username);
        }

        if( $isLogged && $verify)
        {
            Auth::login($user);
            return view('admin.home.index');
        }
        else
        {
            Session::flash('error','Invalid Account');
            return redirect()->back();
        }
    }

    public function AddSessionRequestor($user, $username)
    {
        if( $user) {
            if( $user->role == 'requestor' || $user->role == 'admin')
            {
                Session::put('esdvms_requestor_id', $user->id);
                Session::put('esdvms_requestor_username', $username);
                Session::put('esdvms_requestor_ename', $user->fullname);
                Session::put('esdvms_requestor_edept', $user->dept);
                Session::put('esdvms_requestor_erole', $user->role);
                
                return true;
            }
            else
            {
                return false; //Your role is not admin or requestor
            }
        }

        if(! $user) {
            return false;
        }
    }
}
