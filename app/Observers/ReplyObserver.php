<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;
use PhpParser\Node\Expr\FuncCall;

class ReplyObserver
{
    // creating, created, updating, updated, saving,
    // saved,  deleting, deleted, restoring, restored
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, "default");
    }
    public function created(Reply $reply)
    {
        // $reply->topic()->increment("reply_count", 1);
        // $reply->topic()->increment("reply_count");

        $reply->topic->reply_count = $reply->topic->replies()->count();
        $reply->topic->save();
        if (!app()->runningInConsole()) {
            if ($reply->user->id != $reply->topic->user->id) {
                $reply->topic->user->increment("notification_count");
                $reply->topic->user->notify(new TopicReplied($reply));
            }
        }
    }
    // public function deleting(Reply $reply)
    // {
    //     // dump(1,$reply);
    //     // $reply->topic()->decrement("reply_count");

    //     $reply->topic->reply_count = $reply->topic->replies->count();
    //     $reply->topic->save();
    // }
    // both work!
    public function deleted(Reply $reply)
    {
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }
}
