<?php

namespace Magnus\Http\Controllers;

use Illuminate\Http\Request;

use Magnus\Http\Requests;

use Magnus\Piece;
use Illuminate\Support\Facades\DB;
use Magnus\Opus;
use Magnus\Tag;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchAll($parameters)
    {


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
////                        if(strpos($term, '@') !== false) {
////                            $term = preg_replace('/@/', '', $term);
////                            $q->where('name', 'like', $term);
////                        } else {
//                            //$q->orWhere('name', '=', $term);
//                            //$q->orWhere('title', 'like', "%$term%");
//                            //$q->orWhere('comment', 'like', "%$term%");
//                    //}
//
//                    }
//                });//->groupBy('opuses.id');

        $tag_ids = [];
        foreach($terms as $term)
        {
            $term = trim($term);
            if(strpos($term, '@') !== false) {
                try {
                    $term = preg_replace('/@/', '', $term);
                    $tag = Tag::where('name', $term)->first();
                    array_push($tag_ids, $tag->id);
                } catch (\Exception $e) {}
            }
        }

        if(count($tag_ids) > 0) {
            $havingClause = 'opus_tag.tag_id IN (' . implode($tag_ids, ', ') . ') ';
        } else {
            $havingClause = '';
        }

        $query = Opus::query();
        $query->join('opus_tag', 'opus_tag.opus_id', '=', 'id')
            ->join('tags', 'tags.id', '=', 'opus_tag.tag_id')
            ->select('opuses.*', 'opus_tag.tag_id')
            ->groupBy('opuses.id','opus_tag.tag_id')
            ->havingRaw($havingClause);

//        $query = 'SELECT opuses.*, opus_tag.tag_id
//                  FROM opuses
//                  INNER JOIN opus_tag ON opuses.id = opus_tag.opus_id
//                  INNER JOIN tags ON tags.id = opus_tag.tag_id
//                  GROUP BY opuses.id, opus_tag.tag_id
//                  HAVING '.$havingClause;


        $results = $query->paginate(24);

        return view('search.index', compact('results'));
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
