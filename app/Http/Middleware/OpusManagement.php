<?php

namespace Magnus\Http\Middleware;

use Closure;
use Magnus\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;
use Magnus\Opus;

class OpusManagement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route('opus');
        $opus = Opus::where('id', $id)->first();

        if (Auth::check() and Helpers::isOwnerOrHasRole($opus, config('roles.mod-code'))) {
            return $next($request);
        } else {
            return redirect()->back()->withErrors('You are not permitted to complete that action or view that page.');
        }
    }
}
