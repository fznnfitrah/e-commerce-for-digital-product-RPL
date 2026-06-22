@extends('layouts.app') {{-- Sesuaikan nama layout J-Store Anda jika berbeda --}}

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header Hasil Pencarian --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white">Hasil Pencarian</h2>
        <p class="text-gray-400 mt-2">
            Menampilkan hasil untuk kata kunci: <span class="text-blue-400 font-semibold">"{{ $keyword }}"</span>
        </p>
    </div>

    {{-- Kondisi jika data benar-benar tidak ditemukan sama sekali --}}
    @if($brands->isEmpty() && $produks->isEmpty() && !$pulsaGateBrand)
    <div class="bg-gray-800 rounded-lg p-8 text-center border border-gray-700">
        <span class="text-4xl block mb-4">🔍</span>
        <h3 class="text-xl font-medium text-white mb-2">Pencarian tidak ditemukan</h3>
        <p class="text-gray-400">Tidak ada produk, brand, atau layanan yang cocok dengan "{{ $keyword }}".</p>
        <a href="{{ route('dashboard') }}" class="inline-block mt-4 text-blue-500 hover:text-blue-400 transition-colors">
            &larr; Kembali ke Dashboard
        </a>
    </div>
    @else

    {{-- BLOK KHUSUS: GATEWAY PULSA --}}
    @if($pulsaGateBrand)
    <div class="mb-4 flex items-center gap-2 mt-2">
        <h3 class="text-lg font-bold text-white uppercase tracking-wider">Layanan Otomatis</h3>
        <div class="h-px bg-gray-700 flex-1"></div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-10">
        <a href="{{ route('produk.detail', $pulsaGateBrand->id_brand) }}" class="group block h-full">
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-yellow-500/20 backdrop-blur-xl transition hover:-translate-y-2 hover:border-yellow-400/60 hover:shadow-[0_0_30px_rgba(234,179,8,0.3)] text-center float h-full flex flex-col">
                <div class="relative flex-1 min-h-[11rem] flex items-center justify-center overflow-hidden rounded-t-2xl bg-gradient-to-b from-yellow-500/10 to-black/40">
                    <span class="text-6xl group-hover:scale-110 transition duration-500">📶</span>
                    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                </div>
                <div class="px-4 py-3 bg-gradient-to-r from-yellow-500/20 via-orange-500/20 to-yellow-500/20 border-t border-yellow-500/20">
                    <p class="text-sm font-bold truncate text-white group-hover:text-yellow-300 transition-colors">Pulsa Semua Operator</p>
                    <p class="text-[10px] text-yellow-400/70 tracking-widest uppercase font-bold">⚡ DETEKSI OTOMATIS</p>
                </div>
            </div>
        </a>
    </div>
    @endif

    {{-- BLOK 1: HASIL PENCARIAN BRAND --}}
    @if($brands->isNotEmpty())
    <div class="mb-4 flex items-center gap-2">
        <h3 class="text-lg font-bold text-white uppercase tracking-wider">Brand / Kategori</h3>
        <div class="h-px bg-gray-700 flex-1"></div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-10">
        @foreach($brands as $brand)
        <a href="{{ route('produk.detail', $brand->id_brand) }}" class="group block">
            <div class="bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-purple-500/20 rounded-3xl p-6 text-center hover:border-purple-400/60 hover:shadow-[0_0_30px_rgba(168,85,247,0.3)] transition shadow-xl float group h-full flex flex-col justify-between">
                <div class="aspect-square bg-gradient-to-br from-purple-500/20 to-black/40 rounded-2xl mb-4 flex items-center justify-center overflow-hidden p-4 shadow-inner">
                    @if($brand->gambar_brand)
                    <img src="{{ asset('storage/' . $brand->gambar_brand) }}" class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-110 drop-shadow-[0_8px_8px_rgba(0,0,0,0.5)]">
                    @else
                    <span class="text-4xl group-hover:scale-110 transition duration-500">📱</span>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-black text-white uppercase tracking-wider truncate group-hover:text-purple-300 transition">{{ $brand->nama_brand }}</p>
                    {{-- PERBAIKAN ERROR PARSING PHP: Penambahan kurung sebelum ?? --}}
                    <p class="text-xs text-purple-400 mt-2 font-bold italic">Mulai Rp {{ number_format(($brand->produks->min('harga_produk') ?? 0), 0, ',', '.') }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    {{-- BLOK 2: HASIL PENCARIAN PRODUK SPESIFIK (E-BOOK) --}}
    @if($produks->isNotEmpty())
    <div class="mb-4 flex items-center gap-2">
        <h3 class="text-lg font-bold text-white uppercase tracking-wider">Produk Spesifik</h3>
        <div class="h-px bg-gray-700 flex-1"></div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-10">
        @foreach($produks as $produk)
        <a href="{{ route('produk.detail', $produk->id_brand) }}?selected={{ $produk->id_produk }}" class="group block">
            <div class="bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-blue-500/20 rounded-3xl p-6 text-center hover:border-blue-400/60 hover:shadow-[0_0_30px_rgba(59,130,246,0.3)] transition shadow-xl float group h-full flex flex-col justify-between">
                <div class="aspect-square bg-gradient-to-br from-blue-500/20 to-black/40 rounded-2xl mb-4 flex items-center justify-center overflow-hidden p-4 shadow-inner">
                    @if($produk->gambar_produk)
                    <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-110 drop-shadow-[0_8px_8px_rgba(0,0,0,0.5)]">
                    @elseif($produk->brand && $produk->brand->gambar_brand)
                    <img src="{{ asset('storage/' . $produk->brand->gambar_brand) }}" class="max-h-full max-w-full object-contain opacity-70 transition duration-500 group-hover:scale-110">
                    @else
                    <span class="text-4xl group-hover:scale-110 transition duration-500">📖</span>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-bold text-white truncate group-hover:text-blue-300 transition" title="{{ $produk->nama_produk }}">
                        {{ $produk->nama_produk }}
                    </p>
                    {{-- PERBAIKAN ERROR PARSING PHP --}}
                    <p class="text-xs text-blue-400 mt-2 font-bold italic">Rp {{ number_format(($produk->harga_produk ?? 0), 0, ',', '.') }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    @endif
</div>
@endsection