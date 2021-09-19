<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CaptchaRequest;
use Carbon\Carbon;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CaptchasController extends Controller
{
    //
    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $captcha_key = 'captcha-' . Str::random(15);
        $captcha = $captchaBuilder->build();
        $expiredAt = Carbon::now()->addMinutes(2);
        Cache::put($captcha_key, ["phone_number" => $request->phone_number, "captcha_value" => $captcha->getPhrase()], $expiredAt);
        return response(["captcha_key" => $captcha_key, "expired_at" => $expiredAt->format("Y-m-d H:i:s"), "captcha_image_content" => $captcha->inline()], 201);
    }
}
