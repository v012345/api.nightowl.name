<?php

namespace App\Http\Controllers;

use App\Events\Paid;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    //
    public function notify4sUser(Request $request)
    {
        Paid::dispatch($request->user_id);
    }
}
