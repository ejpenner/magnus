<?php

namespace Magnus\Http\Controllers;

use Illuminate\Http\Request;

use Magnus\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Magnus\Opus;
use Magnus\Comment;
use Magnus\User;
use Magnus\Notification;

class NotificationController extends Controller
{
    /**
     *  Message inbox for logged in user
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Query to grab all Opus notifications
        $user = Auth::user();
        $query = Opus::query();
        $query->join('notifications', 'opuses.id', '=', 'notifications.opus_id');
        $query->join('notification_user', 'notification_user.notification_id', '=', 'notifications.id');
        $query->where('notification_user.user_id', $user->id);
        $query->select('opuses.id', 'opuses.user_id', 'opuses.image_path', 'opuses.thumbnail_path', 'opuses.title', 'notification_user.notification_id');
        $query->orderBy('opuses.created_at', 'desc');
        $opusResults = $query->get();

        // query to grab all Comment notifications
        $commentQuery = Comment::query();
        $commentQuery->join('notifications', 'comments.id', '=', 'notifications.comment_id');
        $commentQuery->join('notification_user', 'notification_user.notification_id', '=', 'notifications.id');
        $commentQuery->where('notification_user.user_id', $user->id);
        $commentQuery->select('comments.id', 'comments.created_at', 'comments.user_id', 'comments.parent_id', 'comments.profile_id', 'comments.body', 'notification_user.notification_id', 'comments.opus_id');
        $commentQuery->orderBy('comments.created_at', 'desc');
        $commentResults = $commentQuery->get();

        return view('notification.index', compact('user', 'opusResults', 'commentResults'));
    }

    public function destroySelected(Request $request)
    {
        if (Auth::check() and $request->has('notification_ids')) {
            $user = Auth::user();
            foreach ($request->input('notification_ids') as $id) {
                $notification = Notification::findOrFail($id);
                $notification->deleteNotification($user);

                if ($notification->users->count() < 1) {
                    $notification->delete();
                }
            }
            return redirect()->to(app('url')->previous())->with('success', 'Messages deleted!');
        }

        return abort('401');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check()) {
            $user = Auth::user();
            $notification = Notification::findOrFail($id);
            $notification->deleteNotification($user);

            if ($notification->users->count() < 1) {
                $notification->delete();
            }
            return redirect()->to(app('url')->previous())->with('success', 'Message deleted!');
        }
        return redirect()->to(app('url')->previous())->withErrors('You shouldn\'t have done that');
    }
}
