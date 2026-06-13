<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
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
}