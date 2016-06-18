<?php

namespace App\Http\Middleware;

use Closure;

use App\Piece;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PieceManagement
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
        $piece_id = $request->route('piece');
        $piece = Piece::where('id', $piece_id)->first();

        if (Auth::user()->atLeastHasRole(Config::get('roles.globalMod')) or Auth::user()->isOwner($piece)) {
            return $next($request);
        } else {
            return redirect()->back()->withErrors('You are not permitted to complete that action or view that page.');
        }
    }
}
