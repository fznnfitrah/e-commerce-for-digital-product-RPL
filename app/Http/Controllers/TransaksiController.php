<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

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

    public function checkout(Request $request)
    {
        // 1. TAMBAHKAN id_target DI SINI AGAR TIDAK BISA LOLOS JIKA KOSONG
        $request->validate([
            'id_produk'         => 'required|exists:produks,id_produk',
            'id_target'         => 'required|string|min:3', // Mewajibkan Email/ID Akun
            'metode_pembayaran' => 'required|string'
        ], [
            // Pesan error kustom agar lebih ramah dibaca pengguna
            'id_target.required'         => 'ID Target / Email wajib diisi.',
            'metode_pembayaran.required' => 'Silakan pilih metode pembayaran terlebih dahulu.'
        ]);

        $produk = Produk::findOrFail($request->id_produk);

        // 2. Simpan data (tanpa invoice_no)
        $transaksi = Transaksi::create([
            'id_users'          => auth()->id() ?? null,
            'id_produk'         => $produk->id_produk,
            'kontak_pelanggan'  => $request->kontak_pelanggan ?? '-',

            // Karena id_target sudah divalidasi 'required' di atas, 
            // kita bisa langsung memasukkannya tanpa default '?? -'
            'id_target'         => $request->id_target,

            'id_server'         => $request->id_server ?? null,
            'total_pembelian'   => $produk->harga_jual ?? $produk->harga_produk,
            'total_akhir'       => $produk->harga_jual ?? $produk->harga_produk,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'pending', // Kunci keamanan berhasil diterapkan
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

            \Midtrans\Config::$overrideNotifUrl = 'https://bllvv-103-168-186-150.run.pinggy-free.link/api/midtrans/callback';

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
        \Illuminate\Support\Facades\Log::info('Webhook Midtrans Masuk:', $request->all());

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
                    $transaksi->status_pembayaran = 'success';
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
