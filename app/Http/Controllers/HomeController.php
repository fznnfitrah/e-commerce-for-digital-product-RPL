<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil semua produk. Kita tampilkan posternya saja di awal.
        $produks = Produk::with('kategori')->get();

        // Kelompokkan berdasarkan kategori agar rapi di view
        $produkByKategori = $produks->groupBy(function ($item) {
            return $item->kategori->nama_kategori;
        });

        return view('dashboard', compact('produkByKategori'));
    }

    public function detail($id)
    {
        // Ambil produk beserta daftar item/asetnya
        $produk = Produk::with(['kategori', 'assets'])->findOrFail($id);

        return view('produk-detail', compact('produk'));
    }
}
