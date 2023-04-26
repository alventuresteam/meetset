<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendReservation extends Mailable
{
    use Queueable, SerializesModels;

    private $ics;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ics)
    {
        $this->ics = $ics;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Reservation',
        );
    }

    public function content()
    {
        return view('empty');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [
          Attachment::fromData($this->ics->data,$this->ics->name)
        ];
    }
}
