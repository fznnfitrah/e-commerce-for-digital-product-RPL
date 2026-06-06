<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        // Gunakan Eager Loading (with) untuk menghemat query ke tabel kategoris
        $brands = Brand::with('kategori')->latest()->paginate(10);
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.brand.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'  => 'required|exists:kategoris,id_kategori',
            'nama_brand'   => 'required|string|max:255',
            'prefix'       => 'nullable|string', // Nullable sesuai struktur DB Anda
            'gambar_brand' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->except('gambar_brand');

        // Handle File Upload
        if ($request->hasFile('gambar_brand')) {
            $data['gambar_brand'] = $request->file('gambar_brand')->store('brands', 'public');
        }

        Brand::create($data);

        return redirect()->route('admin.brand.index')->with('success', 'Data Brand berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.brand.edit', compact('brand', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'id_kategori'  => 'required|exists:kategoris,id_kategori',
            'nama_brand'   => 'required|string|max:255',
            'prefix'       => 'nullable|string',
            'gambar_brand' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->except('gambar_brand');

        // Handle File Update
        if ($request->hasFile('gambar_brand')) {
            // Hapus gambar lama jika ada
            if ($brand->gambar_brand && Storage::disk('public')->exists($brand->gambar_brand)) {
                Storage::disk('public')->delete($brand->gambar_brand);
            }
            // Simpan gambar baru
            $data['gambar_brand'] = $request->file('gambar_brand')->store('brands', 'public');
        }

        $brand->update($data);

        return redirect()->route('admin.brand.index')->with('success', 'Data Brand berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // Hapus file gambar secara fisik dari server sebelum menghapus data di DB
        if ($brand->gambar_brand && Storage::disk('public')->exists($brand->gambar_brand)) {
            Storage::disk('public')->delete($brand->gambar_brand);
        }

        $brand->delete();

        return redirect()->route('admin.brand.index')->with('success', 'Data Brand berhasil dihapus.');
    }
}