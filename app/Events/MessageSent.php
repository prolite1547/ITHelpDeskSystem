<?php

namespace App\Events;

use App\Message;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $message;
    public $messageID;
    public $user;
    public $userID;
    public $ticketID;
    public $image;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message,User $user,$ticketID)
    {
        $this->message = $message->message;
        $this->messageID = $message->id;
        $this->user = $user->full_name;
        $this->userID = $user->id;
        $this->image = $user->profpic->image;
        $this->ticketID = $ticketID;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.' .$this->ticketID);
    }
}
