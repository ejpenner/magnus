<?php

namespace Magnus\Http\Controllers;

use Magnus\Opus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

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


    /**
     * The home page method
     *
     * @param Request $request
     * @param null $filter
     * @param null $period
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(Request $request, $filter = null, $period = null)
    {
        if (!\Request::wantsJson()) {
            $filterSegment = $this->filterSegment($request);

            $opera = $this->timeFilter($this->makeSearchFilter($filter), $period)->simplePaginate($this->limit($request));

            $opera = $opera->appends(Input::except('page'));

            return view('home.home', compact('opera', 'request', 'filterSegment'));
        }

        $input = Input::all();

        if (!$request->has('page')) {
            $input['page'] = 1;
        }

        //$filterSegment = $this->filterSegment($request);

        $opera = $this->timeFilter($this->makeSearchFilter($filter), $period)
            ->join('users', 'users.id', '=', 'opuses.user_id')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->join('roles', 'roles.id', '=', 'user_roles.role_id')
            ->select('opuses.title', 'opuses.thumbnail_path', 'opuses.created_at', 'opuses.updated_at', 'opuses.slug', 'roles.role_code as role_code', 'users.username', 'users.slug as userslug');
//        $opera = Cache::remember('opera', 60, function() use ($request, $opera, $input) {
//             return $opera->skip($this->limit($request) * ($input['page']-1))->take($this->limit($request))->get();
//        });


        $opera = $opera->skip($this->limit($request) * ($input['page']-1))->take($this->limit($request))->get();

        /*
         $articles = Cache::remember('articles', 22*60, function() {
        return Article::all();
         });

        */
        $opera = ['data' => $opera];

        return response()->json($opera);

    }

    protected function makeSearchFilter($filter)
    {
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

        return $opera;
    }

    protected function timeFilter($opera, $period)
    {
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
        return $opera;
    }

    protected function filterSegment($request)
    {
        return $filterSegment = !is_null($request->segment(1)) ? $request->segment(1) : 'newest';
    }

    protected function limit($request)
    {
        if ($request->has('limit')) {
            $limit = $request->input('limit');
        } elseif (Auth::check() and !$request->has('limit')) {
            $limit = Auth::user()->preferences->per_page;
        } else {
            $limit = config('images.defaultLimit');
        }
        return $limit;
    }
}
