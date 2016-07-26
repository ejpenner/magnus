<?php

namespace Magnus\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Account
{
    /**
     * Handle an Account settings route if the User in the route is
     * the Auth'd user, or if the Auth'd user is an Admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() and Auth::user()->atLeastHasRole(Config::get('roles.admin-code')) or $request->route('users')->id == Auth::user()->id) {
            return $next($request);
        } else {
            return redirect()->back()->withErrors('You are not permitted to complete that action or view that page.');
        }
    }
}
