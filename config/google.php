<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google drive oauth2 config
    |--------------------------------------------------------------------------
    |
    | Fucking Google, it is so so ......
    |
    */
    "application_name" => "NightOwl File System",
    "client_id" => env("CLIENT_ID"),
    "client_secret" => env("CLIENT_SECRET"),
    "scopes" => "https://www.googleapis.com/auth/drive",
    "access_type" => "offline",
    "prompt" => 'select_account consent',
    "redirect_uri" => "https://api.nightowl.name/api",
];
