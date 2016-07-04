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
        if($request->has('limit')) {
            $limit = $request->input('limit');
        } else {
            $limit = config('images.defaultLimit');
        }
        
        $request->session()->put('searchString', $parameters);
        $parameters = str_replace(' ', '+', $parameters);
        $terms = explode('+', $parameters);

        $tag_ids = [];
        $termList = [];
        $whereClause = '';
        $tagClause = '';

        foreach($terms as $term)
        {
            $term = trim($term);
            if(strpos($term, '@') !== false) {
                try {
                    $term = preg_replace('/@/', '', filter_var($term, FILTER_SANITIZE_STRING));
                    $tag = Tag::where('name', $term)->first();
                    array_push($tag_ids, $tag->id);
                } catch (\Exception $e) {}
            } else {
                array_push($termList, filter_var($term, FILTER_SANITIZE_STRING));
            }
        }

        if(count($tag_ids) > 0) {
            $tagClause = 'WHERE ';
            foreach ($tag_ids as $i => $id) {
                if($i < 1) {
                    $tagClause .=  ' t.id = ' . $id . ' ';
                } else {
                    $tagClause .=  ' OR t.id = ' . $id . ' ';
                }

            }
        }

        if(count($termList) > 0) {
            $whereClause = 'WHERE ';
            foreach ($termList as $i => $term) {
                if($i < 1) {
                    $whereClause .=  ' u.username = \'' . $term . '\'
                                 OR o.title LIKE \'%' . $term . '%\' ';
                } else {
                    $whereClause .=  ' OR u.username = \'' . $term . '\'
                                 OR o.title LIKE \'%' . $term . '%\' ';
                }

            }
        }

        $query = 'SELECT o.*, u.name, u.slug uslug, matching_tags.matched
                  FROM opuses o
                  INNER JOIN opus_tag ot ON o.id = ot.opus_id
                  INNER JOIN tags t ON t.id = ot.tag_id
                  INNER JOIN users u ON u.id = o.user_id
				  RIGHT OUTER JOIN 
				    (SELECT DISTINCT o.id AS id, count(*) as matched
					 FROM opuses o JOIN opus_tag ot ON o.id = ot.opus_id
					 JOIN tags t ON ot.tag_id = t.id
					 '. $tagClause .'
					 GROUP BY o.id) AS matching_tags ON o.id = matching_tags.id 
                     '. $whereClause .'
                GROUP BY o.id, matching_tags.matched
                ORDER BY matched DESC';


        $results = DB::select($query);

        $paginatedResults = new Paginator($results, count($results), $limit,
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
