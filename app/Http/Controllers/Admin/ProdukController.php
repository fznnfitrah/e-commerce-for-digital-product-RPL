<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Brand; 
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\AsetProduk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        // Sudah benar menggunakan Eager Loading berantai (Nested Relationship)
        $produks = Produk::with('brand.kategori')->withCount('asets')->latest()->get();
        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        // Ubah pengambilan data dari Kategori menjadi Brand
        // Agar di view, user memilih BRAND (yang mana Brand tersebut sudah mengikat Kategori)
        $brands = Brand::with('kategori')->get();
        return view('admin.produk.create', compact('brands'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Ubah id_kategori menjadi id_brand)
        $request->validate([
            'id_brand'         => 'required|exists:brands,id_brand', // Mengarah ke tabel brands
            'nama_produk'      => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'harga_produk'     => 'required|numeric',
            'type'             => 'required|string|in:topup,ebook,akun,pulsa,token',
            'gambar'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_ebook'       => 'required_if:type,ebook|nullable|file|max:10000',
            'data_akun'        => 'required_if:type,akun|nullable|string',
        ]);

        // 2. Upload Gambar Produk
        $pathGambar = $request->file('gambar')
            ? $request->file('gambar')->store('produk-images', 'public')
            : null;

        // 3. Simpan ke Tabel produk (Gunakan id_brand)
        $produk = Produk::create([
            'id_brand'         => $request->id_brand, // MEMPERBAIKI ERROR COLUMN NOT FOUND
            'nama_produk'      => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'harga_produk'     => $request->harga_produk,
            'gambar_produk'    => $pathGambar,
        ]);

        $validProduk = $produk->id_produk ?? $produk->id; 

        // 4. Logika Aset berdasarkan Type (Tetap dipertahankan karena sudah benar)
        if ($request->type == 'ebook') {
            $pathFile = $request->file('file_ebook')->store('ebooks', 'public');
            AsetProduk::create([
                'id_produk' => $validProduk,
                'nama_aset' => 'E-book: ' . $produk->nama_produk,
                'link_file' => $pathFile,
            ]);
        } elseif ($request->type == 'akun') {
            $listAkun = explode("\n", $request->data_akun);
            foreach ($listAkun as $item) {
                if (!empty(trim($item))) {
                    AsetProduk::create([
                        'id_produk' => $validProduk,
                        'nama_aset' => 'Akun Premium',
                        'deskripsi' => trim($item),
                        'is_sold'   => false
                    ]);
                }
            }
        } elseif (in_array($request->type, ['pulsa', 'token', 'topup'])) {
            AsetProduk::create([
                'id_produk' => $validProduk,
                'nama_aset' => 'Layanan Otomatis ' . ucfirst($request->type),
                'deskripsi' => 'Produk diisi via sistem/input manual oleh pelanggan.',
                'is_sold'   => false
            ]);
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk Berhasil Disimpan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $brands = Brand::with('kategori')->get(); // Ubah ke brand
        return view('admin.produk.edit', compact('produk', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // Validasi disesuaikan menggunakan id_brand
        $request->validate([
            'id_brand'         => 'required|exists:brands,id_brand',
            'nama_produk'      => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'harga_produk'     => 'required|numeric',
            'gambar'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar_produk) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }
            $pathGambar = $request->file('gambar')->store('produk-images', 'public');
            $produk->gambar_produk = $pathGambar;
        }

        // Perbarui data menggunakan id_brand
        $produk->update([
            'id_brand'         => $request->id_brand, 
            'nama_produk'      => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'harga_produk'     => $request->harga_produk,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        $transaksiTerkait = Transaksi::where('id_produk', $produk->id_produk)->exists();

        if ($transaksiTerkait) {
            return redirect()->route('admin.produk.index')->with('error', 'Tidak dapat menghapus produk karena terdapat transaksi terkait.');
        }

        if ($produk->gambar_produk) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }

        $asets = AsetProduk::where('id_produk', $produk->id_produk)->get();
        foreach ($asets as $aset) {
            if ($aset->link_file && Storage::disk('public')->exists($aset->link_file)) {
                Storage::disk('public')->delete($aset->link_file);
            }
            $aset->delete();
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
