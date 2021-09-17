<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;
use Illuminate\Support\Str;

class TopicObserver
{
    // creating, created, updating, updated, saving,
    // saved,  deleting, deleted, restoring, restored
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, "user_topic_body");
        $topic->excerpt = Str::limit(trim(preg_replace("/[\r|\r\n|\n]+/", " ", strip_tags($topic->body))), 200);
        $topic->body = clean($topic->body);
    }

    public function saved(Topic $topic)
    {
        if (!$topic->slug) {

            dispatch(new TranslateSlug($topic));

            // $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}
