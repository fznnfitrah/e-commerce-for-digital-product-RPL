<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\AsetProduk;
use Midtrans\Config;
use Midtrans\Snap;
use App\Jobs\ProsesPengirimanProduk;

class TransaksiController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans dari file config/midtrans.php
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function cekPromo(Request $request)
    {
        $request->validate([
            'kode_promo' => 'required|string',
            'total_pembelian' => 'required|numeric'
        ]);

        $promo = Promo::where('kode_promo', $request->kode_promo)->first();

        if (!$promo) {
            return response()->json(['status' => 'error', 'message' => 'Kode promo tidak valid atau tidak ditemukan.']);
        }

        if ($promo->batasan_user <= 0) {
            return response()->json(['status' => 'error', 'message' => 'Mohon maaf, kuota promo ini sudah habis.']);
        }

        if ($request->total_pembelian < $promo->transaksi_min) {
            return response()->json(['status' => 'error', 'message' => 'Minimal belanja untuk promo ini adalah Rp ' . number_format($promo->transaksi_min, 0, ',', '.')]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Promo berhasil digunakan!',
            'potongan_harga' => $promo->potongan_harga,
            'id_promo' => $promo->id_promo
        ]);
    }

    public function checkout(Request $request)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'id_produk'         => 'required|exists:produks,id_produk',
            'id_target'         => 'required|string|min:3',
            'kontak_pelanggan'  => 'nullable|string',
            'metode_pembayaran' => 'required|string',
            'kode_promo'        => 'nullable|string' // TAMBAHAN: Validasi input hidden kode promo
        ], [
            'id_target.required'         => 'Email / ID Target wajib diisi.',
            'metode_pembayaran.required' => 'Silakan pilih metode pembayaran terlebih dahulu.'
        ]);

        $produk = Produk::findOrFail($request->id_produk);

        // Tentukan harga dasar
        $hargaDasar = $produk->harga_jual ?? $produk->harga_produk;

        // 2. CEK STOK (HANYA UNTUK TIPE AKUN)
        $contohAset = AsetProduk::where('id_produk', $produk->id_produk)->first();
        $isAkun = $contohAset && Str::contains(strtolower($contohAset->nama_aset), 'akun');

        if ($isAkun) {
            $stokTersedia = AsetProduk::where('id_produk', $produk->id_produk)
                ->where('is_sold', 0)
                ->count();

            if ($stokTersedia < 1) {
                return back()->withInput()->withErrors([
                    'id_produk' => 'Mohon maaf, stok akun untuk produk "' . $produk->nama_produk . '" saat ini sedang kosong.'
                ]);
            }
        }

        // 3. LOGIKA KALKULASI PROMO & DISKON
        $diskon = 0;
        $idPromo = null;

        if ($request->filled('kode_promo')) {
            // Cari promo berdasarkan kode
            $promo = Promo::where('kode_promo', $request->kode_promo)->first();

            // Validasi ulang di backend: Promo ada, kuota masih, dan memenuhi min belanja
            if ($promo && $promo->batasan_user > 0 && $hargaDasar >= $promo->transaksi_min) {
                $diskon = $promo->potongan_harga;
                $idPromo = $promo->id_promo;

                // Kurangi kuota user (batasan_user) di database agar tidak over-claim
                $promo->decrement('batasan_user');
            }
        }

        // Kalkulasi total akhir (Pastikan tidak minus jika diskon lebih besar dari harga)
        $totalAkhir = max(0, $hargaDasar - $diskon);

        // 4. SIMPAN KE DATABASE
        $transaksi = Transaksi::create([
            'id_users'          => auth()->id() ?? null,
            'id_produk'         => $produk->id_produk,
            'id_promo'          => $idPromo,          // Menyimpan ID Promo yang dipakai
            'kontak_pelanggan'  => $request->kontak_pelanggan ?? '-',
            'id_target'         => $request->id_target,
            'id_server'         => $request->id_server ?? null,
            'total_pembelian'   => $hargaDasar,       // Harga murni produk (Misal: 100.000)
            'diskon_pembelian'  => $diskon,           // Nominal potongan (Misal: 10.000)
            'total_akhir'       => $totalAkhir,       // Harga bersih (Misal: 90.000) -> Ini yang dibaca Midtrans
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'pending',
        ]);

        return redirect()->route('transaksi.pembayaran', $transaksi->id_transaksi);
    }


    public function pembayaran($id_transaksi)
    {
        $transaksi = Transaksi::with('produk')->findOrFail($id_transaksi);

        if (!$transaksi->snap_token) {

            $params = [
                'transaction_details' => [
                    // Gunakan ID Transaksi sebagai Order ID
                    'order_id' => 'TRX-' . time() . '-' . $transaksi->id_transaksi,
                    'gross_amount' => (int) $transaksi->total_akhir,
                ],
                'expiry' => [
                    'unit' => 'minute',
                    'duration' => 15
                ],
                'item_details' => [
                    [
                        'id' => $transaksi->id_produk,
                        'price' => (int) $transaksi->total_akhir,
                        'quantity' => 1,
                        'name' => substr($transaksi->produk->nama_produk, 0, 50),
                    ]
                ],
                'customer_details' => [
                    'phone' => $transaksi->kontak_pelanggan !== '-' ? $transaksi->kontak_pelanggan : '081234567890',
                ],
                // INI KUNCI UI/UX ANDA: Membatasi pop-up Midtrans sesuai pilihan user
                'enabled_payments' => [$transaksi->metode_pembayaran],
            ];

            \Midtrans\Config::$overrideNotifUrl = 'https://lecturer-diffuser-algorithm.ngrok-free.dev/api/midtrans/callback';
            // \Midtrans\Config::$overrideNotifUrl = 'https://tsxcb-103-82-164-109.free.pinggy.net/api/midtrans/callback';

            try {
                $snapToken = Snap::getSnapToken($params);
                $transaksi->snap_token = $snapToken;
                $transaksi->save();
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal terhubung: ' . $e->getMessage());
            }
        }

        return view('transaksi.pembayaran', compact('transaksi'));
    }

    public function callback(Request $request)
    {
        Log::info('Webhook Midtrans Masuk:', $request->all());

        // 1. Verifikasi keamanan (Signature Key) dari Midtrans
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {

            // 2. Ekstrak ID Transaksi asli dari Order ID (contoh: TRX-1780619387-12 -> ambil angka 12)
            $order_id_parts = explode('-', $request->order_id);
            $id_transaksi = end($order_id_parts);

            // 3. Cari data transaksi di database
            $transaksi = Transaksi::find($id_transaksi);

            if ($transaksi) {
                // 4. Update status berdasarkan laporan Midtrans
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    if ($transaksi->status_pembayaran !== 'success') {
                        $transaksi->status_pembayaran = 'success';
                        $transaksi->save();

                        // === DISPATCH BACKGROUND JOB PENGIRIMAN PRODUK ===
                        ProsesPengirimanProduk::dispatch($transaksi);
                    }
                } elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                    $transaksi->status_pembayaran = 'failed';
                }

                $transaksi->save();
            }
        }

        // 5. Beri respons OK ke Midtrans agar mereka berhenti mengirim laporan berulang
        return response()->json(['message' => 'Callback received']);
    }
}
