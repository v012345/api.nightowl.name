<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyToken
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
        dump("verify token");
        return $next($request);
    }
}