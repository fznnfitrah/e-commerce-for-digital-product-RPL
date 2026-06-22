@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 md:px-16 max-w-5xl">

    <form action="{{ route('transaksi.checkout') }}" method="POST" id="form-topup">
        @csrf

        {{-- BANNER PRODUK --}}
        <div class="relative w-full h-48 md:h-64 rounded-4xl overflow-hidden border border-white/10 mb-8 shadow-2xl">
            <img src="{{ asset('images/banner-ml.png') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
            <div class="absolute bottom-6 left-8">
                <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">{{ $kategori->nama_kategori }}</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8">

            {{-- STEP 1: MASUKKAN ID & KONTAK --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                    Informasi Akun & Kontak
                </h3>
                <input type="hidden" name="id_target" id="hidden_id_target" value="{{ old('id_target') }}" required>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Data Game</label>
                        <div class="flex gap-2">
                            <input type="text" id="visual_user_id" placeholder="User ID" class="w-2/3 bg-black/40 border @error('id_target') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                            <input type="text" id="visual_zone_id" placeholder="Zone ID" class="w-1/3 bg-black/40 border @error('id_target') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                        </div>
                        @error('id_target') <p class="text-red-500 text-xs font-semibold">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block">WhatsApp / Email</label>
                        <input type="text" name="kontak_pelanggan" value="{{ old('kontak_pelanggan') }}" placeholder="Untuk bukti top-up" required class="w-full bg-black/40 border @error('kontak_pelanggan') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>
            </div>

            {{-- STEP 2: NOMINAL --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                    Pilih Nominal
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($items as $item)
                    <label class="cursor-pointer group">
                        <input type="radio" name="id_produk" value="{{ $item->id_produk }}" class="peer hidden input-produk"
                            data-name="{{ $item->nama_produk }}"
                            data-raw-price="{{ $item->harga_produk }}"
                            data-price="{{ number_format($item->harga_produk, 0, ',', '.') }}" required>
                        <div class="bg-black/20 border border-white/5 rounded-2xl p-4 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-500/20 hover:border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold text-gray-400 group-hover:text-blue-400">{{ $item->nama_produk }}</span>
                            </div>
                            <p class="text-sm font-black text-white">Rp {{ number_format($item->harga_produk, 0, ',', '.') }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- STEP 3 & 4 (PROMO & BAYAR) --}}
            <div class="bg-white/10 backdrop-blur-md rounded-4xl border border-white/10 p-6 shadow-xl mb-32">
                <h3 class="flex items-center gap-3 font-bold mb-4 text-white">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span>
                    Metode Pembayaran & Promo
                </h3>

                {{-- Metode Pembayaran (Tetap seperti kode lama Anda) --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    {{-- [Isi radio button metode bayar tetap sama seperti kode Anda] --}}
                </div>

                {{-- AREA PROMO --}}
                <div class="pt-6 border-t border-white/10">
                    <label class="block text-xs font-bold text-yellow-500 uppercase tracking-widest mb-3">Punya Kode Promo?</label>
                    <div class="flex gap-3">
                        <input type="hidden" name="kode_promo" id="hidden_kode_promo" value="">
                        <input type="text" id="input_kode_promo" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-yellow-500 outline-none transition uppercase placeholder:text-gray-500" placeholder="MASUKKAN KODE...">
                        <button type="button" id="btn_terapkan_promo" class="bg-yellow-600 hover:bg-yellow-500 text-black px-6 py-3 rounded-xl font-bold text-sm transition-colors shadow-lg shadow-yellow-600/20">Terapkan</button>
                    </div>
                    <p id="pesan_promo" class="text-xs mt-2 font-semibold hidden ml-1"></p>
                </div>
            </div>

            {{-- FLOATING PURCHASE BAR --}}
            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-5xl bg-black/80 backdrop-blur-2xl border border-white/20 p-4 rounded-3xl flex items-center justify-between shadow-2xl z-50">
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Item Terpilih:</p>
                    <p id="display-item" class="text-sm font-bold text-white truncate max-w-[150px] md:max-w-[300px]">Belum memilih item</p>
                    <p id="tampil_diskon" class="text-xs text-green-400 font-bold hidden">- Diskon: Rp 0</p>
                    <p id="display-price" class="text-xl font-black text-[#DFFF00]">Rp 0</p>
                </div>
                <button type="submit" class="bg-blue-600 px-6 py-3 md:px-10 rounded-2xl font-black text-sm text-white hover:bg-blue-500 transition-all active:scale-95 shadow-lg shadow-blue-600/30">
                    BELI SEKARANG
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const visualUserId = document.getElementById('visual_user_id');
        const visualZoneId = document.getElementById('visual_zone_id');
        const hiddenIdTarget = document.getElementById('hidden_id_target');
        const productRadios = document.querySelectorAll('.input-produk');
        const displayItem = document.getElementById('display-item');
        const displayPrice = document.getElementById('display-price');

        // Elemen Promo
        const btnPromo = document.getElementById('btn_terapkan_promo');
        const inputPromo = document.getElementById('input_kode_promo');
        const hiddenPromo = document.getElementById('hidden_kode_promo');
        const pesanPromo = document.getElementById('pesan_promo');
        const tampilDiskon = document.getElementById('tampil_diskon');

        let currentSelectedPrice = 0;
        let currentDiscount = 0;

        function updateHiddenId() {
            hiddenIdTarget.value = `${visualUserId.value.trim()} (${visualZoneId.value.trim()})`;
        }
        visualUserId.addEventListener('input', updateHiddenId);
        visualZoneId.addEventListener('input', updateHiddenId);

        productRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                currentSelectedPrice = parseInt(this.dataset.rawPrice);
                displayItem.innerText = this.dataset.name;

                if (hiddenPromo.value !== '') {
                    inputPromo.value = '';
                    tampilkanPesan('Nominal diubah. Terapkan ulang promo.', 'text-yellow-400');
                    resetPromoUI();
                } else {
                    updatePriceDisplay();
                }
            });
        });

        // Logika Promo
        btnPromo.addEventListener('click', async function() {
            const kode = inputPromo.value.trim().toUpperCase();
            if (!kode || currentSelectedPrice === 0) return tampilkanPesan('Pilih nominal & masukkan kode.', 'text-red-500');

            btnPromo.textContent = '...';
            try {
                const response = await fetch("{{ route('transaksi.cek-promo') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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
                    tampilDiskon.textContent = '- Diskon: Rp ' + new Intl.NumberFormat('id-ID').format(currentDiscount);
                    tampilDiskon.classList.remove('hidden');
                    updatePriceDisplay();
                } else {
                    tampilkanPesan(result.message, 'text-red-500');
                    resetPromoUI();
                }
            } catch {
                tampilkanPesan('Server Error', 'text-red-500');
            }
            btnPromo.textContent = 'Terapkan';
        });

        function tampilkanPesan(text, cls) {
            pesanPromo.textContent = text;
            pesanPromo.className = `text-xs mt-2 font-bold ${cls}`;
            pesanPromo.classList.remove('hidden');
        }

        function resetPromoUI() {
            hiddenPromo.value = '';
            currentDiscount = 0;
            tampilDiskon.classList.add('hidden');
            updatePriceDisplay();
        }

        function updatePriceDisplay() {
            displayPrice.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.max(0, currentSelectedPrice - currentDiscount));
        }
    });
</script>
@endsection