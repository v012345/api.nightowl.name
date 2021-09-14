<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    //
    public function post(Request $request)
    {
        $blog =  User::find($request->user_id)->blogs()->create($request->all());
        return array("code" => 200, "msg" => "OK (from getAllUsers)", "blog" => $blog);
    }

    public function delete(Request $request)
    {

        $result =  Blog::where(["id" => $request->blog_id, "user_id" => $request->user_id])->delete();
        if ($result) {
            return array("code" => 200, "msg" => "Deleted");
        } else {
            return array("code" => 400, "msg" => "User doesn't have the blog");
        }
        // $blog =  User::find($request->user_id)->blogs()->create($request->all());
        // 
    }
}
