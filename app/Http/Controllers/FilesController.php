<?php

namespace App\Http\Controllers;

use App\Events\GoogleAccessTokenExpired;
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
        $client->setAccessToken($accessToken);
        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                Redis::set("google_access_token", null);
                event(new GoogleAccessTokenExpired($client->createAuthUrl()));
                $this->google_drive = null;
            }
        }
        $this->google_drive = $client;
    }

    public function upload()
    {
    }
}
