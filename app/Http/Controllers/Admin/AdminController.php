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

    public function store(Request $request)
    {
        // 1. Validasi Input sesuai ERD
        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'nama_produk' => 'required|string|max:255',
            'harga_jual'  => 'required|numeric',
            'type'        => 'required|string',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Simpan Data ke Tabel produk
        $pathGambar = $request->file('gambar') ? $request->file('gambar')->store('produk-images', 'public') : null;

        $produk = Produk::create([
            'id_kategori' => $request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'harga_jual'  => $request->harga_jual,
            'gambar_produk' => $pathGambar,
            'status'      => 'active',
        ]);

        // 3. Logika Penyimpanan Aset berdasarkan Type
        if ($request->type == 'ebook') {
            // Simpan sebagai Link File
            $pathFile = $request->file('file_ebook')->store('ebooks', 'public');
            AsetProduk::create([
                'id_produk' => $produk->id_produk,
                'nama_aset' => 'File E-book: ' . $produk->nama_produk,
                'link_file' => $pathFile,
            ]);
        } elseif ($request->type == 'akun') {
            // Simpan Akun Premium (Bulk Insert dari Textarea)
            $listAkun = explode("\n", $request->data_akun); 
            foreach ($listAkun as $item) {
                if (!empty(trim($item))) {
                    AsetProduk::create([
                        'id_produk' => $produk->id_produk,
                        'nama_aset' => 'Akun Premium',
                        'deskripsi' => trim($item),
                        'is_sold'   => false
                    ]);
                }
            }
        }
        // Untuk Top-up (Diamond/Pulsa), aset_produk dibiarkan kosong

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }
}
