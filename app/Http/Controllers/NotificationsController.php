<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware("FormatPaginatedResults", ["only" => ["read"]]);
    }
    public function read(Request $request)
    {
        // dd(User::find($request->user_id)->notifications());
        $user =  User::find($request->user_id);
        $notifications = $user->notifications()->paginate($request->per_page);
        $user->notification_count = 0;
        $user->unreadNotifications->markAsRead();
        $user->save();
        return array("code" => 200, "msg" => "Nofitications read", "data" => $notifications);
    }
}
