@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 md:px-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        
        {{-- KIRI: INFO PRODUK --}}
        <div class="md:col-span-1 space-y-6">
            <div class="rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="w-full object-cover">
            </div>
            <h2 class="text-3xl font-black italic uppercase">{{ $produk->nama_produk }}</h2>
            <div class="prose prose-invert text-gray-400 text-sm">
                {!! nl2br(e($produk->deskripsi_produk)) !!}
            </div>
        </div>

        {{-- KANAN: FORM TRANSAKSI & PILIHAN ITEM --}}
        <div class="md:col-span-2 space-y-8">
            {{-- Form Input (ID Game/Email) --}}
            <div class="bg-white/5 p-8 rounded-3xl border border-white/10">
                <h4 class="font-bold mb-4 flex items-center gap-2"><span>1.</span> Masukkan Data Akun</h4>
                <input type="text" placeholder="Contoh: 12345678 (1234)" class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Pilihan Nominal dari Database --}}
            <div class="bg-white/5 p-8 rounded-3xl border border-white/10">
                <h4 class="font-bold mb-6 flex items-center gap-2"><span>2.</span> Pilih Nominal</h4>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($produk->assets as $asset)
                    <button class="p-4 rounded-2xl border border-white/10 bg-black/20 hover:border-blue-500 transition text-left group">
                        <p class="text-xs text-gray-400 group-hover:text-blue-400 transition">{{ $asset->nama_aset }}</p>
                        {{-- Harga bisa diambil dari kolom harga_produk jika item tunggal --}}
                        <p class="font-bold mt-1 text-sm">Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@endsection