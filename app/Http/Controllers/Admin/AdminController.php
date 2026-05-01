<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\AsetProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'total_produk'    => Produk::count(),
            'total_transaksi' => Transaksi::count(),
            'total_user'      => User::where('role', 'user')->count(),
            'pendapatan'      => Transaksi::where('status_pembayaran', 'success')->sum('total_akhir'),
            'recent_orders'   => Transaksi::with('produk')->latest()->take(5)->get()
        ];

        return view('admin.dashboard', $data);
    }
    
}
