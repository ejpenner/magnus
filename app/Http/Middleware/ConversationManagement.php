<?php

namespace Magnus\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ConversationManagement
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
        $conversation = $request->route('conversation');

        if((Auth::check() and $conversation->isUserMember($request->user)) or (Auth::user()->atLeastHasRole(config('admin-code'))))
        {
            return $next($request);
        } else {
            return redirect()->back()->withErrors('You are not permitted to complete that action or view that page.');
        }
    }
}
