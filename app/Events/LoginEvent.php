<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    protected $user;
    protected $agent;
    protected $ip;
    protected $timestamp;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $agent, $ip, $timestamp)
    {
        $this->user = $user;
        $this->agent = $agent;
        $this->ip = $ip;
        $this->timestamp = $timestamp;
        //
    }

    function getUser() {
        return $this->user;
    }

    function getAgent() {
        return $this->agent;
    }

    function getIp() {
        return $this->ip;
    }

    function getTimestamp() {
        return $this->timestamp;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-default');
    }
}
