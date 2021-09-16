<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;
use ErrorException;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redis;
use stdClass;

class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('throttle:2,1', ['only' => ['logout']]);
        $this->middleware("FormatPaginatedResults", ['only' => ["all", "blogs", "followers", "followings", "dynamic"]]);
    }


    public function signup(Request $request)
    {
        // $session = new stdClass();
        // $user = new stdClass();
        // // $session = array("phone_number" => $request->phone_number, "verifying_code" => random_int(1000, 9999));
        // // $session = json_decode(json_encode($session));
        // $session->phone_number = $request->phone_number;

        // $session->updated_at = date("Y-m-d H:i:s", time());
        // $session->remember_me = false;

        $verification_code = Redis::get($request->phone_number);
        // dd(gettype($verifying_code));
        if ($verification_code && $verification_code == $request->verification_code) {
            Redis::del($request->phone_number);
            try {
                $user = User::create($request->all());
            } catch (QueryException $e) {
                return array('code' => 400, 'msg' => 'Phone number has signed up');
            }
            return array('code' => 200, 'msg' => 'Has sent sms', 'user' => $user);
        }
        return array('code' => 400, 'msg' => 'Wrong verifying code');
    }

    public function login(Request $request)
    {
        $user = (User::where([$request->mode => $request->user, "password" => $request->password])->get())->first();
        if ($user) {
            return array('code' => 200, 'msg' => 'Signup successfully', 'user' => $user);
        }
        return array('code' => 400, 'msg' => 'Account doesn\'t match password');
    }

    public function logout(Request $request)
    {
        return array('code' => 200, 'msg' => 'User log out (from logout)');
    }
    public function update(Request $request, ImageUploadHandler $uploader)
    {
        $user = User::find($request->user_id);

        if ($request->avatar) {
            $avatar = $uploader->saveImage($request->avatar, true);
            if ($avatar) {
                $user->update(["avatar" => $avatar]);
            }
        }
        // $request->headers=123;
        $user->update($request->except("avatar"));
        // $user->makeVisible('password');
        dd($user);
        return array('code' => 200, 'msg' => 'Set profile successfully', 'user' => $user);
    }

    public function all(Request $request)
    {
        $users = User::paginate($request->per_page);
        return array("code" => 200, "msg" => "OK (from getAllUsers)", "data" => $users);
    }

    public function delete(Request $request)
    {
        $admin = User::find($request->user_id);
        if ($admin->admin) {
            User::destroy($request->delete_user_id);
            return array('code' => 200, 'msg' => 'User has been deleted (from delete)');
        }
        return array('code' => 400, 'msg' => 'Not an admin');
    }

    public function activateEmail(Request $request)
    {

        try {
            $activation_token = Crypt::decrypt($request->activation_token);
            // if ((new Carbon())->diffInMinutes(Carbon::parse($activation_token->created_at)) > 3) {
            //     abort(403, "The email has expired, please resent a new email!");
            // }
            $user = User::find($activation_token->user->user_id);
            if (!$user)
                abort(403, "Wrong user id");
            $user->update(["email" => $activation_token->email, "email_verified_at" => now()]);
        } catch (DecryptException $e) {
            abort(403, "Wrong activation token");
        } catch (QueryException $e) {
            abort(403, "The email has been used");
        }
        $redirectURL = preg_replace_callback(["/^[^(https?:\/\/)].*/", "/(\/+)$/"], function ($matches) {
            if (isset($matches[1]))
                return "/";
            return "http://" . $matches[0] . "/";
        }, $activation_token->redirectURL) . $user->id;
        // return redirect($activation_token->redirectURL, 301);
        return redirect()->away($redirectURL);
    }

    public function detail(Request $request)
    {
        $user = User::find($request->user_id);
        return  array('code' => 200, 'msg' => 'User profile', 'user' => $user);
    }

    public function resetPassword(Request $request)
    {
        // $user = User::where($request->all())->get();
        // 

        if ($request->has("phone_number")) {
            $key = $request->input("phone_number");
            $user = User::where("phone_number", $request->phone_number)->first();
        }
        if ($request->has("email")) {
            $key = $request->input("email");
            $user = User::where("email", $request->email)->first();;
        }
        $verification_code = Redis::get($key);

        if ($verification_code && $verification_code == $request->verification_code) {
            Redis::del($key);
            try {
                $user->password = $request->new_password;
                $user->save();
            } catch (ErrorException $e) {
                // dd($e);
                return array('code' => 400, 'msg' => 'User doesn\'t exist');
            }
            return array('code' => 200, 'msg' => 'Password has reseted');
        }
        return array('code' => 400, 'msg' => 'Wrong verifying code');
    }

    public function blogs(Request $request)
    {
        $user = User::find($request->user_id);
        $blogs = $user->blogs()->orderBy('created_at', 'desc')->paginate($request->per_page);
        return array("code" => 200, "msg" => "OK (from getAllUsers)", "data" => $blogs);
    }

    public function dynamic(Request $request)
    {

        $user_ids =  User::find($request->user_id)->followings->pluck('id')->toArray();
        array_push($user_ids, $request->user_id);
        $dynamic =  Blog::whereIn('user_id', $user_ids)->with('user')->orderBy('created_at', 'desc')->paginate($request->per_page);
        return array("code" => 200, "msg" => "OK (from getAllUsers)", "data" => $dynamic);
    }

    public function follow(Request $request)
    {
        $user = User::find($request->user_id);
        $user->followings()->sync($request->follow, false);
        return array("code" => 200, "msg" => "OK");
    }

    public function unfollow(Request $request)
    {
        $user = User::find($request->user_id);
        if (!isset($request->unfollow)) {
            return array("code" => 400, "msg" => "Miss unfollow array");
        }
        $user->followings()->detach($request->unfollow);
        return array("code" => 200, "msg" => "OK");
    }

    public function followers(Request $request)
    {
        $user = User::find($request->user_id);
        $followers = $user->followers()->paginate($request->per_page);
        return array("code" => 200, "msg" => "OK", "data" => $followers);
    }

    public function followings(Request $request)
    {
        $user = User::find($request->user_id);
        $followings = $user->followings()->paginate($request->per_page);;
        return array("code" => 200, "msg" => "OK", "data" => $followings);
    }

    public function isFollowing(Request $request)
    {
        $user = User::find($request->user_id);
        // $isFollowing = $user->followings()->get()->contains($request->is_following); or below
        $isFollowing = $user->followings->contains($request->is_following);
        return array("code" => 200, "msg" => "OK", "is_following" => $isFollowing);
    }
}
