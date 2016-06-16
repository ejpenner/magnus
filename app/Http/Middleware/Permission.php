<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type, $value)
    {
        // based on the variable assigned to the middleware, evaluate if the user has permission to use the resource
        // type is permission or role
        if ($type == 'role') {
            if (!Role::hasPermission($request->user(), $value)) {
                return redirect()->route('401')->withErrors('You do not have permission to access this resource');
            }
        } elseif ($type == 'schema') {
            if (!$request->user()->hasPermission($value)) {
                return redirect()->route('401')->withErrors('You do not have permission to access this resource');
            }
        } else {
            return redirect()->route('401')->withErrors('Permission middleware is not configured correctly in the routes file');
        }

        return $next($request);
    }
}
