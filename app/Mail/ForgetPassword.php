<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgetPassword extends Mailable
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
            subject: 'Forgot Your Password?'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.forgetpassword',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}