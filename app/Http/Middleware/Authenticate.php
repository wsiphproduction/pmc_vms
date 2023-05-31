<?php

namespace App\Http\Middleware;
// use Illuminate\Auth\Middleware\Authenticate as Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $isLogggedIn = Auth::user()->isLoggedIn;
            if($isLogggedIn == null){
                $isLogggedIn = 1;
            }
            if($isLogggedIn == 0)
            {
                Auth::logout();
                abort(403);
            }
            return $next($request);
        } 
        abort(403);
    }
}
