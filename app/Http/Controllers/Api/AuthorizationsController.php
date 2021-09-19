<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorizationsController extends Controller
{
    //
    public function socialStore(Request $request)
    {
        return $request->all();
    }
}
