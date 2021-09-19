<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Overtrue\LaravelSocialite\Socialite;

class AuthorizationsController extends Controller
{
    //
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

        return $user;
    }
}
