@extends('layouts.app')

@section('content')

<div class="container mx-auto max-w-6xl px-4 py-10">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- SIDEBAR --}}
        <div class="lg:col-span-3">
            <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden backdrop-blur-xl sticky top-24">

                <div class="aspect-square bg-white flex items-center justify-center p-6">
                    @if($brand->gambar_brand)
                    <img src="{{ asset('storage/'.$brand->gambar_brand) }}" class="max-w-full max-h-full object-contain">
                    @else
                    <span class="text-7xl">📱</span>
                    @endif
                </div>

                <div class="p-6">
                    <h2 class="text-2xl font-black text-white">{{ $brand->nama_brand }}</h2>
                    <p class="text-sm text-purple-400 font-semibold mt-1">{{ $kategori->nama_kategori ?? 'Kategori Umum' }}</p>

                    <div class="mt-5 space-y-3">
                        @foreach(['Proses otomatis','Garansi aman','Support 24 jam'] as $feature)
                        <div class="flex items-center gap-3 text-sm text-gray-300">
                            <span class="text-green-400">●</span>
                            {{ $feature }}
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        {{-- CONTENT --}}
        <div class="lg:col-span-9">

            @if($errors->any())
            <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 p-4">
                <p class="font-semibold text-red-400 mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside text-sm text-red-300 space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('transaksi.checkout') }}" method="POST" class="space-y-6">
                @csrf

                {{-- STEP 1: MASUKKAN DATA --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl shadow-xl">

                    {{-- HEADER STEP 1 --}}
                    <div class="flex items-center gap-4 mb-6 border-b border-white/5 pb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-500/20 border border-blue-500/30 flex items-center justify-center shrink-0">
                            <span class="text-blue-400 font-black text-xl">1</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white uppercase tracking-wider">Masukkan Data</h3>
                            <p class="text-xs text-gray-400">Isi data pembeli terlebih dahulu</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">
                                Email / Catatan Request <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="id_target" required placeholder="contoh@email.com" autocomplete="off" class="w-full bg-black/30 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder:text-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">
                                Nomor WhatsApp (Opsional)
                            </label>
                            <input type="text" name="kontak_pelanggan" placeholder="08xxxxxxxxxx" autocomplete="off" class="w-full bg-black/30 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder:text-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                        </div>
                    </div>
                </div>

                {{-- STEP 2: PILIH PAKET --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl shadow-xl">

                    {{-- HEADER STEP 2 --}}
                    <div class="flex items-center gap-4 mb-6 border-b border-white/5 pb-4">
                        <div class="w-12 h-12 rounded-full bg-purple-500/20 border border-purple-500/30 flex items-center justify-center shrink-0">
                            <span class="text-purple-400 font-black text-xl">2</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white uppercase tracking-wider">Pilih Paket</h3>
                            <p class="text-xs text-gray-400">Pilih nominal atau paket yang tersedia</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($items as $produk)
                        <label class="cursor-pointer">
                            <input type="radio" name="id_produk" value="{{ $produk->id_produk }}" class="hidden peer id-produk-radio" data-name="{{ $produk->nama_produk }}" data-price="{{ number_format($produk->harga_produk,0,',','.') }}" data-raw-price="{{ $produk->harga_produk }}">

                            <div class="border border-white/10 bg-black/20 rounded-2xl p-5 transition hover:border-purple-500/50 peer-checked:border-purple-500 peer-checked:bg-purple-500/10">
                                <div class="flex justify-between gap-4">
                                    <div>
                                        <h4 class="text-white font-bold">{{ $produk->nama_produk }}</h4>
                                        <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-wider font-bold">Fast Process</p>
                                    </div>
                                    <p class="text-lg font-black text-purple-400">
                                        Rp {{ number_format($produk->harga_produk,0,',','.') }}
                                    </p>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- STEP 3: METODE PEMBAYARAN --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl shadow-xl">

                    {{-- HEADER STEP 3 --}}
                    <div class="flex items-center gap-4 mb-6 border-b border-white/5 pb-4">
                        <div class="w-12 h-12 rounded-full bg-pink-500/20 border border-pink-500/30 flex items-center justify-center shrink-0">
                            <span class="text-pink-400 font-black text-xl">3</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white uppercase tracking-wider">Metode Pembayaran</h3>
                            <p class="text-xs text-gray-400">Pilih metode pembayaran yang tersedia</p>
                        </div>
                    </div>

                    @php
                    // PERBAIKAN: Menuliskan class Tailwind secara penuh agar tidak diabaikan oleh compiler
                    $payments = [
                    ['bca_va', 'BCA', 'Virtual Account', 'hover:border-blue-500 peer-checked:border-blue-500 peer-checked:bg-blue-500/10'],
                    ['echannel', 'Mandiri', 'Virtual Account', 'hover:border-yellow-500 peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10'],
                    ['shopeepay', 'ShopeePay', '', 'hover:border-orange-500 peer-checked:border-orange-500 peer-checked:bg-orange-500/10'],
                    ['gopay', 'GoPay', '', 'hover:border-green-500 peer-checked:border-green-500 peer-checked:bg-green-500/10'],
                    ['dana', 'DANA', '', 'hover:border-cyan-500 peer-checked:border-cyan-500 peer-checked:bg-cyan-500/10'],
                    ];
                    @endphp

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($payments as $pay)
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="{{ $pay[0] }}" class="hidden peer">
                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex flex-col items-center justify-center text-white font-bold transition {{ $pay[3] }}">
                                <span>{{ $pay[1] }}</span>
                                @if($pay[2])
                                <span class="text-[10px] text-gray-400 font-normal mt-1">{{ $pay[2] }}</span>
                                @endif
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- STEP 4: DETAIL PESANAN --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl shadow-xl">

                    {{-- HEADER STEP 4 --}}
                    <div class="flex items-center gap-4 mb-6 border-b border-white/5 pb-4">
                        <div class="w-12 h-12 rounded-full bg-orange-500/20 border border-orange-500/30 flex items-center justify-center shrink-0">
                            <span class="text-orange-400 font-black text-xl">4</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white uppercase tracking-wider">Detail Pesanan</h3>
                            <p class="text-xs text-gray-400">Ringkasan transaksi Anda</p>
                        </div>
                    </div>

                    <div class="mb-6 bg-black/20 p-5 rounded-2xl border border-white/5">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                            Punya Kode Promo?
                        </label>

                        <div class="flex gap-3">
                            <input type="hidden" id="hidden_kode_promo" name="kode_promo">
                            <input type="text" id="input_kode_promo" class="w-full bg-black/30 border border-white/10 rounded-xl px-4 py-3 text-white uppercase placeholder:text-gray-600 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition" placeholder="MASUKKAN KODE...">
                            <button type="button" id="btn_terapkan_promo" class="bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-xl font-bold text-white transition active:scale-95">
                                Terapkan
                            </button>
                        </div>
                        <p id="pesan_promo" class="text-xs mt-2 hidden font-bold"></p>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 border-t border-white/10 pt-6">
                        <div>
                            <p id="selected-product" class="text-sm text-gray-400 font-bold">
                                Belum memilih paket
                            </p>
                            <p id="tampil_diskon" class="hidden text-green-400 text-xs font-bold mt-1"></p>
                            <h2 id="selected-price" class="text-4xl font-black text-white mt-1">
                                Rp 0
                            </h2>
                        </div>

                        <button type="submit" id="submit_button" disabled class="px-10 py-4 rounded-2xl bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-black uppercase tracking-widest shadow-xl transition active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                            Beli Sekarang
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Deklarasi Elemen
        const radios = document.querySelectorAll('.id-produk-radio');
        const selectedProduct = document.getElementById('selected-product');
        const selectedPrice = document.getElementById('selected-price');
        const submitButton = document.getElementById('submit_button');

        const btnPromo = document.getElementById('btn_terapkan_promo');
        const inputPromo = document.getElementById('input_kode_promo');
        const hiddenPromo = document.getElementById('hidden_kode_promo');
        const pesanPromo = document.getElementById('pesan_promo');
        const tampilDiskon = document.getElementById('tampil_diskon');

        // State Variabel
        let currentSelectedPrice = 0;
        let currentDiscount = 0;

        // 1. Logika Pemilihan Paket
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                selectedProduct.textContent = this.dataset.name;
                currentSelectedPrice = parseInt(this.dataset.rawPrice); // Ambil angka murni

                // Jika user mengganti paket saat promo aktif, reset promo agar aman (validasi min_belanja)
                if (hiddenPromo.value !== '') {
                    inputPromo.value = '';
                    tampilkanPesan('Paket diubah. Silakan terapkan ulang kode promo.', 'yellow');
                    resetPromoUI();
                } else {
                    updatePriceDisplay();
                }

                submitButton.disabled = false;
            });
        });

        // 2. Logika Pengecekan Promo via AJAX
        btnPromo.addEventListener('click', async function() {
            const kode = inputPromo.value.trim().toUpperCase();

            if (!kode) {
                tampilkanPesan('Silakan masukkan kode promo.', 'red');
                return;
            }

            if (currentSelectedPrice === 0) {
                tampilkanPesan('Silakan pilih paket produk di Step 2 terlebih dahulu.', 'red');
                return;
            }

            btnPromo.textContent = '...';
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
                    tampilkanPesan(result.message, 'green');
                    hiddenPromo.value = kode;
                    currentDiscount = result.potongan_harga;

                    tampilDiskon.textContent = '- Diskon: Rp ' + new Intl.NumberFormat('id-ID').format(currentDiscount);
                    tampilDiskon.classList.remove('hidden');

                    updatePriceDisplay();
                } else {
                    tampilkanPesan(result.message, 'red');
                    resetPromoUI();
                }
            } catch (error) {
                tampilkanPesan('Terjadi kesalahan jaringan atau server.', 'red');
                resetPromoUI();
            } finally {
                btnPromo.textContent = 'Terapkan';
                btnPromo.disabled = false;
            }
        });

        // 3. Fungsi Bantuan
        function tampilkanPesan(text, color) {
            pesanPromo.textContent = text;
            pesanPromo.className = `text-xs mt-2 text-${color}-400 font-medium`;
            pesanPromo.classList.remove('hidden');
        }

        function resetPromoUI() {
            hiddenPromo.value = '';
            currentDiscount = 0;
            tampilDiskon.classList.add('hidden');
            updatePriceDisplay();
        }

        function updatePriceDisplay() {
            const totalAkhir = Math.max(0, currentSelectedPrice - currentDiscount);
            selectedPrice.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalAkhir);
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const radios = document.querySelectorAll('.id-produk-radio');
        const selectedProductText = document.getElementById('selected-product');
        const selectedPriceText = document.getElementById('selected-price');
        const submitButton = document.getElementById('submit_button');

        radios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                // Aktifkan tombol beli jika produk dipilih
                submitButton.disabled = false;

                // Update teks ringkasan
                selectedProductText.innerText = e.target.dataset.name;
                selectedPriceText.innerText = 'Rp ' + e.target.dataset.price;
            });
        });
    });
</script>
@endsection