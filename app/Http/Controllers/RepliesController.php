<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Reply;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    //
    public function create(ReplyRequest $request)
    {
        $reply = Reply::create($request->all());
        return array("code" => 200, "msg" => "OK", "reply" => $reply);
    }
}
