<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use App\Observers\TopicObserver;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("FormatPaginatedResults", ["only" => ["index"]]);
    }
    public function index(Request $request)
    {

        $topics = Topic::orderWith("updated_at")->whereIn("category_id", [1])->with(["category", "user"])->paginate($request->per_page);
        return array("code" => 200, "msg" => "OK", "data" => $topics);
        // Topic::query()->paginate(5);
    }

    public function create(TopicRequest $request, Topic $topic)
    {
        Topic::observe(TopicObserver::class);
        $topic->fill($request->all());
        $topic->user_id = $request->user_id;
        $topic->save();

        return $topic;
    }
}
