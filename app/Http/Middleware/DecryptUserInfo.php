<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;

class DecryptUserInfo
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
        // $user = $request->user;
        if (!$request->token) {
            return response(array("code" => 400, "msg" => "Miss token (from DecryptUserInfo)",));
        }
        // dd(gettype($user));
        // $user["login"] = true;
        // $request->decrypted = true;
        try {
            $token = Crypt::decrypt($request->token);
        } catch (DecryptException $e) {
            return response(array("code" => 400, "msg" => $e->getMessage() . " (from DecryptUserInfo)"));
        }

        if ($token->session->version != getenv("APP_VERSION")) {
            return response(array("code" => 400, "msg" => "Low app version (from DecryptUserInfo)"));
        }

        if ($token->session->remember_me) {
            $lifeTime = 43200;
        } else {
            $lifeTime = 120;
        }

        $minutes = (new Carbon())->diffInMinutes(Carbon::parse($token->session->updated_at));

        if ($minutes > $lifeTime) {
            return response(array("code" => 400, "msg" => "Token expired (from DecryptUserInfo)"));
        }
        // if ($minutes > 120) {
        //     $user = User::find($user->id);
        //     $user->touch();
        // }
        $token->session->updated_at = date("Y-m-d H:i:s", time());
        $request->merge(['user' => $token->user]);
        $request->merge(['session' => $token->session]);
        return $next($request);
    }
}
