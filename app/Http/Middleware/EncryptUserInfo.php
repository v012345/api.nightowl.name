<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class EncryptUserInfo
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
        $response = $next($request);

        // dd($response);
        try {
            $data = $response->getData();
            if ($data->code == 200) {
                $data->token = Crypt::encrypt($data->user);
                $response->setData($data);
            }
        } catch (Exception $e) {
            return response(array("code" => 400, "msg" => $e->getMessage()));
        }

        // dd(gettype($response->getContent()));
        // $response->setContent("ieee");
        // dd(gettype($response->getOriginalContent()));
        return $response;
    }
}
