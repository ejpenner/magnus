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

    public function recent(Request $request, $filter = null) {
        if($request->has('limit')) {
            $limit = $request->input('limit');
        } else {
            $limit = 18;
        }
        switch  ($filter)
        {
            case 'hot':
                $opera = Opus::orderBy('daily_views', 'desc')->paginate($limit);
                break;
            case 'popular':
                $opera = Opus::orderBy('views', 'desc')->paginate($limit);
                break;
            default:
                $opera = Opus::orderBy('created_at', 'desc')->paginate($limit);
                break;
        }


        return view('home.recent', compact('opera','request'));
    }
}
