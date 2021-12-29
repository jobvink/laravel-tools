<?php

namespace jobvink\tools\Listeners;

use Illuminate\Support\Facades\Mail;
use jobvink\tools\Events\ParticipantEnrolled;
use jobvink\tools\Mail\Confirmation;

class SendParticipantNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle(ParticipantEnrolled $event)
    {
        $participant = $event->participant;

        Mail::to($participant->email)
            ->send(new Confirmation($participant));
    }
}
