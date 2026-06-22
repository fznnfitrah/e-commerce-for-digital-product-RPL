@extends('layouts.app')

@section('content')

{{-- HERO SECTION --}}
<div class="relative w-full overflow-hidden h-87.5 md:h-125 bg-[#0b0e14] section-glow">
    <img src="{{ asset('images/hero-bg.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-60">
    <img src="{{ asset('images/hero-mobile-legend.png') }}" class="absolute right-0 bottom-0 h-[90%] md:h-[110%] object-contain translate-x-10 md:translate-x-20 z-10 float">
    <div class="absolute inset-0 bg-gradient-to-r from-[#0b0e14] via-[#0b0e14]/80 to-transparent"></div>
    <div class="absolute -top-1/4 right-0 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute inset-0 flex items-center z-20">
        <div class="container mx-auto px-4 md:px-16">
            <h2 class="text-4xl md:text-6xl font-black italic uppercase leading-tight text-white galaxy-title">
                BELI PRODUK <br>
                <span class="text-blue-500">DIGITAL</span> MUDAH <br>
                DAN CEPAT
            </h2>
            <p class="mt-4 mb-6 max-w-xl text-gray-400">
                Top up game favorit, Aplikasi Premium, Koleksi Ebook Lengkap, Token Listrik Instan, dan Pulsa/Paket Data Murah, Semua Tersedia disini, Transaksi Amanah, Layanan 24 Jam
            </p>
            <button onclick="document.getElementById('topup-section').scrollIntoView({ behavior: 'smooth' })" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 hover:scale-105 transition shadow-[0_0_20px_rgba(37,99,235,0.4)] neon-border">
                BELANJA SEKARANG
            </button>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="container mx-auto px-4 py-12 md:px-16">

    {{-- KATEGORI NAVIGASI (Aktif Scroll) --}}
    <h3 class="mb-6 text-xl font-bold flex items-center gap-2 text-white galaxy-title">
        <span class="text-blue-500 text-2xl">✦</span> Kategori Produk
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-16">
        @php
        $categories = [
        ['icon'=>'🎮','name'=>'Topup', 'target' => 'topup-section'],
        ['icon'=>'📱','name'=>'Apps', 'target' => 'apps-section'],
        ['icon'=>'📚','name'=>'Ebook', 'target' => 'ebook-section'],
        ['icon'=>'📶','name'=>'Pulsa', 'target' => 'utility-section'],
        ['icon'=>'⚡','name'=>'Token', 'target' => 'utility-section'],
        ];
        @endphp
        @foreach($categories as $cat)
        <div onclick="document.getElementById('{{ $cat['target'] }}').scrollIntoView({ behavior: 'smooth' })"
            class="bg-[#1a1c23] border border-blue-500/20 rounded-2xl p-4 flex items-center gap-4 hover:border-blue-500/80 hover:bg-[#1f222a] hover:shadow-[0_0_20px_rgba(59,130,246,0.3)] transition cursor-pointer group float">
            <div class="text-3xl group-hover:scale-110 transition-transform">{{ $cat['icon'] }}</div>
            <span class="text-sm font-bold text-gray-200 group-hover:text-blue-300 transition">{{ $cat['name'] }}</span>
        </div>
        @endforeach
    </div>

    {{-- TOPUP SECTION --}}
    @php
    $topupCategory = $kategoris->whereIn('nama_kategori', ['Topup', 'Top-up', 'Topup Games'])->first();
    $gameBrands = $topupCategory ? $topupCategory->brands : collect();
    @endphp

    <div id="topup-section" class="flex justify-between items-center mb-8 scroll-mt-24 section-glow">
        <h3 class="text-2xl font-black italic uppercase text-white galaxy-title flex items-center gap-3">
            <span class="w-2 h-8 bg-gradient-to-b from-blue-600 to-purple-600 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span> 🎮 Topup Games Populer
        </h3>
        {{-- REFAKTOR: Gunakan nama_kategori dari database --}}
        <a href="{{ route('kategori.all', $topupCategory ? $topupCategory->nama_kategori : 'Topup') }}" class="group text-sm font-bold text-purple-500 hover:text-purple-300 flex items-center gap-2 transition">
            LIHAT SEMUA
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-16">
        @if($gameBrands->count() > 0)
        @foreach($gameBrands as $brand)
        <a href="{{ route('produk.detail', $brand->id_brand) }}" class="group block">
            <div class="rounded-3xl overflow-hidden bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-blue-500/20 shadow-2xl transition hover:-translate-y-2 hover:border-blue-400/60 hover:shadow-[0_0_30px_rgba(59,130,246,0.4)] float">
                <div class="relative aspect-square flex items-center justify-center p-6 bg-gradient-to-b from-blue-500/10 to-transparent">
                    <img src="{{ $brand->gambar_brand ? asset('storage/' . $brand->gambar_brand) : asset('images/game/game top-up-' . $loop->iteration . '.png') }}"
                        class="w-full h-full object-contain drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)] transition duration-500 group-hover:scale-110">
                </div>
                <div class="px-4 py-5 text-center bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-blue-500/10 border-t border-blue-500/20">
                    <p class="text-sm font-black text-white truncate uppercase tracking-wider group-hover:text-blue-300 transition">{{ $brand->nama_brand }}</p>
                    <p class="text-[10px] text-gray-500 mt-1 font-bold uppercase tracking-widest">⚡ PROSES INSTAN</p>
                </div>
            </div>
        </a>
        @endforeach
        @else
        <p class="text-gray-500 col-span-full italic text-sm">Belum ada data Brand Game.</p>
        @endif
    </div>

    {{-- APLIKASI PREMIUM SECTION --}}
    @php
    $appsCategory = $kategoris->whereIn('nama_kategori', ['Apps', 'Aplikasi Premium', 'Akun Premium'])->first();
    $appBrands = $appsCategory ? $appsCategory->brands : collect();
    @endphp

    <div id="apps-section" class="flex justify-between items-center mb-8 scroll-mt-24 section-glow">
        <h3 class="text-2xl font-black italic uppercase text-white galaxy-title flex items-center gap-3">
            <span class="w-2 h-8 bg-gradient-to-b from-purple-600 to-pink-600 rounded-full shadow-[0_0_10px_rgba(168,85,247,0.5)]"></span> 📱 Aplikasi Premium
        </h3>
        <a href="{{ route('kategori.all', $appsCategory ? $appsCategory->nama_kategori : 'Apps') }}" class="group text-sm font-bold text-purple-500 hover:text-purple-300 flex items-center gap-2 transition">
            LIHAT SEMUA
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-16">
        @if($appBrands->count() > 0)
        @foreach($appBrands as $brand)
        
        {{-- LOGIKA MAPPING FILE ICON BERDASARKAN DATABASE --}}
        @php
            $brandNameLower = Str::lower($brand->nama_brand);
            
            // Mapping default jika gambar dari panel admin kosong
            if (Str::contains($brandNameLower, 'netflix')) {
                $localImage = 'images/akunprem/netflix.png';
            } elseif (Str::contains($brandNameLower, 'capcut')) {
                $localImage = 'images/akunprem/capcut.jpg';
            } elseif (Str::contains($brandNameLower, 'spotify')) {
                $localImage = 'images/akunprem/spotify.png';
            } elseif (Str::contains($brandNameLower, 'canva')) {
                $localImage = 'images/akunprem/canva.png';
            } elseif (Str::contains($brandNameLower, 'gisney') || Str::contains($brandNameLower, 'disney')) {
                $localImage = 'images/akunprem/disney.png';
            } else {
                $localImage = null;
            }
        @endphp

        <a href="{{ route('produk.detail', $brand->id_brand) }}" class="group block">
            <div class="bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-purple-500/20 rounded-3xl p-6 text-center hover:border-purple-400/60 hover:shadow-[0_0_30px_rgba(168,85,247,0.3)] transition shadow-xl float group">
                <div class="aspect-square bg-gradient-to-br from-purple-500/20 to-black/40 rounded-2xl mb-4 flex items-center justify-center overflow-hidden p-4 shadow-inner">
                    
                    @if($brand->gambar_brand)
                        {{-- Jika ada gambar dari upload admin di database --}}
                        <img src="{{ asset('storage/' . $brand->gambar_brand) }}" class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-110 drop-shadow-[0_8px_8px_rgba(0,0,0,0.5)]">
                    @elseif($localImage)
                        {{-- PERBAIKAN UTAMA: Mengambil aset lokal dari folder public/images/akunprem/ --}}
                        <img src="{{ asset($localImage) }}" class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-110 drop-shadow-[0_8px_8px_rgba(0,0,0,0.5)]">
                    @else
                        {{-- Fallback jika file tidak ditemukan sama sekali --}}
                        <span class="text-4xl group-hover:scale-110 transition duration-500">📱</span>
                    @endif

                </div>
                <p class="text-sm font-black text-white uppercase tracking-wider truncate group-hover:text-purple-300 transition">{{ $brand->nama_brand }}</p>
                <p class="text-xs text-purple-400 mt-2 font-bold italic">Mulai Rp {{ number_format($brand->produks->min('harga_produk') ?? 0, 0, ',', '.') }}</p>
            </div>
        </a>
        @endforeach
        @else
        <p class="text-gray-500 col-span-full italic text-sm">Belum ada data aplikasi premium.</p>
        @endif
    </div>

    {{-- E-BOOK TERLARIS SECTION --}}
    @php
    $ebookCategory = $kategoris->filter(function($kategori) {
        $nama = Str::lower($kategori->nama_kategori);
        return Str::contains($nama, 'book') || Str::contains($nama, 'ebook');
    })->first();

    $ebookBrand = $ebookCategory ? $ebookCategory->brands->first() : null;
    $ebooks = $ebookBrand ? $ebookBrand->produks->take(5) : collect();
    @endphp

    <div id="ebook-section" class="flex justify-between items-center mb-6 scroll-mt-24 section-glow">
        <h3 class="text-2xl font-black italic uppercase text-white galaxy-title flex items-center gap-3">
            <span class="w-2 h-8 bg-gradient-to-b from-cyan-500 to-blue-600 rounded-full shadow-[0_0_10px_rgba(6,182,212,0.5)]"></span> 📚 E-Book Terlaris
        </h3>
        
        <a href="{{ route('kategori.all', $ebookCategory ? $ebookCategory->nama_kategori : 'E-Book') }}" class="group text-sm font-bold text-purple-500 hover:text-purple-300 flex items-center gap-2 transition">
            LIHAT SEMUA
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">
        @if($ebooks->count() > 0)
        @foreach($ebooks as $produk)

        {{-- LOGIKA MAPPING COVER EBOOK BERDASARKAN NAMA PRODUK --}}
        @php
            $produkNameLower = Str::lower($produk->nama_produk);
            
            if (Str::contains($produkNameLower, 'bintang')) {
                $localEbookImage = 'images/e-book/bintang.jpg';
            } elseif (Str::contains($produkNameLower, 'hujan')) {
                $localEbookImage = 'images/e-book/hujan.jpg';
            } elseif (Str::contains($produkNameLower, 'komet')) {
                $localEbookImage = 'images/e-book/komet.jpg';
            } elseif (Str::contains($produkNameLower, 'laut')) {
                $localEbookImage = 'images/e-book/laut.jpg';
            } elseif (Str::contains($produkNameLower, 'matahari')) {
                $localEbookImage = 'images/e-book/matahari.jpg';
            } else {
                $localEbookImage = null;
            }
        @endphp

        <a href="{{ route('produk.detail', ['id' => $ebookBrand->id_brand, 'selected' => $produk->id_produk]) }}" class="group block">
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-white/5 to-white/0 border border-blue-500/20 backdrop-blur-xl transition hover:-translate-y-2 hover:border-blue-400/60 hover:shadow-[0_0_25px_rgba(59,130,246,0.3)] float">
                <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-gradient-to-b from-blue-500/10 to-black/40">
                    
                    @if($produk->gambar_produk)
                        {{-- Jika ada gambar dari upload admin --}}
                        <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105 p-2 drop-shadow-[0_8px_8px_rgba(0,0,0,0.6)]">
                    @elseif($localEbookImage)
                        {{-- PERBAIKAN: Mengambil cover lokal dari folder public/images/e-book/ --}}
                        <img src="{{ asset($localEbookImage) }}" class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105 p-2 drop-shadow-[0_8px_8px_rgba(0,0,0,0.6)]">
                    @else
                        {{-- Fallback placeholder jika tidak ada gambar sama sekali --}}
                        <img src="{{ asset('images/ebook-placeholder.png') }}" class="max-h-full max-w-full object-contain p-2">
                    @endif

                    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                </div>
                <div class="px-4 py-3 bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-blue-500/20 border-t border-blue-500/20">
                    <p class="text-sm font-bold truncate text-white group-hover:text-blue-300 transition-colors">{{ $produk->nama_produk }}</p>
                    <p class="text-xs text-gray-400">Koleksi Digital</p>
                </div>
            </div>
        </a>
        @endforeach
        @else
        <p class="text-gray-500 col-span-full italic text-sm">Belum ada koleksi E-Book.</p>
        @endif
    </div>

    {{-- PULSA & TOKEN SECTION --}}
    @php
    $pulsaCategory = $kategoris->whereIn('nama_kategori', ['Pulsa Provider', 'Pulsa & Data', 'Pulsa'])->first();
    $tokenCategory = $kategoris->whereIn('nama_kategori', ['Token Listrik', 'Token'])->first();

    $pulsaGateBrand = $pulsaCategory ? $pulsaCategory->brands->first() : null;
    $tokenGateBrand = $tokenCategory ? $tokenCategory->brands->first() : null;
    @endphp

    <div id="utility-section" class="flex justify-between items-center mb-8 scroll-mt-24 section-glow">
        <h3 class="text-2xl font-black italic uppercase text-white galaxy-title flex items-center gap-3">
            <span class="w-2 h-8 bg-gradient-to-b from-yellow-500 to-orange-600 rounded-full shadow-[0_0_10px_rgba(234,179,8,0.5)]"></span> ⚡ Pulsa & Token Listrik
        </h3>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-12">

        @if($pulsaGateBrand)
        <a href="{{ route('produk.detail', $pulsaGateBrand->id_brand) }}" class="group block">
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-yellow-500/20 backdrop-blur-xl transition hover:-translate-y-2 hover:border-yellow-400/60 hover:shadow-[0_0_30px_rgba(234,179,8,0.3)] text-center float">
                <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-gradient-to-b from-yellow-500/10 to-black/40">
                    <span class="text-6xl group-hover:scale-110 transition duration-500">📶</span>
                    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                </div>
                <div class="px-4 py-3 bg-gradient-to-r from-yellow-500/20 via-orange-500/20 to-yellow-500/20 border-t border-yellow-500/20">
                    <p class="text-sm font-bold truncate text-white group-hover:text-yellow-300 transition-colors">Pulsa Semua Operator</p>
                    <p class="text-[10px] text-yellow-400/70 tracking-widest uppercase font-bold">⚡ DETEKSI OTOMATIS</p>
                </div>
            </div>
        </a>
        @endif

        @if($tokenGateBrand)
        <a href="{{ route('produk.detail', $tokenGateBrand->id_brand) }}" class="group block">
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-[#1a1c23] to-[#0f1116] border border-yellow-500/20 backdrop-blur-xl transition hover:-translate-y-2 hover:border-yellow-400/60 hover:shadow-[0_0_30px_rgba(234,179,8,0.3)] text-center float">
                <div class="relative h-44 flex items-center justify-center overflow-hidden rounded-t-2xl bg-gradient-to-b from-yellow-500/10 to-black/40">
                    <span class="text-6xl group-hover:scale-110 transition duration-500">⚡</span>
                    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                </div>
                <div class="px-4 py-3 bg-gradient-to-r from-yellow-500/20 via-orange-500/20 to-yellow-500/20 border-t border-yellow-500/20">
                    <p class="text-sm font-bold truncate text-white group-hover:text-yellow-300 transition-colors">{{ $tokenGateBrand->nama_brand }}</p>
                    <p class="text-[10px] text-yellow-400/70 tracking-widest uppercase font-bold">💳 Pembayaran Instan</p>
                </div>
            </div>
        </a>
        @endif

        @if(!$pulsaGateBrand && !$tokenGateBrand)
        <p class="text-gray-500 col-span-full italic text-sm">Kategori utilitas pulsa atau token belum tersedia di database.</p>
        @endif

    </div>
</div> {{-- AKHIR DARI MAIN CONTENT CONTAINER --}}

{{-- SEKSI ULASAN PELANGGAN (SOCIAL PROOF) --}}
@if(isset($ulasanPilihan) && $ulasanPilihan->isNotEmpty())
<div class="container mx-auto px-4 pb-16 max-w-6xl">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">Apa Kata Mereka?</h2>
        <p class="text-gray-400 text-sm mt-2">Ribuan transaksi berhasil setiap harinya di J-Store.</p>
    </div>

    {{-- KOTAK SCROLLER BERJALAN --}}
    <div class="relative max-h-[400px] overflow-hidden rounded-3xl bg-white/5 border border-white/10 backdrop-blur-sm p-6 shadow-2xl group">

        {{-- Efek blur transparan di atas dan bawah --}}
        <div class="absolute top-0 left-0 right-0 h-16 bg-gradient-to-b from-[#0f1116] to-transparent z-10 rounded-t-3xl"></div>
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-[#0f1116] to-transparent z-10 rounded-b-3xl"></div>

        {{-- Container yang dianimasikan --}}
        <div class="animate-scroll-vertical hover:[animation-play-state:paused] flex flex-col gap-4">

            {{-- Loop Ganda untuk Seamless Animation --}}
            @for ($i = 0; $i < 2; $i++)
                @foreach($ulasanPilihan as $ulasan)
                <div class="bg-black/40 border border-white/5 p-5 rounded-2xl flex items-start gap-4 transition-colors hover:border-white/10">
                <div class="w-12 h-12 bg-blue-600/20 rounded-full flex items-center justify-center text-blue-400 font-black text-xl shrink-0">
                    👤
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h4 class="text-white font-bold text-sm">{{ $ulasan->transaksi->user->name ?? 'Pembeli Rahasia' }}</h4>
                        <span class="text-[10px] bg-green-500/20 text-green-400 px-2 py-0.5 rounded-full font-bold uppercase tracking-widest">Verified</span>
                    </div>

                    {{-- Bintang Rating --}}
                    <div class="text-yellow-400 text-xs mb-2">
                        @for($s = 1; $s <= 5; $s++)
                            @if($s <=$ulasan->rating) ★ @else <span class="text-gray-600">★</span> @endif
                            @endfor
                    </div>

                    <p class="text-gray-300 text-sm italic">"{{ $ulasan->komentar }}"</p>

                    {{-- Nama Produk yang dibeli --}}
                    <div class="mt-3 inline-block bg-white/5 px-3 py-1 rounded-lg text-xs font-semibold text-gray-400 border border-white/5">
                        Membeli: <span class="text-blue-400">{{ $ulasan->transaksi->produk->nama_produk ?? 'Produk Digital' }}</span>
                    </div>
                </div>
        </div>
        @endforeach
        @endfor

    </div>
</div>
</div>

<style>
    .animate-scroll-vertical {
        animation: scrollVert 30s linear infinite;
    }

    @keyframes scrollVert {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-50%);
        }
    }
</style>
@endif

{{-- FLOATING WHATSAPP BUTTON --}}
<a href="https://wa.me/6285172280957" target="_blank"
    class="fixed bottom-8 right-8 z-50 flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full shadow-[0_0_30px_rgba(34,197,94,0.6)] hover:scale-110 active:scale-95 transition-all group border border-green-300/30 float">
    <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
    </svg>
    <span class="absolute right-20 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-xs font-black px-4 py-2 rounded-xl opacity-0 group-hover:opacity-100 transition-all whitespace-nowrap shadow-[0_0_15px_rgba(59,130,246,0.5)] pointer-events-none border border-blue-400/50">
        BANTUAN CS
    </span>
</a>
@endsection