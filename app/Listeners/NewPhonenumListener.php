<?php

namespace App\Listeners;

use App\Events\NewPhonenumEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewPhonenumListener
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
     * @param  NewPhonenumEvent  $event
     * @return void
     */
    public function handle(NewPhonenumEvent $event)
    {
        // echo $event->getPhonenum();
    }
}
