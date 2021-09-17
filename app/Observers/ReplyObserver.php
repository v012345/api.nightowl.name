<?php

namespace App\Observers;

use App\Models\Reply;

class ReplyObserver
{
    //
    public function created(Reply $reply)
    {
        $reply->topic()->increment("reply_count", 1);
    }
}
