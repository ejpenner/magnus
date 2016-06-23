<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Gallery;
use App\Opus;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(
            'auth',
            [
                'only' => ['create','edit','destroy']
            ]
        );
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
    
    public function recent($filter = null) {
        switch  ($filter)
        {
            case 'hot':
                $opera = Opus::orderBy('daily_views', 'desc')->paginate(16);
                break;
            case 'popular':
                $opera = Opus::orderBy('views', 'desc')->paginate(16);
                break;
            default:
                $opera = Opus::orderBy('created_at', 'desc')->paginate(16);
                break;
        }
        return view('home.recent', compact('opera'));
    }
}
