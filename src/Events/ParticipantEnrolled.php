<?php

namespace jobvink\lumc\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use jobvink\lumc\Contracts\Addressable;

class ParticipantEnrolled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Addressable $person;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Addressable $person)
    {
        $this->person = $person;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('registration');
    }
}
