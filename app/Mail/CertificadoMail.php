<?php

namespace App\Mail;

use App\Models\Certificado;
use App\Models\Obra;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Certificado $certificado,
        public Obra $obra,
        public int $nroCertificado,
        public string $pdfContent,
        public string $filename,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Certificado #{$this->nroCertificado} — {$this->obra->nombre}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificado',
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
