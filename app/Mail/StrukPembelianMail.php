<?php

namespace App\Mail;

use App\Models\Transaksi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StrukPembelianMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaksi;
    public $sn_dummy;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaksi $transaksi, $sn_dummy)
    {
        $this->transaksi = $transaksi;
        $this->sn_dummy = $sn_dummy;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Struk Pembelian J-Store: ' . $this->transaksi->produk->nama_produk,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Email akan me-render file blade di resources/views/emails/struk.blade.php
        return new Content(
            view: 'emails.struk', 
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        // Nanti kita bisa menambahkan logika file E-book di sini
        return [];
    }
}