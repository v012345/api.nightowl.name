<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use stdClass;

class UsersController extends Controller
{
    //
    public function verify(Request $request)
    {
        $session = new stdClass();
        $user = new stdClass();
        // $session = array("phone_number" => $request->phone_number, "verifying_code" => random_int(1000, 9999));
        // $session = json_decode(json_encode($session));
        $session->phone_number = $request->phone_number;
        // $session->verifying_code =  random_int(1000, 9999);
        $session->verifying_code =  1111;
        $session->updated_at = date("Y-m-d H:i:s", time());
        $session->remember_me = false;

        return array('code' => 200, 'msg' => 'Has sent sms', 'user' => $user, 'session' => $session);
    }
    public function signup(Request $request)
    {
        try {
            $session = $request->session;
            $session->remember_me = $request->remember_me;
            if ($request->verifying_code == $session->verifying_code) {
                $user = User::create($request->all());
            } else {
                return array('code' => 400, 'msg' => "Wrong verifying code (from signup)",);
            }
        } catch (Exception $e) {
            return array('code' => 400, 'msg' => $e->getMessage() . " (from signup)",);
        }
        return array('code' => 200, 'msg' => 'Sign up successfully (from signup)', 'user' => $user, "session" => $session);
    }

    public function login(Request $request)
    {
        $session = new stdClass();
        $session->updated_at = date("Y-m-d H:i:s", time());
        $session->remember_me = $request->remember_me;
        $user = (User::where(["phone_number" => $request->phone_number, "password" => $request->password])->get())->first();
        if ($user) {
            return array('code' => 200, 'msg' => 'Signup successfully (from login)', 'user' => $user, 'session' => $session);
        }
        return array('code' => 400, 'msg' => 'Account doesn\'t match password (from login)');
    }

    public function logout(Request $request)
    {
        return array('code' => 200, 'msg' => 'User log out (from logout)');
    }

    public function delete(Request $request)
    {
        User::destroy($request->user->id);
        return array('code' => 200, 'msg' => 'User has been deleted (from delete)');
    }

    public function profile(Request $request)
    {
        $session = $request->session;
        $user = User::find($request->user->id);
        return  array('code' => 200, 'msg' => 'User profile', 'user' => $user, "session" => $session);
    }

    public function setProfile(Request $request)
    {
        $session = $request->session;
        $user = User::find($request->user->id);
        $user->update($request->all());
        // $user->makeVisible('password');
        // $user->update(['name'=>"aifeihgii"]);
        return array('code' => 200, 'msg' => 'Set profile successfully', 'user' => $user, "session" => $session);
    }
    public function orders(Request $request)
    {
        $session = $request->session;
        $user = User::find($request->user->id);
        if (!$user) {
            return  array('code' => 404, 'msg' => 'User doesn\'t exist');
        } else {
            return array('code' => 200, 'msg' => $user->orders(), 'user' => $user, "session" => $session);
        }
    }

    public function getAllUsers(Request $request)
    {
        //http://api.localhost/api/vue3learning/v1/get/users?page=2
        $data = User::paginate(intval($request->per_page));
        return array("code" => 200, "msg" => "OK (from getAllUsers)", "data" => $data);
    }
}
