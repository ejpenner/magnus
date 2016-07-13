<?php

namespace Magnus\Http\Controllers;

use Magnus\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Magnus\Opus;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create','edit','destroy']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function recent(Request $request, $filter = null, $period = null)
    {
        $filterSegment = !is_null($request->segment(1)) ? $request->segment(1) : 'newest';

        if ($request->has('limit')) {
            $limit = $request->input('limit');
        } elseif (Auth::check() and !$request->has('limit')) {
            $limit = Auth::user()->preferences->per_page;
        } else {
            $limit = config('images.defaultLimit');
        }

        switch ($filter) {
            case 'trending':
                $opera = Opus::trending();
                break;
            case 'popular':
                $opera = Opus::popular();
                break;
            case 'newest':
                $opera = Opus::newest();
                break;
            default:
                $opera = Opus::newest();
                break;
        }

        if ($period != null) {
            switch ($period) {
                case 'today':
                    $opera = $opera->today();
                    break;
                case '72h':
                    $opera = $opera->hoursAgo(72);
                    break;
                case '48h':
                    $opera = $opera->hoursAgo(48);
                    break;
                case '24h':
                    $opera = $opera->hoursAgo(24);
                    break;
                case '8h':
                    $opera = $opera->hoursAgo(8);
                    break;
                case 'week':
                    $opera = $opera->daysAgo(7);
                    break;
                case 'month':
                    $opera = $opera->daysAgo(30);
                    break;
            }
        }

        $opera = $opera->paginate($limit);
        
        return view('home.recent', compact('opera', 'request', 'filterSegment'));
    }
}
