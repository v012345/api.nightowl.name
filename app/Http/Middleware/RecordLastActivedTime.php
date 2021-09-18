<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RecordLastActivedTime
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

        if ($request->user_id) {
            $hash = 'nightowl_active_users_at_' . Carbon::now()->toDateString();
            Redis::hSet($hash, $request->user_id, Carbon::now()->format("Y-m-d H:i:s"));
        }
        return $next($request);
    }
}
