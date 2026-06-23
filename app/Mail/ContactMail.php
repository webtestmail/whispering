<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;  // Public property for array access in view

    public function __construct(array $data)
    {
        $this->data = $data;  // Store entire array as public property
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Form: ' . ($this->data['subject'] ?? 'New Message'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}