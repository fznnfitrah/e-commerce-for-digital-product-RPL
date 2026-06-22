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

    @php
        $kategoriNameLower = strtolower($nama);
        $isEbook = \Illuminate\Support\Str::contains($kategoriNameLower, ['book', 'e-book', 'ebook']);
    @endphp

    {{-- KONDISI 1: JIKA KATEGORI E-BOOK (LANGSUNG LOOPING PRODUK NOVELNYA) --}}
    @if($isEbook)
        @php
            // Mengumpulkan semua produk dari semua brand yang ada di kategori E-book ini
            $allEbooks = collect();
            foreach($brands as $brand) {
                $allEbooks = $allEbooks->merge($brand->produks);
            }
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($allEbooks as $produk)
                @php
                    $produkNameLower = strtolower($produk->nama_produk);
                    $localEbookImage = null;

                    if (\Illuminate\Support\Str::contains($produkNameLower, 'bintang')) $localEbookImage = 'images/e-book/bintang.jpg';
                    elseif (\Illuminate\Support\Str::contains($produkNameLower, 'hujan')) $localEbookImage = 'images/e-book/hujan.jpg';
                    elseif (\Illuminate\Support\Str::contains($produkNameLower, 'komet')) $localEbookImage = 'images/e-book/komet.jpg';
                    elseif (\Illuminate\Support\Str::contains($produkNameLower, 'laut')) $localEbookImage = 'images/e-book/laut.jpg';
                    elseif (\Illuminate\Support\Str::contains($produkNameLower, 'matahari')) $localEbookImage = 'images/e-book/matahari.jpg';
                @endphp

                <a href="{{ route('produk.detail', ['id' => $produk->id_brand, 'selected' => $produk->id_produk]) }}" class="group block">
                    <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-white/5 to-white/0 border border-blue-500/20 backdrop-blur-xl transition hover:-translate-y-2 hover:border-blue-400/60 hover:shadow-[0_0_25px_rgba(59,130,246,0.3)] float">
                        <div class="relative h-56 flex items-center justify-center overflow-hidden rounded-t-2xl bg-gradient-to-b from-blue-500/10 to-black/40">
                            
                            @if($produk->gambar_produk)
                                <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="max-h-[85%] object-contain transition duration-500 group-hover:scale-105 p-2 drop-shadow-[0_8px_8px_rgba(0,0,0,0.6)]">
                            @elseif($localEbookImage)
                                <img src="{{ asset($localEbookImage) }}" class="max-h-[85%] object-contain transition duration-500 group-hover:scale-105 p-2 drop-shadow-[0_8px_8px_rgba(0,0,0,0.6)]">
                            @else
                                <span class="text-5xl">📚</span>
                            @endif

                            <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                        </div>
                        <div class="px-4 py-4 bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-blue-500/20 border-t border-blue-500/20 text-center">
                            <p class="text-xs font-black truncate text-white uppercase group-hover:text-blue-300 transition-colors">{{ $produk->nama_produk }}</p>
                            <p class="text-[10px] text-purple-400 font-bold mt-1 uppercase italic">Mulai Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16 bg-white/5 rounded-3xl border border-white/10">
                    <p class="text-gray-400 italic">Belum ada koleksi E-Book.</p>
                </div>
            @endforelse
        </div>

    {{-- KONDISI 2: UNTUK KATEGORI LAINNYA (GAMES & APPS PREMIUM) --}}
    @else
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($brands as $brand)
                @php
                    $brandNameLower = strtolower($brand->nama_brand);
                    $fallbackImg = asset('images/placeholder.png'); 

                    if (\Illuminate\Support\Str::contains($kategoriNameLower, ['topup', 'game', 'top up'])) {
                        $fallbackImg = asset('images/game/game top-up-' . $loop->iteration . '.png');
                    } 
                    elseif (\Illuminate\Support\Str::contains($kategoriNameLower, ['apps', 'aplikasi', 'premium'])) {
                        if (\Illuminate\Support\Str::contains($brandNameLower, 'netflix')) $fallbackImg = asset('images/akunprem/netflix.png');
                        elseif (\Illuminate\Support\Str::contains($brandNameLower, 'capcut')) $fallbackImg = asset('images/akunprem/capcut.jpg');
                        elseif (\Illuminate\Support\Str::contains($brandNameLower, 'spotify')) $fallbackImg = asset('images/akunprem/spotify.png');
                        elseif (\Illuminate\Support\Str::contains($brandNameLower, 'canva')) $fallbackImg = asset('images/akunprem/canva.png');
                        elseif (\Illuminate\Support\Str::contains($brandNameLower, ['gisney', 'disney'])) $fallbackImg = asset('images/akunprem/disney.png');
                    }
                @endphp

                <a href="{{ route('produk.detail', $brand->id_brand) }}" class="group block">
                    <div class="rounded-3xl overflow-hidden bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-blue-500/20 shadow-xl transition hover:-translate-y-2 hover:border-blue-400/60 float">
                        <div class="relative aspect-square flex items-center justify-center p-6 bg-gradient-to-b from-blue-500/10 to-transparent">
                            <img src="{{ $brand->gambar_brand ? asset('storage/' . $brand->gambar_brand) : $fallbackImg }}"
                                class="w-full h-full object-contain drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)] transition duration-500 group-hover:scale-110">
                        </div>
                        <div class="px-4 py-5 text-center bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-blue-500/10 border-t border-blue-500/20">
                            <p class="text-sm font-black text-white truncate uppercase tracking-wider group-hover:text-blue-300 transition">{{ $brand->nama_brand }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16 bg-white/5 rounded-3xl border border-white/10">
                    <p class="text-gray-400 italic">Belum ada produk yang tersedia di kategori ini.</p>
                </div>
            @endforelse
        </div>
    @endif

</div>
@endsection