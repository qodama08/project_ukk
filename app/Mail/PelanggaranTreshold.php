<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PelanggaranTreshold extends Mailable
{
    use Queueable, SerializesModels;

    public $siswa;
    public $totalPoin;

    /**
     * Create a new message instance.
     */
    public function __construct(User $siswa, int $totalPoin)
    {
        $this->siswa = $siswa;
        $this->totalPoin = $totalPoin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Peringatan: Poin Pelanggaran Mencapai Batas Maksimal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pelanggaran_threshold',
            with: [
                'siswa' => $this->siswa,
                'totalPoin' => $this->totalPoin,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
