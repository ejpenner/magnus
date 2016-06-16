<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Comment;
use App\Opus;
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
    public function store(Requests\CommentRequest $request, $opus_id)
    {
        $opus = Opus::findOrFail($opus_id);
        $comment = new Comment(['user_id'=>Auth::user()->id,'body'=>$request->input('body')]);
        $newComment = $opus->comments()->save($comment);
        //return redirect()->route('gallery.p.show', [$gallery_id, $piece->id, $newComment->id])->with('success', 'Message posted!');
        return redirect()->to(app('url')->previous(). '#'.$newComment->id)->with('success', 'Message posted!');
    }

    /**
     *  store a reply to a comment
     *
     * @param Request $request
     * @param $piece
     * @param $comment
     */

    public function storeChild(Requests\CommentRequest $request, $opus_id, $comment_id)
    {
        $opus = Opus::findOrFail($opus_id);
        $comment = Comment::findOrFail($comment_id);
        $comment->childComments()->save(new Comment(['user_id'=>Auth::user()->id, 'opus_id'=>$opus->id, 'parent_id'=>$comment->id, 'body'=>$request->input('body')]));
        $newComment = Comment::where('parent_id', $comment->id)->orderBy('created_at', 'desc')->first();
        //return redirect()->route('gallery.p.show', [$gallery_id, $piece->id])->with('success', 'Message posted!');
        return redirect()->to(app('url')->previous(). '#'.$newComment->id)->with('success', 'Message posted!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($gallery_id, $piece_id, $comment_id)
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
    public function update(Requests\CommentRequest $request, $id)
    {
        //
    }

    public function updatedNested(Requests\CommentRequest $request, $piece, $comment)
    {
        dd(' '. $piece . ' ' . $comment);
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
