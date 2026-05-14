<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('admin.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promo.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'kode_promo'     => 'required|string|unique:promos,kode_promo|max:50',
            'potongan_harga' => 'required|numeric|min:0',
            'batasan_user'   => 'required|integer|min:1',
            'transaksi_min'  => 'required|numeric|min:0',
        ]);

        Promo::create($request->all());

        return redirect()->route('admin.promo.index')->with('success', 'Promo baru berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $promo = Promo::where('id_promo', $id)->firstOrFail();
        $promo->delete();

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil dihapus!');
    }
}
