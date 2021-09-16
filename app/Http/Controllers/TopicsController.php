<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\TopicRequest;
use App\Models\Topic;
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

        $topic->fill($request->all());
        $topic->user_id = $request->user_id;
        $topic->save();

        return  array("code" => 200, "msg" => "OK", "topic" => $topic);
    }

    public function edit(TopicRequest $request)
    {
        $topic = Topic::find($request->topic_id);

        // $topic->find($request->topic_id);

        $topic->fill($request->all());
        $topic->body = clean($topic->body);
        $topic->user_id = $request->user_id;
        $topic->save();

        return  array("code" => 200, "msg" => "OK", "topic" => $topic);
    }

    public function delete(Request $request)
    {
        Topic::destroy($request->topic_id);
        return  array("code" => 200, "msg" => "OK");
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        $response = [
            "success" => false,
            "file_path" => "",
        ];

        if ($request->upload_image) {
            $image = $uploader->saveImage($request->upload_image, false);
            if ($image) {
                $response = [
                    "success" => true,
                    "file_path" => $image,
                ];
            }
        }
        return $response;
    }
}
