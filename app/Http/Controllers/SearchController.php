<?php

namespace Magnus\Http\Controllers;

use Illuminate\Http\Request;

use Magnus\Http\Requests;

use Magnus\Piece;
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

        $query = Opus::query();
        $query->join('opus_tag', 'opus_tag.opus_id', '=', 'id')
            ->join('tags', 'tags.id', '=', 'opus_tag.tag_id')
            ->where(function ($q) use ($terms){
                foreach($terms as $term) {
                    $term = trim($term);
                    if(strpos($term, '@') !== false) {
                        $term = preg_replace('/@/', '', $term);
                        $q->orWhere('name', '=', $term);
                    } else {
                        $q->orWhere('name', '=', $term);
                        $q->orWhere('title', 'like', "%$term%");
                        $q->orWhere('comment', 'like', "%$term%");
                    }
                }})
            ->groupBy('opuses.id');

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
