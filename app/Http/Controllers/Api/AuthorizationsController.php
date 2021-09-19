<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelSocialite\Socialite;

class AuthorizationsController extends Controller
{
    //
    public function store(AuthorizationRequest $request)
    {
        $username = $request->username;
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $credentials["email"] = $username;
        } elseif (preg_match('/[^0-9]+/', $username)) {
            $credentials["account"] = $username;
        } else {
            $credentials["phone_number"] = $username;
        }
        $credentials['password'] = $request->password;
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response(array(["wrong password"]), 403);
        }

        return $this->respondWithToken($token)->setStatusCode(201);
    }
    public function socialStore(SocialAuthorizationRequest $request, $social_type)
    {
        $driver = Socialite::create($social_type);
        try {
            if ($code = $request->code) {
                $oauthUser = $driver->userFromCode($code);
            } else {
                if ($social_type == "wechat") {
                    $driver->withOpenid($request->openid);
                }
                $oauthUser = $driver->userFromToken($request->access_token);
            }
        } catch (Exception $e) {
            return $e->getMessage();
            //throw $th;
        }
        if (!$oauthUser->getId()) {
            return ['参数错误，未获取用户信息'];
        }
        switch ($social_type) {
            case 'wechat':
                $unionid = $oauthUser->getRaw()['unionid'] ?? null;
                if ($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser->getId())->first();
                }
                if (!$user) {
                    $user = User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }
                break;
            case 'wechat':
                break;
        }

        $token = Auth::guard('api')->login($user);
        return $this->respondWithToken($token)->setStatusCode(201);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
