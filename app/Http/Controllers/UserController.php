<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function riwayat()
    {
        // Tarik semua transaksi milik user yang sedang login
        $transaksis = Transaksi::with(['produk', 'review'])
            ->where('id_users', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Nanti kita buat file view ini di resources/views/user/riwayat.blade.php
        return view('user.riwayat', compact('transaksis'));
    }
    // Menampilkan halaman form ulasan
    public function createReview($id_transaksi)
    {
        // Cari transaksi yang sesuai ID dan pastikan itu milik user yang sedang login (Keamanan Lapis 1)
        $transaksi = Transaksi::with('produk')
            ->where('id_transaksi', $id_transaksi)
            ->where('id_users', auth()->id())
            ->firstOrFail();

        // Cegah user mereview 2 kali (Keamanan Lapis 2)
        if ($transaksi->review) {
            return redirect()->route('user.riwayat')->with('error', 'Anda sudah memberikan ulasan untuk transaksi ini.');
        }

        // Cegah user mereview produk yang belum lunas (Keamanan Lapis 3)
        $status = strtolower($transaksi->status_pembayaran);
        if (!in_array($status, ['settlement', 'capture', 'success'])) {
            return redirect()->route('user.riwayat')->with('error', 'Anda hanya bisa mengulas produk yang sudah berhasil dibeli.');
        }

        return view('user.review', compact('transaksi'));
    }

    // Menyimpan ulasan ke database
    public function storeReview(Request $request, $id_transaksi)
    {
        // Validasi input
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:5|max:1000',
        ]);

        // Verifikasi ulang kepemilikan transaksi
        $transaksi = Transaksi::where('id_transaksi', $id_transaksi)
            ->where('id_users', auth()->id())
            ->firstOrFail();

        // Verifikasi ulang pencegahan review ganda
        if ($transaksi->review) {
            return redirect()->route('user.riwayat')->with('error', 'Ulasan sudah pernah dikirim.');
        }

        // Simpan ke database
        Review::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'rating'       => $request->rating,
            'komentar'     => $request->komentar,
        ]);

        return redirect()->route('user.riwayat')->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}
