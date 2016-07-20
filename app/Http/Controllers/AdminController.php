<?php

namespace Magnus\Http\Controllers;

use Magnus\Opus;
use Magnus\Permission;
use Magnus\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{

    public function session(Request $request)
    {
        $session = $request->session()->all();
        return view('admin.session', compact('session'));
    }
    
    public function index()
    {
        return view('admin.index');
    }

    public function opus(Request $request)
    {
        $input = $request->all();

        if (!\Request::wantsJson()) {
            return view('admin.opus');
        }

        if (isset($input['sorting'])) {
            $orderParam = $input['sorting'];
            $orderBy = key($orderParam);
            if($orderBy == 'created_at') $orderBy = 'opuses.'.$orderBy;
            $direction = $input['sorting'][key($orderParam)];
        } else {
            $orderBy = 'id';
            $direction = 'asc';
        }

        $query = Opus::query()
            ->join('users', 'users.id', '=', 'opuses.user_id')
            ->select('users.id as user_id', 'opuses.id as id', 'opuses.title', 'users.username',
                'opuses.views', 'opuses.created_at', 'opuses.slug as slug', 'users.slug as user_slug')
            ->orderBy($orderBy, $direction);

        if (isset($input['filter'])) {
            $filterParam = $input['filter'];

            foreach ($filterParam as $key => $value) {
                $filterValue = '%' . $value . '%';
                $column = $key;
                if($column == 'created_at') $column = 'opuses.'.$column;
                $query = $query->where($column, 'like', $filterValue);
            }
        }


        $opus = $query->paginate();

        return response()->json($opus);
    }

    public function test()
    {
//        $files = File::glob(base_path('resources/seed-pics/*.*'));
//        dd($files[rand(1,10)]);
        //dd(public_path('art/Vilest'));
        //dd(strrpos(app('url')->previous(), 'opus'));
        //dd(app('url')->previous());
        //dd(Permission::hasPermission(Auth::user(), 'user_banned'));
//        dd(Auth::user()->favorites);
//        dd(Opus::find(32)->favorites);
//        $favorite = $favorites = Auth::user()->favorites->where(['opus_id'=>32])->get();
//        dd($favorite);

        return view('tester');
    }
}
