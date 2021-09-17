<?php

namespace App\Observers;

use App\Models\Reply;
use PhpParser\Node\Expr\FuncCall;

class ReplyObserver
{
    // creating, created, updating, updated, saving,
    // saved,  deleting, deleted, restoring, restored
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content,"default");
    }
    public function created(Reply $reply)
    {
        // $reply->topic()->increment("reply_count", 1);
        // $reply->topic()->increment("reply_count");
        $topic = $reply->topic()->first();
        $topic->reply_count = $topic->replies()->count();
        $topic->save();
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
