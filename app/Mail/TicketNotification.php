<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $subjectMsg;
    public $msg;
    public $price;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registration, $subject, $msg)
    {
        $this->data = $registration;
        $this->subjectMsg = $subject;
        $this->msg = $msg;
        $this->price = 500;
    }

    /**
     * Build the email.
     *
     * @return
     */
    public function build()
    {
        return $this
            ->subject($this->subjectMsg)
            ->markdown('emails.ticketNotification');
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Ticket Notification',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.ticketNotification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
