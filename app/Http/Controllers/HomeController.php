<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori yang memiliki produk
        $kategoris = Kategori::with('produks')->get();

        $produks = Produk::with('kategori')->get();
        $produkByKategori = $produks->groupBy(function ($item) {
            return $item->kategori->nama_kategori;
        });

        return view('dashboard', compact('produkByKategori', 'kategoris'));
    }

    public function detail($id)
    {
        $kategori = Kategori::with('produks')->findOrFail($id);
        $nama = Str::lower($kategori->nama_kategori);
        $items = $kategori->produks;

        $view = match (true) {
            Str::contains($nama, 'book')   => 'produks.e-book.ebook-detail',
            Str::contains($nama, 'akun')   => 'produks.akun-detail',
            Str::contains($nama, 'token')  => 'produks.pln-detail',
            Str::contains($nama, 'pulsa')  => 'produks.pulsa-detail',
            default                        => 'produks.topup.topup-detail',
        };

        return view($view, compact('kategori', 'items'));
    }
}
