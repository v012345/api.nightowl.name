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
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
        ]);
        return array('code' => 200, 'status' => 'OK', 'user' => $user);
    }
}

