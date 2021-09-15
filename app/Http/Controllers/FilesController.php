<?php

namespace App\Http\Controllers;

use App\Events\GoogleAccessTokenExpired;
use Exception;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google_Client;
use Google_Service;
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
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } elseif ($authCode = Redis::get("google_auth_code")) {
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);
                if (array_key_exists('error', $accessToken)) {
                    event(new GoogleAccessTokenExpired("Can't get access token"));
                    $this->google_drive = null;
                    return;
                }
                Redis::set("google_access_token", json_encode($client->getAccessToken()));
            } else {
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
        $this->google_drive = null;
    }

    public function uploadAvatar(Request $request)
    {
        // dd($request->avatar);
        // dd($request->avatar->getClientOriginalName());
        $service = new Drive($this->google_drive);
        $file  = new DriveFile();

        $files = $service->files->listFiles(array(
            'q' => "'root' in parents",
            'fields' => 'nextPageToken, files(id, name, webViewLink, mimeType,webContentLink)'
        ))->getFiles();

        dd($files);

        $file->setName($request->avatar->getClientOriginalName());
        $file->setParents(["1F-QQaHZZGN_1LnZn3Iuaurt32xCYuUit"]);
        $file->setMimeType($request->avatar->getClientMimeType());

        $result = $service->files->create($file, ['data' => file_get_contents($request->avatar->getPathname())]);
        dump($file->getWebViewLink());
        dd($result->getWebViewLink());
        $file->setMimeType("application/octet-stream");

        $service->files->create($file);
        dd($file->getWebViewLink());

        $parameters['q'] = "mimeType='application/vnd.google-apps.folder'   and trashed=false";
        $files = $service->files->listFiles($parameters);
        dd($files);

        $file->getWebViewLink();
        dd($file);
        $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false";
        $files = $service->files->listFiles();
        dd($files);
        $file->setName("/abc/abc/acb/");
        $file->setMimeType("application/vnd.google-apps.folder");
        // $files->setId
        $result = $service->files->create(
            $file
        );
        dd($result);

        dd($result);
        $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false";
        $files = $service->files->listFiles($parameters);
        dd($files);

        $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and name='ffff' and trashed=false";
        $files = $service->files->listFiles($parameters);
        $folder = new DriveFile();
        $folder->setName("aaaaaa");
        $folder->setMimeType('application/vnd.google-apps.folder');
        $result = $service->files->create($folder);
        $folder_id = $result['id'];
    }
}
