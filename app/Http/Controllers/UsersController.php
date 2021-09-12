<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use stdClass;

class UsersController extends Controller
{
    //



    public function signup(Request $request)
    {
        // $session = new stdClass();
        // $user = new stdClass();
        // // $session = array("phone_number" => $request->phone_number, "verifying_code" => random_int(1000, 9999));
        // // $session = json_decode(json_encode($session));
        // $session->phone_number = $request->phone_number;

        // $session->updated_at = date("Y-m-d H:i:s", time());
        // $session->remember_me = false;

        $verifying_code = Redis::get($request->phone_number);
        // dd(gettype($verifying_code));
        if ($verifying_code && $verifying_code == $request->verifying_code) {
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
    public function update(Request $request)
    {
        $user = User::find($request->id);;
        $user->update($request->all());
        // $user->makeVisible('password');
        return array('code' => 200, 'msg' => 'Set profile successfully', 'user' => $user);
    }

    public function all(Request $request)
    {
        $data = User::paginate($request->per_page);
        return array("code" => 200, "msg" => "OK (from getAllUsers)", "data" => $data);
    }

    public function delete(Request $request)
    {
        $admin = User::find($request->id);
        if ($admin->admin) {
            User::destroy($request->delete_user_id);
            return array('code' => 200, 'msg' => 'User has been deleted (from delete)');
        }
        return array('code' => 400, 'msg' => 'Not an admin');
    }

    public function profile(Request $request)
    {
        $session = $request->session;
        $user = User::find($request->user->id);
        return  array('code' => 200, 'msg' => 'User profile', 'user' => $user, "session" => $session);
    }
}
