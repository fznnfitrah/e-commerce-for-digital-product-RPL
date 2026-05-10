<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\AsetProduk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    //
    public function index()
    {
        $produks = Produk::with('kategori')->withCount('asets')->latest()->get();
        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Sesuaikan nama field sesuai database jika perlu)
        $request->validate([
            'id_kategori'      => 'required|exists:kategoris,id_kategori',
            'nama_produk'      => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'harga_produk'     => 'required|numeric',
            'type'             => 'required|string',
            'gambar'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Perbaikan di sini: Tambahkan 'nullable'
            'file_ebook'       => 'required_if:type,ebook|nullable|file|max:10000',
            'data_akun'        => 'required_if:type,akun|nullable|string',
        ]);
        // 2. Upload Gambar Produk
        $pathGambar = $request->file('gambar')
            ? $request->file('gambar')->store('produk-images', 'public')
            : null;

        // 3. Simpan ke Tabel produk (Gunakan nama kolom sesuai gambar database)
        $produk = Produk::create([
            'id_kategori'      => $request->id_kategori,
            'nama_produk'      => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk, // Kolom ke-4
            'harga_produk'     => $request->harga_produk,     // Kolom ke-5
            'gambar_produk'    => $pathGambar,                // Kolom ke-6
        ]);

        if (!$produk) {
            dd("Gagal menyimpan ke tabel produk");
        }

        // 4. Logika Aset berdasarkan Type
        if ($request->type == 'ebook') {
            $pathFile = $request->file('file_ebook')->store('ebooks', 'public');
            AsetProduk::create([
                'id_produk' => $produk->id_produk,
                'nama_aset' => 'E-book: ' . $produk->nama_produk,
                'link_file' => $pathFile,
            ]);
        } elseif ($request->type == 'akun') {
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

        return redirect()->route('admin.produk.index')->with('success', 'Produk Berhasil Disimpan!');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.produk.edit', compact('produk', 'kategoris'));
    }

    // Memproses perubahan data
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'id_kategori'      => 'required|exists:kategoris,id_kategori',
            'nama_produk'      => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'harga_produk'     => 'required|numeric',
            'gambar'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Handle upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar_produk) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }
            $pathGambar = $request->file('gambar')->store('produk-images', 'public');
            $produk->gambar_produk = $pathGambar;
        }

        $produk->update([
            'id_kategori'      => $request->id_kategori,
            'nama_produk'      => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'harga_produk'     => $request->harga_produk,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus gambar dari storage
        if ($produk->gambar_produk) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }

        // Aset terkait akan ikut terhapus jika Anda menggunakan onUpdate('cascade')->onDelete('cascade') di migration
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
