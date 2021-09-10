<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function signup(Request $request)
    {
        try {
            $user = User::create($request->all());
        } catch (Exception $e) {
            return array('code' => 400, 'msg' => $e->getMessage(), 'user' => $request->all());
        }
        return array('code' => 200, 'msg' => 'Signup successfully', 'user' => $user);
    }

    public function login(Request $request)
    {
        $user = (User::where(["phone_number" => $request->phone_number, "password" => $request->password])->get())->first();
        if ($user) {
            return array('code' => 200, 'msg' => 'Signup successfully', 'user' => $user);
        }
        return array('code' => 400, 'msg' => 'Account doesn\'t match password');
    }

    public function logout(Request $request)
    {
    }

    public function profile(Request $request)
    {
        return  array('code' => 200, 'msg' => 'User profile', 'user' => $request->user);
    }

    public function setProfile(Request $request)
    {
        $user = User::find($request->user->id);
        $user->update($request->all());
        // $user->makeVisible('password');
        // $user->update(['name'=>"aifeihgii"]);
        return array('code' => 200, 'msg' => 'OK', 'user' => $user);
    }
    public function orders(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            return  array('code' => 404, 'msg' => 'User doesn\'t exist');
        } else {
            return $user->orders();
        }
    }
}
