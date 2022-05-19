<?php

namespace jobvink\tools\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use jobvink\tools\Contracts\Addressable;

class Confirmation extends Mailable
{
    use Queueable, SerializesModels;
    private Mailable $mailable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Addressable $person)
    {
        $this->person = $person;
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
            'address' => env('LUMC_MAIL'),
        ]);

        $this->subject(env(''));

        return $this->view('tools::mail/email', [
            'title' => 'Perfect fit registratie',
            'person' => $this->person,
        ]);
    }
}
