<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function signup(Request $request)
    {
        // return date('D d M Y H:i:s', time());
        // $this->validate($request, [
        //     'name' => 'required|unique:users|max:50',
        //     'phone_number' => 'required|unique:users|max:255',
        //     'password' => 'required|confirmed|min:6'
        // ]);
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
        ]);
        return array('code' => 200, 'msg' => 'Signup successfully', 'user' => $user);
    }

    public function profile(Request $request)
    {
        // return gettype($request->id);
        $user = User::find($request->id);
        if ($user) {
            return  array('code' => 200, 'msg' => 'OK', 'user' => $user);
        } else {
            return  array('code' => 404, 'msg' => 'User doesn\'t exist');
        }
    }

    public function profileSet(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            return  array('code' => 404, 'msg' => 'User doesn\'t exist');
        } else {
            $user->name = $request->name;
            $user->save();
            // dd( $user);

            // $user->makeVisible('password');
            // $user->update(['name'=>"aifeihgii"]);
            return array('code' => 200, 'msg' => 'OK', 'user' => $user);
        }
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
