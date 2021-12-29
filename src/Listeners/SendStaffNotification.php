<?php

namespace jobvink\lumc\Listeners;

use Illuminate\Support\Facades\Mail;
use jobvink\lumc\Events\ParticipantEnrolled;
use jobvink\lumc\Mail\Registartion;

class SendStaffNotification
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

        Mail::to([env('LUMC_MAIL'), env('GPRI_MAIL')])
            ->send(new Registartion($participant));
    }
}
