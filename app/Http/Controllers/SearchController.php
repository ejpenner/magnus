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
    public function searchAll(Request $request)
    {
        $query = Tag::query();
        //dd($request->input('search-terms'));
        $terms = explode(' ', $request->input('search-terms'));
        //dd($terms);

        $query->join('piece_tag', 'piece_tag.tag_id', '=', 'id')
        ->join('pieces', 'pieces.id', '=', 'piece_tag.piece_id')->limit(5);
        dd($query->get());
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
