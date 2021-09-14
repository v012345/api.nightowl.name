<?php

namespace App\Listeners;

use App\Events\Verify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVerificationCode
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
     * @param  Verify  $event
     * @return void
     */
    public function handle(Verify $event)
    {
        //
        dd(1);
    }
}
