<?php

namespace App\Http\Middleware;

use Closure;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user()->hasRole($role)) {
            return redirect()->back()->withErrors('You do not have permission to access this resource');
        }
        // based on the variable assigned to the middleware, evaluate if the user has permission to use the resource
        return $next($request);
    }
}
