<?php

namespace App\Http\Controllers;

use App\Events\Paid;
use App\Events\Used;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    //
    public function notify4sUserPaid(Request $request)
    {
        Paid::dispatch($request->user_id);
    }
    public function notify4sUserUsed(Request $request)
    {
        Used::dispatch($request->user_id);
    }
}
