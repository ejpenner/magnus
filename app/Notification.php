<?php

namespace Magnus;

use Illuminate\Database\Eloquent\Model;
use Magnus\Http\Controllers\NotificationController;

class Notification extends Model
{
    protected $guarded = ['id'];

    /**
     * Notification has a M:N relationship with User model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('Magnus\User', 'notification_user')->withTimestamps();
    }

    /**
     * Notification has a 1:1 relationship with Comment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo('Magnus\Comment');
    }

    /**
     * Notification has a 1:1 relationship with Opus model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opus()
    {
        return $this->belongsTo('Magnus\Opus');
    }

    /**
     * Notification belongs to one user as a watcher for watch
     * notifications
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function watcher()
    {
        return $this->hasOne('Magnus\User', 'watcher_user_id');
    }

    /**
     * A Notification belongs to one favorite
     * For favorite notifications
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function favorite()
    {
        return $this->belongsTo('Magnus\Favorite');
    }

    /**
     * Notify a user with this notification
     * @param User $user
     */
    public function notify(User $user)
    {
        $user->notifications()->attach($this->id);
    }

    /**
     * Remove this notification from a user's message center
     * @param User $user
     */
    public function deleteNotification(User $user)
    {
        if ($this->hasOwner($user)) {
            $user->notifications()->detach($this->id);
        }
//        if ($this->users->count() == 0) {
//            $this->delete();
//        }
    }

    private function hasOwner(User $user)
    {
        foreach ($this->users as $notifiedUsers) {
            if ($user->id == $notifiedUsers->id) {
                return true;
            }
        }
        return abort(401);
    }

    /**
     * Parse the notification with the necessary information to be displayed
     * in a user's message center
     */
    public function parseNotification()
    {

    }

    /**
     *  Create a new Notification and let all users who watch the User know about it
     * @param Opus $opus
     */
    public static function notifyWatchersNewOpus(Opus $opus, User $user)
    {
        $notification = Notification::create([
            'handle'=>'opus',
            'opus_id' => $opus->id
        ]);

        foreach ($user->watchers as $watcher) {
            $u = User::find($watcher->user_id);
            $notification->notify($u);
        }
    }

    /**
     * Notify user one of their opus has been favorited
     * @param Favorite $favorite
     */
    public static function notifyCreatorNewFavorite(Favorite $favorite)
    {
        $notification = Notification::create([
            'handle' => 'favorite',
            'opus_id' => $favorite->opus_id,
            'favorite_id' => $favorite->id
        ]);
        $creator = $favorite->opus->user;
        $notification->notify($creator);
    }

    /**
     * A static method to create a reply notification and deliver it to $op
     * @param User $op original poster
     * @param User $replier
     * @param Comment $newComment
     */
    public static function notifyUserNewReply(User $op, User $replier, Comment $newComment)
    {
        if ($op->id != $replier->id) { // if op is not replying to their own comment
            $notify = Notification::create(['handle' => 'comment', 'comment_id' => $newComment->id]);
            $notify->notify($op);
        }
    }

    /**
     * A static method to create a top-level comment notification and deliver it to $op
     * @param User $op original poster
     * @param User $replier
     * @param Comment $newComment
     */
    public static function notifyUserNewComment(User $op, Comment $comment)
    {
        $notify = Notification::create(['handle' => 'comment', 'comment_id' => $comment->id]);
        $notify->notify($op);
    }

    /**
     * Notifies a user that they have a new user watching them
     * @param User $watched
     * @param User $watching
     */
    public static function notifyUserNewWatch(User $watched, User $watching)
    {
        $notify = Notification::create(['handle' => 'watch', 'watcher_user_id' => $watching->id]);
        $notify->notify($watched);
    }

    public static function notifyUserNewActivity()
    {

    }

    /**
     * Mass notification method
     */
    public static function notifyAll()
    {

    }

    /**
     *  Get the number of unread messages the user has
     * @return mixed
     */
    public static function messageCount(User $user)
    {
        $q = Notification::query();
        $q->join('notification_user', 'notifications.id', '=', 'notification_user.notification_id');
        $q->join('users', 'users.id', '=', 'notification_user.user_id');
        $q->where('notification_user.user_id', $user->id);
        //$q->where('notifications.read', '0');
        $r = $q->count();
        return $r;
    }
}
