<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ValidateUserInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (isset($request->user->id))
            if (User::find($request->user->id))
                return $next($request);
        return response(array("code" => 400, "msg" => "Invalid user (from ValidateUserInfo)"));
    }
}
