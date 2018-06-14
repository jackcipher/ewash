<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Account;

class RegOk
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $phonenum;
    protected $passwd;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($phonenum, $passwd)
    {
        $this->phonenum = $phonenum;
        $this->passwd = $passwd;
    }

    function writeDb() {
        $account = new Account;
        $account->phonenum = $this->phonenum;
        $account->passwd = $this->passwd;
        $account->save();

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
