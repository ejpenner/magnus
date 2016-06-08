<?php

namespace App\Http\Middleware;

use Closure;

use App\Piece;
use Illuminate\Support\Facades\Auth;

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
        $user_id = Piece::where('id', $piece_id)->value('user_id');

        if (Auth::user()->is_admin or $user_id == Auth::user()->id) {
            return $next($request);
        } else {
            return redirect()->back()->withErrors('You are not permitted to complete that action or view that page.');
        }
    }
}
