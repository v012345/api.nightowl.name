<?php

namespace App\Http\Controllers;

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
}
