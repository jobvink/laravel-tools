<?php

namespace jobvink\lumc\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Confirmation extends Mailable
{
    use Queueable, SerializesModels;
    private Mailable $mailable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Mailable $mailable)
    {
        $this->mailable = $mailable;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): Confirmation
    {
        $this->from([
            'address' => env('MAIL_FROM_ADDRESS'),
        ])->replyTo([
            'address' => env('MAIL_FROM_ADDRESS'),
        ]);

        $this->subject('Acceptance bevestiging');

        return $this->view('lumc::mail/email', [
            'mailable' => $this->mailable,
            'content' => '',
        ])->attach(public_path() . '/documenten/Informatie deelname ACCEPTANCE onderzoek (v8.0).pdf');
    }
}
