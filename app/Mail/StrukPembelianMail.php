<?php

namespace App\Mail;

use App\Models\Transaksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class StrukPembelianMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaksi;
    public $sn_dummy;
    public $file_path;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaksi $transaksi, $sn_dummy, $file_path = null)
    {
        $this->transaksi = $transaksi;
        $this->sn_dummy = $sn_dummy;
        $this->file_path = $file_path;
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
        // 1. Pastikan path tidak kosong
        if ($this->file_path) {

            // 2. Ambil rute fisik absolut dari dalam hardisk server (Docker/Sail)
            $lokasiFisik = storage_path('app/public/' . $this->file_path);

            // 3. Paksa tempel file, beri nama otomatis yang rapi, dan set format ke PDF
            return [
                Attachment::fromPath($lokasiFisik)
                    ->as('E-Book-' . Str::slug($this->transaksi->produk->nama_produk) . '.pdf')
                    ->withMime('application/pdf')
            ];
        }

        return [];
    }
}
