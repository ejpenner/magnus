<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Comment;
use App\Opus;
use App\Notification;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',    ['except'=>['show','index']]);
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
     * Store a newly created resource in storage and notify the
     * owner of the Opus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CommentRequest $request, $opus_id)
    {
        $opus = Opus::findOrFail($opus_id);
        $comment = new Comment(['user_id'=>Auth::user()->id,'body'=>$request->input('body')]);
        $newComment = $opus->comments()->save($comment);

        Notification::notifyUserNewComment($opus->user, $newComment);

        return redirect()->to(app('url')->previous(). '#'.$newComment->id)->with('success', 'Message posted!');
    }

    /**
     * Controller method to store top level comments on profiles
     * 
     * @param Requests\CommentRequest $request
     * @param $profile_id
     */
    public function storeProfile(Requests\CommentRequest $request, $profile_id)
    {
        
    }

    /**
     * store a reply to a comment and notify the OP
     *
     * @param Requests\CommentRequest $request
     * @param $opus_id
     * @param $comment_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeChild(Requests\CommentRequest $request, $opus_id, $comment_id)
    {
        $opus = Opus::findOrFail($opus_id);
        $comment = Comment::findOrFail($comment_id);
        $comment->childComments()->save(new Comment(['user_id'=>Auth::user()->id, 'opus_id'=>$opus->id, 'parent_id'=>$comment->id, 'body'=>$request->input('body')]));
        $newComment = Comment::where('parent_id', $comment->id)->orderBy('created_at', 'desc')->first();

        Notification::notifyUserNewReply($comment->user, $newComment->user, $newComment);

        return redirect()->to(app('url')->previous(). '#'.$newComment->id)->with('success', 'Message posted!');
    }

    /**
     * store a reply to a comment and notify the OP and give
     * the option to remove the message from Auth::user()'s message center
     *
     * @param Requests\CommentRequest $request
     * @param $opus_id
     * @param $comment_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeChildRemoveNotification(Requests\CommentRequest $request, $opus_id, $comment_id, $notification_id)
    {
        $opus = Opus::findOrFail($opus_id);
        $comment = Comment::findOrFail($comment_id);
        $comment->childComments()->save(new Comment(['user_id'=>Auth::user()->id, 'opus_id'=>$opus->id, 'parent_id'=>$comment->id, 'body'=>$request->input('body')]));
        $newComment = Comment::where('parent_id', $comment->id)->orderBy('created_at', 'desc')->first();

        Notification::notifyUserNewReply($comment->user, $newComment->user, $newComment);

        if($request->input('remove_notify')) {
            $notification = Notification::where('id', $notification_id)->first();
            Auth::user()->deleteNotification($notification);
        }
        return redirect()->to(app('url')->previous(). '#'.$newComment->id)->with('success', 'Message posted!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        return view('comment.show', compact('comment'));
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