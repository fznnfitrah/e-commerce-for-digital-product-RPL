<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\AsetProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        Transaksi::where('status_pembayaran', 'pending')
            ->where('created_at', '<', Carbon::now()->subMinutes(15))
            ->update(['status_pembayaran' => 'failed']);

        // 2. Ambil ringkasan statistik (Data di bawah ini otomatis langsung sinkron dengan perubahan di atas)
        $data = [
            'total_produk'    => Produk::count(),
            'total_transaksi' => Transaksi::count(),
            'total_user'      => User::where('role', 'user')->count(),
            'pendapatan'      => Transaksi::where('status_pembayaran', 'success')->sum('total_akhir'),
            'recent_orders'   => Transaksi::with('produk')->latest()->take(5)->get()
        ];

        return view('admin.dashboard', $data);
    }

    public function riwayat()
    {
        // 1. Wajib jalankan Lazy Checking Expiry sebelum render halaman riwayat
        Transaksi::where('status_pembayaran', 'pending')
            ->where('created_at', '<', Carbon::now()->subMinutes(15))
            ->update(['status_pembayaran' => 'failed']);

        // 2. Ambil semua data transaksi dengan pagination (misal: 10 data per halaman)
        $all_transaksi = Transaksi::with('produk')
            ->latest()
            ->paginate(10);

        return view('admin.riwayat_transaksi', compact('all_transaksi'));
    }
}
