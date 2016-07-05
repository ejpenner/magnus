<?php

namespace Magnus;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['handle', 'read', 'opus_id','comment_id','message_id'];
    protected $casts = ['read'=>'boolean'];

    /**
     * Notification has a M:N relationship with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('Magnus\User', 'notification_user')->withTimestamps();
    }

    /**
     * Notification has a 1:1 relationship with Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo('Magnus\Comment');
    }

    /**
     * Notification has a 1:1 relationship with Opus model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opus()
    {
        return $this->belongsTo('Magnus\Opus');
    }

    public function opusNotification(Opus $opus, User $user)
    {
        $this->opus_id = $opus->id;
        $user->notifications()->attach($this->id);
    }

    public function notify(User $user)
    {
        $user->notifications()->attach($this->id);
    }
    
    public function deleteNotification(User $user)
    {
        if ($this->hasOwner($user)) {
            $user->notifications()->detach($this->id);
        }
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
     *  Create a new Notification and let all users who watch the User know about it
     *
     * @param Opus $opus
     */
    public static function notifyWatchersNewOpus(Opus $opus, User $user)
    {
        $notification = Notification::create([
            'handle'=>'opus',
            'opus_id' => $opus->id,
            'content' => $opus->title
        ]);

        foreach ($user->watchers as $watcher) {
            $u = User::find($watcher->user_id);
            $notification->notify($u);
        }
    }

    /**
     * A static method to create a reply notification and deliver it to $op
     *
     * @param User $op
     * @param User $replier
     * @param Comment $newComment
     */
    public static function notifyUserNewReply(User $op, User $replier, Comment $newComment)
    {
        if ($op->id != $replier->id) { // if op is not replying to their own comment
            $notify = Notification::create(['handle' => 'comment', 'comment_id' => $newComment->id, 'content' => $newComment->body]);
            $notify->notify($op);
        }
    }

    /**
     * A static method to create a top-level comment notification and deliver it to $op
     *
     * @param User $op
     * @param User $replier
     * @param Comment $newComment
     */
    public static function notifyUserNewComment(User $op, Comment $comment)
    {
        $notify = Notification::create(['handle' => 'comment', 'comment_id' => $comment->id, 'content' => $comment->body]);
        $notify->notify($op);
    }
}
