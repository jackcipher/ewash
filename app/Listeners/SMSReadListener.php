<?php

namespace App\Listeners;

use App\Events\SMSReadEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SMSReadListener
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
     * @param  SMSReadEvent  $event
     * @return void
     */
    public function handle(SMSReadEvent $event)
    {
        //
    }
}
