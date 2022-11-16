<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserRegistration extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $fullName;
    public $qrCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $fullName)
    {
        $this->email = $email;
        $this->fullName = $fullName;
    }

    /**
     * Build the email.
     *
     * @return
     */
    public function build()
    {
        return $this
            ->subject('Thank you for registering to aGala')
            ->markdown('emails.userRegistration');
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'User Registration',
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
            markdown: 'emails.userRegistration',
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
