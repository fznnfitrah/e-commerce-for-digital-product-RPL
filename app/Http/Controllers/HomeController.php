<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Brand;
use App\Models\Produk;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil semua kategori lengkap dengan hirarki brand dan produknya untuk dashboard
        $kategoris = Kategori::with('brands.produks')->get();

        // 2. Ambil semua produk lengkap dengan relasi brand dan kategori murninya
        $produks = Produk::with('brand.kategori')->get();

        // 3. Kelompokkan produk berdasarkan nama kategori melalui jembatan tabel Brand
        $produkByKategori = $produks->groupBy(function ($item) {
            return $item->brand->kategori->nama_kategori ?? 'Lainnya';
        });

        $ulasanPilihan = Review::with(['transaksi.produk'])
            ->where('rating', '>=', 4)
            ->latest()
            ->take(10)
            ->get();

        // Kembalikan variabel yang dibutuhkan oleh view dashboard Anda
        return view('dashboard', compact('kategoris', 'produkByKategori', 'ulasanPilihan'));
    }

    public function detail($id_brand)
    {
        $brand = Brand::with(['produks', 'kategori'])->findOrFail($id_brand);
        $kategori = $brand->kategori;
        $nama = Str::lower($kategori->nama_kategori);

        // LOGIKA KHUSUS PULSA
        if (Str::contains($nama, 'pulsa')) {
            // Ambil semua brand yang berada di bawah kategori pulsa yang sama beserta produknya
            $allProviders = Brand::with('produks')
                ->where('id_kategori', $kategori->id_kategori)
                ->get();
            return view('produks.pulsa.pulsa-detail', compact('kategori', 'allProviders'));
        }

        if (Str::contains($nama, 'token') || Str::contains($nama, 'pln')) {
            $items = $brand->produks; // Mengambil varian nominal token (20k, 50k, 100k, dst)
            return view('produks.pln.pln-detail', compact('brand', 'kategori', 'items'));
        }

        if (Str::contains($nama, 'akun') || Str::contains($nama, 'premium') || Str::contains($nama, 'apps')) {
            $items = $brand->produks; // Mengambil varian durasi (Premium 1 Bulan, 3 Bulan, dll)
            return view('produks.akun.akun-detail', compact('brand', 'kategori', 'items'));
        }

        // Logika untuk tipe produk lainnya (E-book, Akun, Topup, Token) tetap sama
        $items = $brand->produks;
        $view = match (true) {
            Str::contains($nama, 'book')   => 'produks.e-book.ebook-detail',
            default                        => 'produks.topup.topup-detail',
        };


        return view($view, compact('brand', 'kategori', 'items'));
    }

    public function checkoutEbook($id_produk)
    {
        // 1. Tarik data produk berdasarkan ID yang dikirim dari rute dashboard
        $produk = Produk::findOrFail($id_produk);

        // 2. Arahkan ke file view khusus checkout e-book yang sudah kita refactor
        return view('produks.e-book.ebook-detail', compact('produk'));
    }

    public function kategoriAll($nama)
    {
        // Cari kategori berdasarkan nama persis dari URL, lalu tarik semua brand-nya
        $kategori = Kategori::with('brands')->where('nama_kategori', $nama)->firstOrFail();

        $brands = $kategori->brands;

        return view('kategori-all', compact('kategori', 'brands', 'nama'));
    }
}
