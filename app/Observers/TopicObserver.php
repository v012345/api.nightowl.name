<?php

namespace App\Observers;

use App\Models\Topic;
use Illuminate\Support\Str;

class TopicObserver
{
    //
    public function saving(Topic $topic)
    {
        $topic->excerpt = Str::limit(trim(preg_replace("/[\r|\r\n|\n]+/", " ", strip_tags($topic->body))), 200);
    }
}
