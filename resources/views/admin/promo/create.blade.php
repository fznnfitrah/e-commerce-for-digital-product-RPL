@extends('layouts.admin')

@section('title', 'Tambah Promo')
@section('header_title', 'Buat Promo Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white/5 border border-white/10 p-8 rounded-4xl backdrop-blur-xl">
    <form action="{{ route('admin.promo.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div>
            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">Kode Promo</label>
            <input type="text" name="kode_promo" placeholder="Contoh: HEMAT50" required
                class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 outline-none uppercase font-mono">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">Potongan Harga (Rp)</label>
                <input type="number" name="potongan_harga" placeholder="10000" required
                    class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 outline-none">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">Min. Transaksi (Rp)</label>
                <input type="number" name="transaksi_min" placeholder="50000" required
                    class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 outline-none">
            </div>
        </div>

        <div>
            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">Batasan Kuota User</label>
            <input type="number" name="batasan_user" placeholder="100" required
                class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 outline-none">
        </div>

        <div class="flex justify-end gap-4 pt-4 border-t border-white/10">
            <a href="{{ route('admin.promo.index') }}" class="px-6 py-3 text-gray-400 hover:text-white transition">Batal</a>
            <button type="submit" class="px-10 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl shadow-lg shadow-purple-600/20 transition-all active:scale-95">
                Simpan Promo
            </button>
        </div>
    </form>
</div>
@endsection