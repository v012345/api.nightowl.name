<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifySignature
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
        $secret = env("PAY_SECRET");
        if ($request->sign == hash("sha256", $request->out_biz_no . $request->trans_amount . $request->payee_info["identity"] . $request->payee_info["name"] . $request->nonce . $secret)) {
            return $next($request);
        } else {
            return response("wrong signature", 400);
        }
    }
}
