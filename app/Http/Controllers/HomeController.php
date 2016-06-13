<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Gallery;
use App\Piece;
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
    
    public function recent() {
        $pieces = Piece::orderBy('created_at', 'desc')->paginate(16);
        $galleries = Gallery::orderBy('updated_at', 'desc')->limit(10)->get();
        return view('home.recent', compact('pieces','galleries'));
    }
}
