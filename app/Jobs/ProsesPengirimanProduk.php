<?php

namespace App\Jobs;

use App\Models\Transaksi;
use App\Mail\StrukPembelianMail;
use Illuminate\Bus\Queueable;
use App\Models\AsetProduk;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
        // 1. DETEKSI TIPE DARI NAMA ASET PERTAMA YANG DITEMUKAN
        $contohAset = \App\Models\AsetProduk::where('id_produk', $this->transaksi->id_produk)->first();
        $namaAset = strtolower($contohAset->nama_aset ?? '');

        $typeProduk = 'topup'; // Default
        if (Str::contains($namaAset, 'e-book') || Str::contains($namaAset, 'ebook')) {
            $typeProduk = 'ebook';
        } elseif (Str::contains($namaAset, 'akun')) {
            $typeProduk = 'akun';
        } elseif (Str::contains($namaAset, 'token')) {
            $typeProduk = 'token';
        }

        $sn_dummy = '';
        $file_path = null;
        $aset = null;

        // 2. LOGIKA PENCARIAN & LOCKING ASET
        if ($typeProduk === 'akun') {
            // Khusus Akun: Cari yang belum terjual dan Kunci
            $aset = \App\Models\AsetProduk::where('id_produk', $this->transaksi->id_produk)
                ->where('is_sold', 0)
                ->first();
            if ($aset) {
                $aset->is_sold = 1;
                $aset->save();
            }
        } else {
            // Ebook & Layanan Otomatis: Ambil data asetnya tanpa di-lock (Unlimited)
            $aset = $contohAset;
        }

        // 3. FULFILLMENT BERDASARKAN TIPE
        if ($typeProduk === 'akun') {
            if ($aset) {
                $sn_dummy = "Kredensial Akun: " . $aset->deskripsi;
            } else {
                $sn_dummy = "Status: Stok Habis - Akan Dikirim Setelah Restock.";
            }
        } elseif ($typeProduk === 'ebook') {
            if ($aset && $aset->link_file) {
                $file_path = $aset->link_file;
                $sn_dummy = "File E-Book telah dilampirkan pada email ini. Selamat membaca!";
            } else {
                $sn_dummy = "Status: File E-Book tidak ditemukan di server. Harap hubungi Admin.";
            }
        } elseif ($typeProduk === 'token') {
            $sn_dummy = sprintf("%04d-%04d-%04d-%04d-%04d", random_int(1000, 9999), random_int(1000, 9999), random_int(1000, 9999), random_int(1000, 9999), random_int(1000, 9999));
        } else {
            $idTarget = $this->transaksi->id_target;
            $sn_dummy = 'Target: ' . $idTarget . ' | SN: JST-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
        }

        // 4. KIRIM EMAIL (Kode pengiriman tetap sama seperti sebelumnya...)
        $emailTujuan = filter_var($this->transaksi->id_target, FILTER_VALIDATE_EMAIL)
            ? $this->transaksi->id_target
            : $this->transaksi->kontak_pelanggan;

        if (filter_var($emailTujuan, FILTER_VALIDATE_EMAIL)) {
            Mail::to($emailTujuan)->send(new StrukPembelianMail($this->transaksi, $sn_dummy, $file_path));
        } else {
            Log::info("Produk terkirim ke Nomor/Target: " . $emailTujuan . " dengan info: " . $sn_dummy);
        }
    }
}
