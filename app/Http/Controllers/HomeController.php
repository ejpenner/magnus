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
        if ($request->has('limit')) {
            $limit = $request->input('limit');
        } elseif (Auth::check()) {
            $limit = Auth::user()->preferences->per_page;
        } else {
            $limit = config('images.defaultLimit');
        }

        switch ($filter) {
            case 'hot':
                $opera = Opus::orderBy('daily_views', 'desc');
                break;
            case 'popular':
                $opera = Opus::views();
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
                case 'week':
                    $opera = $opera->daysAgo(7);
                    break;
            }
        }

        $opera = $opera->paginate($limit);
        
        return view('home.recent', compact('opera', 'request'));
    }
}
