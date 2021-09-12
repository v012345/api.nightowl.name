<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use stdClass;

class GenerateToken
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
        // try {
        //     $data = $response->getData();
        //     if ($data->code == 200) {

        //         $token = new stdClass();
        //         // if()
        //         $user->id = $data->user->id ?? null;
        //         $token->user = $user;
        //         $token->session = $data->session;
        //         $token->session->version = getenv("APP_VERSION");
        //         unset($data->session);
        //         $data->token = Crypt::encrypt($token);
        //         $response->setData($data);
        //     }
        // } catch (Exception $e) {
        //     return response(array("code" => 400, "msg" => $e->getMessage() . " (from EncryptUserInfo)"));
        // }

        // dd(gettype($response->getContent()));
        // $response->setContent("ieee");
        // dd(gettype($response->getOriginalContent()));
        dump("generate token");
        return $response;
    }
}
