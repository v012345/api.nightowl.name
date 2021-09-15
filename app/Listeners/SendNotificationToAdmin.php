<?php

namespace App\Listeners;

use App\Events\GoogleAccessTokenExpired;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class SendNotificationToAdmin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GoogleAccessTokenExpired  $event
     * @return void
     */
    public function handle(GoogleAccessTokenExpired $event)
    {
        //
        if (!Redis::get("hasSendUpdateGoogleAccessTokenNotification")) {
            Mail::send('email.toAdmin', ["data" => $event->URL], function ($message) {
                $message->to('v138468@gmail.com')->subject("Update Google Access Token");
            });
            Redis::setex("hasSendUpdateGoogleAccessTokenNotification", 1800, true);
        }
    }
}
