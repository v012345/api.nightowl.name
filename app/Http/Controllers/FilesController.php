<?php

namespace App\Http\Controllers;

use App\Events\GoogleAccessTokenExpired;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use InvalidArgumentException;

class FilesController extends Controller
{
    //
    public $google_drive;

    public function __construct()
    {
        $client = new Google_Client(config("google"));
        $accessToken = json_decode(Redis::get("google_access_token"), true);

        try {
            $client->setAccessToken(json_decode($accessToken, true));
        } catch (InvalidArgumentException $e) {
            event(new GoogleAccessTokenExpired($client->createAuthUrl()));
            $this->google_drive = null;
            return;
        }

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                event(new GoogleAccessTokenExpired($client->createAuthUrl()));
                $this->google_drive = null;
                return;
            }
        }
        $this->google_drive = $client;
    }

    public function uploadAvatar(Request $request)
    {
        dump($this->google_drive);
    }
}
