<?php

namespace jobvink\tools\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use jobvink\tools\Contracts\Addressable;

class Registartion extends Mailable
{
    use Queueable, SerializesModels;
    private Addressable $participant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Addressable $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->subject('Acceptance nieuwe aanmelding');

        return $this->view('tools::mail/registration', [
            'title' => '',
            'preheader' => 'Er is een nieuwe registartie voor het acceptance-onderzoek',
            'site' => '',
            'person' => $this->participant
        ]);
    }
}
