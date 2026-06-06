<?php

namespace App\Jobs;

use App\Models\Transaksi;
use App\Mail\StrukPembelianMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProsesPengirimanProduk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaksi;

    /**
     * Create a new job instance.
     */
    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 1. Dapatkan nama produk dalam format huruf kecil untuk mendeteksi tipe produk
        $namaProduk = strtolower($this->transaksi->produk->nama_produk ?? '');
        $sn_dummy = '';

        // 2. Logika Pembuatan Kode Dummy berdasarkan nama produk
        if (Str::contains($namaProduk, 'token') || Str::contains($namaProduk, 'pln')) {
            // Format Token PLN: 20 Digit Angka (Contoh: 1234-5678-9012-3456-7890)
            $sn_dummy = sprintf("%04d-%04d-%04d-%04d-%04d", random_int(1000, 9999), random_int(1000, 9999), random_int(1000, 9999), random_int(1000, 9999), random_int(1000, 9999));
        
        } elseif (Str::contains($namaProduk, 'premium') || Str::contains($namaProduk, 'netflix') || Str::contains($namaProduk, 'spotify')) {
            // Format Akun Premium: Email & Password
            $sn_dummy = "Email: user".random_int(100,999)."@premium.com | Pass: JStore".Str::random(5);
        
        } elseif (Str::contains($namaProduk, 'book') || Str::contains($namaProduk, 'e-book')) {
            // Format E-book: Link Download (Dummy)
            $sn_dummy = "Link Akses: https://j-store.com/download/".Str::random(10);
            
        } else {
            // Default (Pulsa/Game): Format Serial Number PPOB
            $sn_dummy = 'SN: JST-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
        }

        // 3. Tentukan Email Tujuan
        // Cek apakah id_target adalah email (karena form E-book menggunakan email di id_target)
        // Jika bukan, gunakan kontak_pelanggan
        $emailTujuan = filter_var($this->transaksi->id_target, FILTER_VALIDATE_EMAIL) 
                        ? $this->transaksi->id_target 
                        : $this->transaksi->kontak_pelanggan;

        // Validasi terakhir untuk memastikan ada format email yang valid sebelum mengirim
        if (filter_var($emailTujuan, FILTER_VALIDATE_EMAIL)) {
            // 4. Kirim Email (Akan otomatis masuk ke Mailtrap)
            Mail::to($emailTujuan)->send(new StrukPembelianMail($this->transaksi, $sn_dummy));
        } else {
            // Opsional: Jika nomor HP, log saja karena ini proyek sekolah (tanpa API WA asli)
            \Illuminate\Support\Facades\Log::info("Produk terkirim ke Nomor/Target: " . $emailTujuan . " dengan SN: " . $sn_dummy);
        }
    }
}