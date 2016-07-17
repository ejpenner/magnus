<?php

namespace Magnus\Http\Controllers;

use Illuminate\Http\Request;

use Magnus\Favorite;
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
        $query = Opus::query()
                    ->join('notifications', 'opuses.id', '=', 'notifications.opus_id')
                    ->join('notification_user', 'notification_user.notification_id', '=', 'notifications.id')
                    ->where('notification_user.user_id', $user->id)
                    ->select(
                        'opuses.id',
                        'opuses.user_id',
                        'opuses.image_path',
                        'opuses.thumbnail_path',
                        'opuses.title',
                        'notification_user.notification_id',
                        'opuses.slug'
                    )
                    ->orderBy('opuses.created_at', 'desc');
        $opusResults = $query->paginate(8, '[*]', 'opera');

        // query to grab all Comment notifications
        $commentQuery = Comment::query()
                    ->join('notifications', 'comments.id', '=', 'notifications.comment_id')
                    ->join('notification_user', 'notification_user.notification_id', '=', 'notifications.id')
                    ->where('notification_user.user_id', $user->id)
                    ->select('comments.*', 'notification_user.notification_id')
                    ->orderBy('comments.created_at', 'desc');
        $commentResults = $commentQuery->paginate(8, '[*]', 'comments');

        // query to get all Favorite Notifications
        $favorites = Favorite::query()
                    ->join('notifications', 'favorites.id', '=', 'notifications.favorite_id')
                    ->join('notification_user', 'notification_user.notification_id', '=', 'notifications.id')
                    ->join('favorite_user', 'favorites.id', '=', 'favorite_user.favorite_id')
                    ->join('opuses', 'opuses.id', '=', 'notifications.opus_id')
                    ->where('notification_user.user_id', $user->id)
                    ->select('favorites.*', 'favorite_user.user_id', 'notification_user.notification_id', 'opuses.title')
                    ->orderBy('notification_user.created_at', 'desc');
        $favoritesResults = $favorites->paginate(24, '[*]', 'activity');

        return view('notification.index', compact('user', 'opusResults', 'commentResults', 'favoritesResults'));
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
    public function destroy(Request $request, $id)
    {
        if (Auth::check()) {
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
