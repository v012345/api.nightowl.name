<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class SlugTranslateHandler
{
    public function translate($text)
    {
        $http = new Client();
        // $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate';
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        // dump($appid, $key);
        $salt = time();
        $sign = md5($appid . $text . $salt . $key);
        // $query = http_build_query([
        //     "q"     =>  $text,
        //     "from"  => "zh",
        //     "to"    => "en",
        //     "appid" => $appid,
        //     "salt"  => $salt,
        //     "sign"  => $sign,
        // ]);
        // dd($query);

        // 发送 HTTP Get 请求
        // $response = $http->get($api . $query);

        // $result = json_decode($response->getBody(), true);
        $response = $http->get(
            $api,
            [
                "query" => [
                    "q" => $text,
                    "from" => "zh",
                    "to" => "en",
                    "appid" => $appid,
                    "salt" => $salt,
                    "sign" => $sign
                ]
            ]
        );
        // dd($response->getBody());
        $result = json_decode($response->getBody(), true);
        if (isset($result['trans_result'][0]['dst'])) {
            return Str::slug($result['trans_result'][0]['dst']);
        } else {
            return "no-slug";
        }
    }
}
