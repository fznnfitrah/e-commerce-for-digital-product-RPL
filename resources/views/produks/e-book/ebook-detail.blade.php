@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 md:px-16 max-w-5xl">

    {{-- LOGIKA PINTAR: Cari produk yang ID-nya sama dengan parameter '?selected=' di URL --}}
    @php
        $selectedProduct = $items->firstWhere('id_produk', request('selected')) ?? $items->first();
    @endphp

    <form action="{{ route('transaksi.checkout') }}" method="POST" id="form-ebook">
        @csrf

        {{-- KUNCI UTAMA: Input hidden agar sistem tahu buku apa yang sedang dibeli --}}
        <input type="hidden" name="id_produk" value="{{ $selectedProduct->id_produk }}">

        {{-- BANNER DINAMIS --}}
        <div class="relative w-full h-48 md:h-64 rounded-4xl overflow-hidden border border-white/10 mb-8 shadow-2xl">
            <img src="{{ $selectedProduct->gambar_produk ? asset('storage/' . $selectedProduct->gambar_produk) : asset('images/default-banner.png') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-6 left-8">
                <p class="text-blue-400 font-bold uppercase tracking-widest text-sm mb-1">E-Book Digital</p>
                <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">{{ $selectedProduct->nama_produk }}</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8">

            {{-- STEP 1: INFORMASI PENGIRIMAN --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm text-white">1</span>
                    Informasi Pengiriman
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Alamat Email Aktif (Wajib)</label>
                        <input type="email" name="id_target" value="{{ old('id_target') }}" required placeholder="Contoh: user@email.com"
                            class="w-full bg-black/40 border @error('id_target') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                        @error('id_target')
                            <p class="text-red-500 text-xs font-semibold ml-1">{{ $message }}</p>
                        @else
                            <p class="text-[10px] text-gray-400 italic ml-1">* File E-book akan dikirimkan ke email ini</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Nomor WhatsApp (Opsional)</label>
                        <input type="number" name="kontak_pelanggan" value="{{ old('kontak_pelanggan') }}" placeholder="Contoh: 0812xxxx"
                            class="w-full bg-black/40 border @error('kontak_pelanggan') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                        @error('kontak_pelanggan')
                            <p class="text-red-500 text-xs font-semibold ml-1">{{ $message }}</p>
                        @else
                            <p class="text-[10px] text-gray-400 italic ml-1">* Untuk notifikasi / panduan pembayaran</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- STEP 2: DETAIL PESANAN & PROMO --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm text-white">2</span>
                    Detail Pesanan
                </h3>

                <div class="flex items-center gap-5 bg-black/40 p-5 rounded-2xl border border-white/5 mb-4">
                    <div class="w-16 h-20 md:w-20 md:h-28 bg-gray-800 rounded-lg overflow-hidden shrink-0 border border-white/10 shadow-lg">
                        <img src="{{ $selectedProduct->gambar_produk ? asset('storage/' . $selectedProduct->gambar_produk) : asset('images/ebook-placeholder.png') }}" class="w-full h-full object-cover">
                    </div>

                    <div class="flex-1">
                        <h4 class="text-lg md:text-xl font-black text-white leading-tight">{{ $selectedProduct->nama_produk }}</h4>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $selectedProduct->deskripsi_produk ?? 'Buku digital berformat PDF. Dikirim otomatis setelah pembayaran berhasil.' }}</p>
                        <p class="text-[#DFFF00] font-black text-lg md:text-xl mt-2">Rp {{ number_format($selectedProduct->harga_produk, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- AREA PROMO --}}
                <div class="pt-4 border-t border-white/10">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase ml-1 mb-2">Punya Kode Promo?</label>
                    <div class="flex gap-2">
                        <input type="hidden" name="kode_promo" id="hidden_kode_promo" value="">
                        <input type="text" id="input_kode_promo" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition uppercase placeholder:text-gray-500" placeholder="MASUKKAN KODE...">
                        <button type="button" id="btn_terapkan_promo" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-bold text-sm transition-colors shadow-lg shadow-blue-600/30">Terapkan</button>
                    </div>
                    <p id="pesan_promo" class="text-xs mt-2 font-semibold hidden ml-1"></p>
                </div>
            </div>

            {{-- STEP 3: METODE PEMBAYARAN --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl mb-32">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm text-white">3</span>
                    Metode Bayar
                </h3>

                @error('metode_pembayaran')
                <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-500 text-sm font-semibold">
                    Pilih metode pembayaran terlebih dahulu.
                </div>
                @enderror

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    {{-- DANA --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="dana" class="hidden peer" {{ old('metode_pembayaran') == 'dana' ? 'checked' : '' }} required>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex items-center justify-center transition peer-checked:border-cyan-500 peer-checked:bg-cyan-500/10 hover:border-cyan-400">
                            <span class="text-cyan-400 font-black text-sm uppercase">DANA</span>
                        </div>
                    </label>

                    {{-- GOPAY --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="gopay" class="hidden peer" {{ old('metode_pembayaran') == 'gopay' ? 'checked' : '' }}>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex items-center justify-center transition peer-checked:border-green-500 peer-checked:bg-green-500/10 hover:border-green-400">
                            <span class="text-green-400 font-black text-sm uppercase">GoPay</span>
                        </div>
                    </label>

                    {{-- BCA VA --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="bca_va" class="hidden peer" {{ old('metode_pembayaran') == 'bca_va' ? 'checked' : '' }}>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex flex-col items-center justify-center transition peer-checked:border-blue-600 peer-checked:bg-blue-600/10 hover:border-blue-500">
                            <span class="text-blue-500 font-black text-xs uppercase">BCA VA</span>
                        </div>
                    </label>

                    {{-- MANDIRI VA --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="echannel" class="hidden peer" {{ old('metode_pembayaran') == 'echannel' ? 'checked' : '' }}>
                        <div class="h-14 rounded-xl border border-white/10 bg-black/30 flex flex-col items-center justify-center transition peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10 hover:border-yellow-400">
                            <span class="text-yellow-500 font-black text-xs uppercase">MANDIRI VA</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- FLOATING BAR (STATIS + DINAMIS DISKON) --}}
            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-5xl bg-black/60 backdrop-blur-2xl border border-white/20 p-4 rounded-3xl flex items-center justify-between shadow-2xl z-50">
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Total Pembayaran:</p>
                    <p class="text-sm font-bold text-white truncate max-w-[150px] md:max-w-[300px]">{{ $selectedProduct->nama_produk }}</p>
                    
                    {{-- Tambahan Teks Diskon --}}
                    <p id="tampil_diskon" class="text-xs text-green-400 font-bold hidden">- Diskon: Rp 0</p>
                    
                    {{-- ID pada Total Harga --}}
                    <p id="tampil_total_akhir" class="text-xl font-black text-[#DFFF00]">Rp {{ number_format($selectedProduct->harga_produk, 0, ',', '.') }}</p>
                </div>
                <button type="submit" class="bg-blue-600 px-6 py-3 md:px-8 md:py-4 rounded-2xl font-black text-sm text-white hover:bg-blue-500 transition-all active:scale-95 shadow-lg shadow-blue-600/30">
                    BELI SEKARANG
                </button>
            </div>

        </div>
    </form>
</div>

{{-- SCRIPT AJAX PROMO --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnPromo = document.getElementById('btn_terapkan_promo');
        const inputPromo = document.getElementById('input_kode_promo');
        const hiddenPromo = document.getElementById('hidden_kode_promo');
        const pesanPromo = document.getElementById('pesan_promo');
        const tampilDiskon = document.getElementById('tampil_diskon');
        const tampilTotal = document.getElementById('tampil_total_akhir');

        // Harga statis karena e-book sudah di-lock oleh URL
        const currentSelectedPrice = {{ $selectedProduct->harga_produk }};
        let currentDiscount = 0;

        btnPromo.addEventListener('click', async function() {
            const kode = inputPromo.value.trim().toUpperCase();

            if (!kode) {
                tampilkanPesan('Silakan masukkan kode promo.', 'text-red-500');
                return;
            }

            btnPromo.textContent = 'Mengecek...';
            btnPromo.disabled = true;

            try {
                const response = await fetch("{{ route('transaksi.cek-promo') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        kode_promo: kode,
                        total_pembelian: currentSelectedPrice
                    })
                });

                const result = await response.json();

                if (result.status === 'success') {
                    tampilkanPesan(result.message, 'text-green-500');
                    hiddenPromo.value = kode;
                    currentDiscount = result.potongan_harga;

                    // Update UI Harga di Floating Bar
                    tampilDiskon.textContent = '- Diskon: Rp ' + new Intl.NumberFormat('id-ID').format(currentDiscount);
                    tampilDiskon.classList.remove('hidden');

                    const totalAkhir = Math.max(0, currentSelectedPrice - currentDiscount);
                    tampilTotal.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalAkhir);
                } else {
                    tampilkanPesan(result.message, 'text-red-500');
                    resetPromoUI();
                }
            } catch (error) {
                tampilkanPesan('Terjadi kesalahan jaringan atau server.', 'text-red-500');
                resetPromoUI();
            } finally {
                btnPromo.textContent = 'Terapkan';
                btnPromo.disabled = false;
            }
        });

        function tampilkanPesan(text, colorClass) {
            pesanPromo.textContent = text;
            // Hapus semua class warna sebelumnya lalu tambahkan yang baru
            pesanPromo.classList.remove('text-red-500', 'text-green-500', 'text-yellow-500');
            pesanPromo.classList.add(colorClass);
            pesanPromo.classList.remove('hidden');
        }

        function resetPromoUI() {
            hiddenPromo.value = '';
            currentDiscount = 0;
            tampilDiskon.classList.add('hidden');
            tampilTotal.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(currentSelectedPrice);
        }
    });
</script>
@endsection