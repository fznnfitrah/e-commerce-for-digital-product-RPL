<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('produks')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|unique:kategoris']);
        Kategori::create($request->all());
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
        return back()->with('success', 'Kategori dihapus!');
    }
}
