<?php

namespace App\Listeners;

use App\Events\RegOk;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegOkListener
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
     * @param  RegOk  $event
     * @return void
     */
    public function handle(RegOk $event)
    {
        $event->writeDb();
    }
}
