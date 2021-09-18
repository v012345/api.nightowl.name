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
        $phone_number = $request->phone_number;
        if (!app()->environment("production")) {
            $code = "1234";
        } else {
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            try {
                $result = $easySms->send($phone_number, [
                    'template' => config("easysms.gateways.aliyun.templates.verification_code"),
                    "data" => ["code" => $code]
                ]);
            } catch (NoGatewayAvailableException $e) {
                $message = $e->getException('aliyun')->getMessage();
                abort(500, $message ?: '短信发送异常');
            }
        }

        $key = 'verificationCode_' . Str::random(20);
        $expiredAt = Carbon::now()->addMinutes(5);
        Cache::put($key, ["phone_number" => $phone_number, "code" => $code], $expiredAt);
        return response(["key" => $key, "expired_at" => $expiredAt->format("Y-m-d H:i:s")], 201);
    }
}
