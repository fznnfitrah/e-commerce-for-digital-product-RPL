@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 md:px-16 max-w-7xl">

    {{-- HEADER KATEGORI --}}
    <div class="mb-10 border-b border-white/10 pb-6">
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-2">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition">Home</a>
            <span>/</span>
            <span class="text-white">{{ $nama }}</span>
        </div>
        <h2 class="text-3xl font-black italic uppercase text-white galaxy-title flex items-center gap-3">
            <span class="w-2 h-8 bg-blue-500 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
            Kategori: {{ $nama }}
        </h2>
    </div>

    {{-- GRID SELURUH BRAND --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @forelse($brands as $brand)

        {{-- LOGIKA GAMBAR CADANGAN PINTAR --}}
        @php
        $fallbackImg = asset('images/placeholder.png'); // Bawaan

        // Jika kategorinya game/topup, gunakan gambar dummy game yang berurutan
        if (\Illuminate\Support\Str::contains(strtolower($nama), ['topup', 'game'])) {
        $fallbackImg = asset('images/game/game top-up-' . $loop->iteration . '.png');
        }
        // Jika kategorinya ebook, gunakan placeholder ebook
        elseif (\Illuminate\Support\Str::contains(strtolower($nama), ['book', 'e-book'])) {
        $fallbackImg = asset('images/ebook-placeholder.png');
        }
        @endphp

        {{-- Mengarahkan klik langsung ke detail produk/brand tersebut --}}
        <a href="{{ route('produk.detail', $brand->id_brand) }}" class="group block">
            <div class="rounded-3xl overflow-hidden bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-blue-500/20 shadow-xl transition hover:-translate-y-2 hover:border-blue-400/60 float">

                <div class="relative aspect-square flex items-center justify-center p-6 bg-gradient-to-b from-blue-500/10 to-transparent">
                    {{-- Terapkan variabel $fallbackImg di sini --}}
                    <img src="{{ $brand->gambar_brand ? asset('storage/' . $brand->gambar_brand) : $fallbackImg }}"
                        class="w-full h-full object-contain drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)] transition duration-500 group-hover:scale-110"
                        onerror="this.src='https://via.placeholder.com/150/1a1c23/3b82f6?text={{ urlencode($brand->nama_brand) }}'">
                    {{-- (Tambahan onerror agar tidak pernah muncul ikon gambar pecah lagi) --}}
                </div>

                <div class="px-4 py-5 text-center bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-blue-500/10 border-t border-blue-500/20">
                    <p class="text-sm font-black text-white truncate uppercase tracking-wider group-hover:text-blue-300 transition">{{ $brand->nama_brand }}</p>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-16 bg-white/5 rounded-3xl border border-white/10">
            <p class="text-gray-400 italic">Belum ada brand/produk yang ditambahkan ke dalam kategori ini.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection