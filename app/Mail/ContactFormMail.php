<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * We pass the valid data array directly here.
     */
    public function __construct(
        public array $data,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [
                new Address($this->data['sender_email'], $this->data['sender_name']),
            ],
            subject: 'Contact form submission: ' . $this->data['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'contact.mail',
            // The public $data property is automatically available in the view
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
