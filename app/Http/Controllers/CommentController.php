<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Comment;
use App\Piece;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            'auth',
            [
                'only' => ['create','store','edit','update','destroy']
            ]
        );

        $this->middleware('comment', ['except'=>['show','index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $gallery_id, $piece_id)
    {
        $piece = Piece::findOrFail($piece_id);
        $comment = new Comment(['user_id'=>Auth::user()->id,'body'=>$request->input('body')]);
        $piece->comments()->save($comment);
        
        return redirect()->route('gallery.p.show', [$gallery_id, $piece->id]);
    }

    /**
     *  store a reply to a comment
     *
     * @param Request $request
     * @param $gallery
     * @param $piece
     * @param $comment
     */

    public function storeNested(Request $request, $gallery, $piece, $comment)
    {
        dd($gallery . ' '. $piece . ' ' . $comment);
    }
    
    
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updatedNested(Request $request, $gallery, $piece, $comment)
    {
        dd($gallery . ' '. $piece . ' ' . $comment);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
