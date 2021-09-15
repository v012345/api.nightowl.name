<?php

namespace App\Http\Controllers;

use App\Events\GoogleAccessTokenExpired;
use Exception;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class FilesController extends Controller
{
    //
    public $google_drive;

    public function __construct()
    {
        $client = new Google_Client(config("google"));
        $accessToken = json_decode(Redis::get("google_access_token"), true);
        try {
            $client->setAccessToken($accessToken);
        } catch (Exception $e) {
        }


        if ($client->isAccessTokenExpired()) {
            dump(1);
            if ($client->getRefreshToken()) {
                dump(2);
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } elseif ($authCode = Redis::get("google_auth_code")) {
                dump(3);
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);
                if (array_key_exists('error', $accessToken)) {
                    dump(4);
                    event(new GoogleAccessTokenExpired("Can't get access token"));
                    $this->google_drive = null;
                    return;
                }
                Redis::set("google_access_token", json_encode($client->getAccessToken()));
            } else {
                dump(5);
                event(new GoogleAccessTokenExpired($client->createAuthUrl()));
                $this->google_drive = null;
                return;
            }
            $this->google_drive = $client;
            return;
        } else {
            $this->google_drive = $client;
            return;
        }
        dump(6);
        $this->google_drive = null;
    }

    public function uploadAvatar(Request $request)
    {
        dump($this->google_drive);
    }
}
