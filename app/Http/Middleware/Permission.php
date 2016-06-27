<?php

namespace Magnus\Http\Middleware;

use Closure;
use Magnus\Role;

class Permission
{
    /**
     * Handle an incoming request based on the type of permission
     * and permission level specified. 
     * @param $request
     * @param Closure $next
     * @param $type
     * @param $value
     * @return $this
     */
    public function handle($request, Closure $next, $type, $value)
    {
        // based on the variable assigned to the middleware, evaluate if the user has permission to use the resource
        // type is permission or role
        if ($type == 'atLeast') {
            if (!Role::atLeastHasRole($request->user(), $value)) {
                return redirect()->route('401')->withErrors('You do not have permission to access this resource');
            }
        } elseif ($type == 'hasRole') {
            if (!Role::hasRole($request->user(), $value)) {
                return redirect()->route('401')->withErrors('You do not have permission to access this resource');
            }
        } else {
            return redirect()->route('401')->withErrors('Permission middleware is not configured correctly in the routes file');
        }

        return $next($request);
    }
}
