<?php

namespace App\Mail;

use App\Models\Obra;
use App\Models\Remision;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RemisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Remision $remision,
        public Obra $obra,
        public string $pdfContent,
        public string $filename,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Remisión {$this->remision->nro} — {$this->obra->nombre}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.remision',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => $this->pdfContent,
                $this->filename
            )->withMime('application/pdf'),
        ];
    }
}
