@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 md:px-16 max-w-5xl">
    {{-- BANNER DINAMIS --}}
    <div class="relative w-full h-48 md:h-64 rounded-4xl overflow-hidden border border-white/10 mb-8 shadow-2xl">
        <img src="{{ $kategori->gambar_kategori ? asset('storage/' . $kategori->gambar_kategori) : asset('images/default-banner.png') }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>
        <div class="absolute bottom-6 left-8">
            <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">{{ $kategori->nama_kategori }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8">
        {{-- STEP 1: DINAMIS (Sembunyikan jika E-book) --}}
        <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
            <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm text-white">1</span>
                Informasi Pengiriman
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <input type="email" name="email" required placeholder="Alamat Email Aktif"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    <p class="text-[10px] text-red-400 italic ml-1">* Pastikan email tidak penuh (Inbox tersedia)</p>
                </div>
                <div class="space-y-2">
                    <input type="number" name="whatsapp" placeholder="Nomor WhatsApp (Opsional)"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-green-500 outline-none">
                    <p class="text-[10px] text-gray-400 italic ml-1">* Untuk notifikasi pengiriman cepat</p>
                </div>
            </div>
        </div>

        {{-- STEP 2: PILIH PRODUK --}}
        <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
            <h3 class="flex items-center gap-3 font-bold mb-6 text-white">
                <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm text-white">
                    {{ Str::contains(Str::lower($kategori->nama_kategori), 'book') ? '1' : '2' }}
                </span>
                Pilih Produk {{ $kategori->nama_kategori }}
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($items as $item)
                <button onclick="selectItem('{{ $item->nama_produk }}', '{{ number_format($item->harga_produk, 0, ',', '.') }}')"
                    class="bg-black/20 border border-white/5 rounded-2xl p-4 hover:border-blue-500 transition-all text-left group">
                    <p class="text-[10px] font-bold text-gray-400 group-hover:text-blue-400 mb-1">{{ $item->nama_produk }}</p>
                    <p class="text-sm font-black text-white">Rp {{ number_format($item->harga_produk, 0, ',', '.') }}</p>
                </button>
                @endforeach
            </div>
        </div>

        {{-- STEP 3: PEMBAYARAN --}}
        <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl mb-24">
            <h3 class="flex items-center gap-3 font-bold mb-6 text-white">
                <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm text-white text-white">
                    {{ Str::contains(Str::lower($kategori->nama_kategori), 'book') ? '2' : '3' }}
                </span>
                Metode Bayar
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-3 rounded-xl flex items-center justify-center h-12 cursor-pointer border-2 border-transparent hover:border-blue-500 transition">
                    <img src="{{ asset('images/payment/gopay.png') }}" class="h-6 object-contain">
                </div>
                <div class="bg-white p-3 rounded-xl flex items-center justify-center h-12 cursor-pointer border-2 border-transparent hover:border-blue-500 transition">
                    <img src="{{ asset('images/payment/dana.png') }}" class="h-6 object-contain">
                </div>
            </div>
        </div>

        {{-- FLOATING BAR --}}
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-5xl bg-white/10 backdrop-blur-2xl border border-white/20 p-4 rounded-3xl flex items-center justify-between shadow-2xl z-50">
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase">Terpilih:</p>
                <p id="display-item" class="text-xs font-bold text-white truncate max-w-[150px]">-</p>
                <p id="display-price" class="text-xl font-black text-[#DFFF00]">Rp 0</p>
            </div>
            <button class="bg-blue-600 px-8 py-3 rounded-2xl font-black text-sm text-white hover:bg-blue-700 transition-all active:scale-95 shadow-lg shadow-blue-600/20">
                BELI SEKARANG
            </button>
        </div>
    </div>
</div>

<script>
    function selectItem(name, price) {
        document.getElementById('display-item').innerText = name;
        document.getElementById('display-price').innerText = 'Rp ' + price;
    }
</script>
@endsection