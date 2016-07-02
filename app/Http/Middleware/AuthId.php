<?php

namespace Magnus\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Auth\Guard;
use Magnus\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AuthId
{
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if (Auth::user()->atLeastHasRole(Config::get('roles.admin-code')) or $request->route('id') == Auth::user()->id) {
            return $next($request);
        } else {
            return redirect()->back()->withErrors('You are not permitted to complete that action or view that page.');
        }
    }
}
