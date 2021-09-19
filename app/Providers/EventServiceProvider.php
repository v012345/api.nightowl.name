<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\Verify;
use App\Events\GoogleAccessTokenExpired;
use App\Listeners\SendVerificationCode;
use App\Listeners\SendNotificationToAdmin;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        // Event::listen(
        //     PodcastProcessed::class,
        //     [SendPodcastNotification::class, 'handle']
        // );

        // Event::listen(function (PodcastProcessed $event) {
        //     //
        // });
    }
}
