<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Piece;
use App\Tag;

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

        $query = Piece::query();
        $query->join('piece_tag', 'piece_tag.piece_id', '=', 'id')
            ->join('tags', 'tags.id', '=', 'piece_tag.tag_id')
            ->join('features', 'features.piece_id', '=', 'piece_tag.piece_id')
            ->where(function ($q) use ($terms){
                foreach($terms as $term) {
                    if(strpos($term, 'tag:') !== false) {
                        $term = preg_replace('/tag:/', '', $term);
                        $q->orWhere('name', '=', trim($term));
                    }  elseif(strpos($term, 'title:') !== false) {
                        $term = preg_replace('/title:/', '', $term);
                        $q->orWhere('title', 'like', "%$term%");
                    }  else {
                        $q->orWhere('name', '=', $term);
                        $q->orWhere('title', 'like', "%$term%");
                        $q->orWhere('comment', 'like', "%$term%");
                    }
                }
            })->groupBy('pieces.id');

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
