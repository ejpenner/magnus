<?php

namespace Magnus\Http\Controllers;

use Magnus\User;
use Magnus\Opus;
use Magnus\Comment;
use Magnus\Journal;
use Magnus\Notification;
use Magnus\Http\Requests;
use Magnus\Helpers\Direct;
use Magnus\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('comment', ['only'=>['update', 'destroy', 'edit']]);
    }

    /**
     * Store a newly created resource in storage and notify the
     * owner of the Opus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, Opus $opus)
    {
        $comment = new Comment(['user_id'=>$request->user()->id,'body'=>$request->input('body')]);
        $newComment = $opus->comments()->save($comment);

        Notification::notifyUserNewComment($opus->user, $newComment);

        return Direct::newOpusComment($opus, $newComment);
    }

    /**
     * Store a new comment on a journal
     * @param Requests\CommentRequest $request
     * @param Journal $journal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeJournal(CommentRequest $request, Journal $journal)
    {
        $comment = new Comment(['user_id'=>$request->user()->id,'body'=>$request->input('body')]);
        $newComment = $journal->comments()->save($comment);
        $op = $journal->user;

        Notification::notifyUserNewReply($op, $request->user(), $newComment);

        return Direct::newJournalComment($journal, $newComment);
    }

    public function storeChildJournal(CommentRequest $request, Journal $journal, $comment_id)
    {

    }

    /**
     * Controller method to store top level comments on profiles
     *
     * @param Requests\CommentRequest $request
     * @param $profile_id
     */
    public function storeProfile(CommentRequest $request, User $profile)
    {
        
    }

    /**
     * Controller method to store replies to top-level commetns on profiles
     * @param Requests\CommentRequest $request
     * @param User $profile
     * @param $comment_id
     */
    public function storeChildProfile(CommentRequest $request, User $profile, $comment_id)
    {

    }
    
    /**
     * store a reply to a comment and notify the OP
     * @param Requests\CommentRequest $request
     * @param Opus $opus
     * @param $comment_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeChild(CommentRequest $request, Opus $opus, $comment_id)
    {
        //$opus = Opus::findOrFail($opus_id);
        $comment = Comment::findOrFail($comment_id);
        $newComment = $comment->childComments()->save(new Comment(['user_id'=>$request->user()->id, 'opus_id'=>$opus->id, 'parent_id'=>$comment->id, 'body'=>$request->input('body')]));
        //$newComment = Comment::where('parent_id', $comment->id)->orderBy('created_at', 'desc')->first();

        Notification::notifyUserNewReply($comment->user, $newComment->user, $newComment);

        return Direct::newOpusComment($opus, $newComment);
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
    public function storeChildRemoveNotification(CommentRequest $request, $opus_id, $comment_id, $notification_id)
    {
        $opus = Opus::findOrFail($opus_id);
        $comment = Comment::findOrFail($comment_id);
        $newComment = $comment->childComments()->save(new Comment(['user_id'=>$request->user()->id, 'opus_id'=>$opus->id, 'parent_id'=>$comment->id, 'body'=>$request->input('body')]));
        //$newComment = Comment::where('parent_id', $comment->id)->orderBy('created_at', 'desc')->first();

        Notification::notifyUserNewReply($comment->user, $newComment->user, $newComment);

        if ($request->input('remove_notify')) {
            $notification = Notification::where('id', $notification_id)->first();
            $notification->deleteNotification($request->user());
        }

        return Direct::route('message.center', ['success', 'Message posted!']);
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
    public function update(CommentRequest $request, $id)
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->deleted = 1;
        $comment->save();
    }
}
