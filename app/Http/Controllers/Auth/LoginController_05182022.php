<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Services\AuditService;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }
    public function __construct(
        AuditService $auditService)
    {
        $this->auditService = $auditService;
    }
    public function index()
    {
        return auth()->check() ? redirect()->route('form.home') : view('auth.login');
    }
    public function login(Request $request)
    {
        $checker = auth()->attempt([
            'domain' => $request->username,
            'password' => $request->password,
            'active' => 1,
            'isLocked' => 0,
        ]);

        if ($checker) {
            
            \Session::put('esdvms_username', auth()->user()->domain);
            \Session::put('esdvms_name', auth()->user()->fullname);
            \Session::put('esdvms_dept', auth()->user()->dept);
            \Session::put('esdvms_role', auth()->user()->role);

            $saveLogs = $this->auditService->create($request,"Login User : ". auth()->user()->username,"Login");            

            return redirect()->route('form.home');
        } else {
            return redirect()->back()->withErrors('Invalid login credentials.');
        }
    }
    
    public function logout(Request $request)
    {
        $saveLogs = $this->auditService->create($request,"Logout User : ". auth()->user()->username,"Logout");
        return auth()->logout() ?? redirect()->route('login');
    }
    public function adminLogin()
    {
        return view('admin.login.adminLogin');
    }
    public function adminSubmit(Request $request)
    {
        $checker = auth()->attempt([
            'domain' => $request->username,
            'password' => $request->password,
            'active' => 1,
        ]);
        if ($checker) {
            // dd(auth()->user()->role);
            if(auth()->user()->role == "ADMIN" || auth()->user()->role == "admin" ){
                $saveLogs = $this->auditService->create($request,"Login User : ". auth()->user()->username,"Admin Login");      
                return redirect()->route('maintenance.application.index');
            }
            else
            {
                abort(503);
            }
        } else {
            return redirect()->back()->withErrors('Invalid login credentials.');
        }
    }
}
