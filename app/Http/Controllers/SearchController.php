<?php

namespace Magnus\Http\Controllers;

use Illuminate\Http\Request;

use Magnus\Http\Requests;

use Illuminate\Support\Facades\DB;
use Magnus\Opus;
use Magnus\Tag;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchAll(Request $request, $parameters)
    {
        $request->session()->put('searchString', $parameters);
        $parameters = str_replace(' ', '+', $parameters);
        $terms = explode('+', $parameters);

//        $query = Opus::query();
//        $query->join('opus_tag', 'opus_tag.opus_id', '=', 'id')
//            ->join('tags', 'tags.id', '=', 'opus_tag.tag_id')
//            ->select('opuses.*', 'opus_tag.tag_id')
//            ->where(function ($q) use ($terms){
//                $tagsArray = [];
//                foreach($terms as $i => $term) {
//                    $term = trim($term);
//                        if(strpos($term, '@') !== false) {
//                            $term = preg_replace('/@/', '', $term);
//                            $q->where('tags.name', '=', $term);
//                        } else {
//                            $q->where('tags.name', '=', $term);
//                        }
//
//                        if(strpos($term, '@') !== false) {
//                            $term = preg_replace('/@/', '', $term);
//                            $q->where('name', 'like', $term);
//                        } else {
//                            $q->orWhere('name', '=', $term);
//                            $q->orWhere('title', 'like', "%$term%");
//                            $q->orWhere('comment', 'like', "%$term%");
//                    }
//
//                    }
//                });//->groupBy('opuses.id');

        $tag_ids = [];
        $termList = [];
        $whereClause = '';
        foreach($terms as $term)
        {
            $term = trim($term);
            if(strpos($term, '@') !== false) {
                try {
                    $term = preg_replace('/@/', '', $term);
                    $tag = Tag::where('name', $term)->first();
                    array_push($tag_ids, $tag->id);
                } catch (\Exception $e) {}
            } else {
                array_push($termList, filter_var($term, FILTER_SANITIZE_STRING));
            }
        }

        foreach ($termList as $term) {
            $whereClause .= 'OR WHERE ';
        }

        if(count($tag_ids) > 0) {
            $havingClause = 'opus_tag.tag_id IN (' . implode($tag_ids, ', ') . ') ';
        } else {
            $havingClause = '1 = 1';
        }

        $query = 'SELECT opuses.*, opus_tag.*, users.slug AS uslug, users.username
                  FROM opuses
                  INNER JOIN opus_tag ON opuses.id = opus_tag.opus_id
                  INNER JOIN tags ON tags.id = opus_tag.tag_id
                  INNER JOIN users ON users.id = opuses.user_id
                  GROUP BY opus_tag.opus_id
                  HAVING '.$havingClause.'
                  '.$whereClause;

        $results = DB::select($query);

        $paginatedResults = new Paginator($results, count($results), 24,
            \Illuminate\Pagination\Paginator::resolveCurrentPage(), //resolve the path
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]);
        
        return view('search.index', compact('paginatedResults'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchGallery()
    {
        //
    }

}
