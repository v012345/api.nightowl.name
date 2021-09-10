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
            return response(array("code" => 400, "msg" => "Miss token",));
        }
        // dd(gettype($user));
        // $user["login"] = true;
        // $request->decrypted = true;
        try {
            $user = Crypt::decrypt($request->token);
        } catch (DecryptException $e) {
            return response(array("code" => 400, "msg" => $e->getMessage()));
        }

        $minutes = (new Carbon())->diffInMinutes(Carbon::parse($user->updated_at));

        if ($minutes > 240) {
            return response(array("code" => 400, "msg" => "Token expired"));
        }
        if ($minutes > 120) {
            $user = User::find($user->id);
            $user->touch();
        }
        // dd($minutes);
        $request->merge(['user' => $user]);
        return $next($request);
    }
}
