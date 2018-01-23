<?php

namespace Xzxzyzyz\ConohaAPI\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Xzxzyzyz\ConohaAPI\Entities\Email;

class EmailDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Xzxzyzyz\ConohaAPI\Entities\Email
     */
    public $email;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }
}
