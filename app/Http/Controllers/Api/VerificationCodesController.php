<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Illuminate\Support\Str;

class VerificationCodesController extends Controller
{
    //
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {


        $captchaData = Cache::get($request->captcha_key);
        if (!$captchaData) {
            // abort(403, "Verification code has expired");
            return response(["message" => "Captcha has expired"], 403);
        }

        if (!hash_equals($captchaData["captcha_value"], $request->captcha_value)) {
            // throw new AuthenticationException("Verification code is wrong");
            Cache::forget($request->captcha_key);
            return response(["message" => "Captcha value is wrong"], 403);
        }

        $phone_number = $captchaData["phone_number"];
        Cache::forget($request->captcha_key);

        if (app()->environment("production")) {
            $verification_code = "1234";
        } else {
            $verification_code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
            try {
                $result = $easySms->send($phone_number, [
                    'template' => config("easysms.gateways.aliyun.templates.verification_code"),
                    "data" => ["code" => $verification_code]
                ]);
            } catch (NoGatewayAvailableException $e) {
                $message = $e->getException('aliyun')->getMessage();
                return ["errors" => [$message]];
                // return $message;
                // abort(500, $message ?: '短信发送异常');
            }
        }

        $verification_key = 'verificationCode_' . Str::random(20);
        $expiredAt = Carbon::now()->addMinutes(5);
        Cache::put($verification_key, ["phone_number" => $phone_number, "verification_code" => $verification_code], $expiredAt);
        return response(["verification_key" => $verification_key, "expired_at" => $expiredAt->format("Y-m-d H:i:s")], 201);
    }
}
