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

    public function __construct(
        public string $numeClient,
        public string $emailClient,
        public string $telefonClient,
        public string $mesajClient,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cerere servicii contabilitate de la ' . $this->numeClient,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }
}