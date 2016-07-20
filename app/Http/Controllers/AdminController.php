<?php

namespace Magnus\Http\Controllers;

use Magnus\Opus;
use Magnus\Permission;
use Magnus\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

//        $query = Opus::query()
//            ->join('users', 'users.id', '=', 'opuses.user_id')
//            ->join('(SELECT favorites.opus_id, count(*) FROM favorites join favorite_user on favorites.id = favorite_user.favorite_id group by opus_id) as favorite_count', 'favorite_count.opus_id', '=', 'opuses.id')
//            ->select('users.id as user_id', 'opuses.id as id', 'opuses.title', 'users.username',
//                'opuses.views', 'opuses.created_at', 'opuses.slug as slug', 'users.slug as user_slug')
//            ->orderBy($orderBy, $direction);
        $whereClause = '';
        if (isset($input['filter'])) {
            $filterCount = 0;
            $whereClause .= 'WHERE';
            $filterParam = $input['filter'];
            foreach ($filterParam as $key => $value) {
                $filterValue = '\'%' . filter_var($value, FILTER_SANITIZE_STRING) . '%\'';
                $column = $key;
                if($column == 'created_at') $column = 'opuses.'.$column;
                if($filterCount > 0) $whereClause .= 'AND';
                //$query = $query->where($column, 'like', $filterValue);
                $whereClause .= " $column LIKE $filterValue ";
                $filterCount++;
            }
        }

        $rawQuery = "SELECT u.id user_id, o.id id, o.title, u.username, o.views, o.created_at, o.slug slug, u.slug user_slug,
                     IFNULL(favorite_count.count, 0) as favorite_count
                     FROM opuses o
                          INNER JOIN users u ON u.id = o.user_id
                          LEFT OUTER JOIN 
                         (SELECT favorites.opus_id, count(*) AS count 
                          FROM favorites 
                          JOIN favorite_user ON favorites.id = favorite_user.favorite_id 
                          GROUP BY favorites.opus_id) as favorite_count ON o.id = favorite_count.opus_id
                          $whereClause
                          ORDER BY $orderBy $direction
                          LIMIT " . $input['count'] . " OFFSET ". (($input['page'] - 1) * $input['count']) .";";

        $opus = DB::select($rawQuery);

        return response()->json(['data' => $opus]);
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
