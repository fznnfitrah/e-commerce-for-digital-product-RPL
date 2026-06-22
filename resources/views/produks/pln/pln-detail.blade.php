@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">

    <form action="{{ route('transaksi.checkout') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-6" id="form-pln">
        @csrf

        {{-- SIDEBAR PRODUK --}}
        <div class="lg:col-span-4">
            <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden backdrop-blur-xl sticky top-24 shadow-xl">

                {{-- IMAGE --}}
                <div class="relative h-64 bg-black/30 overflow-hidden">
                    @if($brand->gambar_brand)
                    <img src="{{ asset('storage/' . $brand->gambar_brand) }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-7xl">⚡</div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f1117] via-transparent to-transparent"></div>
                </div>

                {{-- INFO --}}
                <div class="p-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-xs font-bold uppercase tracking-widest mb-4">
                        ⚡ Token Listrik
                    </div>

                    <h2 class="text-2xl font-black text-white leading-tight uppercase">
                        {{ $brand->nama_brand }}
                    </h2>

                    <p class="text-sm text-gray-400 mt-3 leading-relaxed">
                        Isi token listrik PLN prabayar secara instan, cepat, dan otomatis 24 jam.
                    </p>

                    <div class="mt-6 space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Proses</span>
                            <span class="font-bold text-green-400">Instan</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Status</span>
                            <span class="font-bold text-blue-400">Aktif 24 Jam</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Kategori</span>
                            <span class="font-bold text-white">PLN Prabayar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- STEP 1: INFORMASI PELANGGAN --}}
            <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl shadow-xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-yellow-500 text-black flex items-center justify-center font-black text-sm">1</div>
                    <div>
                        <h3 class="text-lg font-black text-white uppercase">Informasi Pelanggan</h3>
                        <p class="text-xs text-gray-400">Masukkan ID Meter dan Kontak Anda</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="text-xs uppercase tracking-widest text-gray-500 font-bold block mb-3">Nomor Meter / ID Pelanggan</label>
                        <div class="relative">
                            <input type="number" id="id_pelanggan" name="id_target" value="{{ old('id_target') }}" placeholder="Contoh: 14123456789" required autocomplete="off"
                                class="w-full bg-black/40 border @error('id_target') border-red-500 @else border-white/10 @enderror rounded-2xl px-5 py-4 text-white text-lg font-bold tracking-wide focus:ring-2 focus:ring-yellow-500 outline-none transition">
                            <div id="status_badge" class="hidden absolute right-4 top-1/2 -translate-y-1/2 px-4 py-2 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-xs font-black uppercase">
                                ✓ Valid
                            </div>
                        </div>
                        @error('id_target')
                        <p class="text-red-500 text-sm mt-2 font-semibold">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">Minimal 11 digit dan maksimal 12 digit.</p>
                    </div>

                    <div>
                        <label class="text-xs uppercase tracking-widest text-gray-500 font-bold block mb-3">WhatsApp / Email (Pengiriman Token)</label>
                        <input type="text" name="kontak_pelanggan" value="{{ old('kontak_pelanggan') }}" placeholder="Contoh: 081234567890 atau email@anda.com" required autocomplete="off"
                            class="w-full bg-black/40 border @error('kontak_pelanggan') border-red-500 @else border-white/10 @enderror rounded-2xl px-5 py-4 text-white text-lg font-bold tracking-wide focus:ring-2 focus:ring-yellow-500 outline-none transition">
                        @error('kontak_pelanggan')
                        <p class="text-red-500 text-sm mt-2 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- STEP 2: PRODUK --}}
            <div id="nominal_section" class="{{ old('id_target') ? '' : 'hidden' }} bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl shadow-xl animate-fade-in">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-yellow-500 text-black flex items-center justify-center font-black text-sm">2</div>
                    <div>
                        <h3 class="text-lg font-black text-white uppercase">Pilih Nominal Token</h3>
                        <p class="text-xs text-gray-400">Pilih nominal token listrik</p>
                    </div>
                </div>

                @error('id_produk')
                <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-500 text-sm font-semibold">Pilih produk nominal terlebih dahulu.</div>
                @enderror

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($items as $produk)
                    <label class="group cursor-pointer">
                        {{-- KUNCI PROMO: Tambahkan data-raw-price --}}
                        <input type="radio" name="id_produk" value="{{ $produk->id_produk }}" class="peer hidden id-produk-radio"
                            data-raw-price="{{ $produk->harga_produk }}"
                            {{ old('id_produk') == $produk->id_produk ? 'checked' : '' }} required>

                        <div class="h-full rounded-2xl border border-white/10 bg-black/20 p-5 transition-all duration-300 hover:border-yellow-500/50 hover:-translate-y-1 peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h4 class="text-white font-black text-base">{{ $produk->nama_produk }}</h4>
                                    <p class="text-xs text-gray-400 mt-1">PLN Prabayar</p>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 border-white/20 peer-checked:border-yellow-500 flex items-center justify-center">
                                    <div class="w-2 h-2 rounded-full bg-yellow-500 hidden peer-checked:block"></div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <span class="text-yellow-400 text-lg font-black price-text">
                                    Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- STEP 3: METODE PEMBAYARAN --}}
            <div id="payment_section" class="{{ old('id_produk') ? '' : 'hidden' }} bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl shadow-xl animate-fade-in">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-yellow-500 text-black flex items-center justify-center font-black text-sm">3</div>
                    <div>
                        <h3 class="text-lg font-black text-white uppercase">Pilih Metode Pembayaran</h3>
                        <p class="text-xs text-gray-400">Gunakan E-Wallet atau Transfer Bank (VA)</p>
                    </div>
                </div>

                @error('metode_pembayaran')
                <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-500 text-sm font-semibold">Pilih metode pembayaran terlebih dahulu.</div>
                @enderror

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    {{-- DANA --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="dana" class="peer hidden" {{ old('metode_pembayaran') == 'dana' ? 'checked' : '' }} required>
                        <div class="h-20 rounded-2xl border border-white/10 bg-black/30 flex items-center justify-center hover:border-cyan-500 transition peer-checked:border-cyan-500 peer-checked:bg-cyan-500/10">
                            <span class="text-white font-black text-lg uppercase">DANA</span>
                        </div>
                    </label>

                    {{-- GOPAY --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="gopay" class="peer hidden" {{ old('metode_pembayaran') == 'gopay' ? 'checked' : '' }}>
                        <div class="h-20 rounded-2xl border border-white/10 bg-black/30 flex items-center justify-center hover:border-green-500 transition peer-checked:border-green-500 peer-checked:bg-green-500/10">
                            <span class="text-white font-black text-lg uppercase">GOPAY</span>
                        </div>
                    </label>

                    {{-- BCA VA --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="bca_va" class="peer hidden" {{ old('metode_pembayaran') == 'bca_va' ? 'checked' : '' }}>
                        <div class="h-20 rounded-2xl border border-white/10 bg-black/30 flex flex-col items-center justify-center hover:border-blue-600 transition peer-checked:border-blue-600 peer-checked:bg-blue-600/10">
                            <span class="text-white font-black text-lg uppercase">BCA</span>
                            <span class="text-xs text-gray-400">Virtual Account</span>
                        </div>
                    </label>

                    {{-- MANDIRI VA --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="metode_pembayaran" value="echannel" class="peer hidden" {{ old('metode_pembayaran') == 'echannel' ? 'checked' : '' }}>
                        <div class="h-20 rounded-2xl border border-white/10 bg-black/30 flex flex-col items-center justify-center hover:border-yellow-500 transition peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10">
                            <span class="text-white font-black text-lg uppercase">MANDIRI</span>
                            <span class="text-xs text-gray-400">Virtual Account</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- STEP 4: DETAIL & SUBMIT --}}
            <div id="submit_section" class="{{ old('id_produk') ? '' : 'hidden' }} bg-gradient-to-r from-yellow-500/10 to-orange-500/10 border border-yellow-500/20 rounded-3xl p-6 backdrop-blur-xl shadow-xl animate-fade-in">

                {{-- AREA INPUT PROMO --}}
                <div class="mb-6 pb-6 border-b border-yellow-500/20">
                    <label class="block text-xs font-bold text-yellow-500 uppercase tracking-widest mb-3">Punya Kode Promo?</label>
                    <div class="flex gap-3">
                        <input type="hidden" name="kode_promo" id="hidden_kode_promo" value="">
                        <input type="text" id="input_kode_promo" class="w-full bg-black/30 border border-yellow-500/20 rounded-xl px-4 py-3 text-white uppercase placeholder:text-gray-500 focus:ring-2 focus:ring-yellow-500 outline-none transition" placeholder="MASUKKAN KODE...">
                        <button type="button" id="btn_terapkan_promo" class="bg-yellow-600 hover:bg-yellow-500 text-black px-6 py-3 rounded-xl font-bold transition-colors shadow-lg shadow-yellow-600/20 whitespace-nowrap">Terapkan</button>
                    </div>
                    <p id="pesan_promo" class="text-xs mt-2 font-semibold hidden"></p>
                </div>

                {{-- AREA TOTAL HARGA --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-400 font-bold">Total Pembayaran</p>
                        <p id="tampil_diskon" class="text-sm text-green-400 font-bold hidden mt-1">- Diskon: Rp 0</p>
                        <h3 id="price_preview" class="text-4xl font-black text-white mt-1">Rp 0</h3>
                        <p class="text-xs text-gray-500 mt-2">Pastikan data pelanggan sudah benar.</p>
                    </div>
                    <button type="submit" class="px-10 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-black font-black uppercase tracking-widest transition active:scale-95 shadow-xl shadow-yellow-500/20">
                        Bayar Sekarang
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Deklarasi Elemen Form PLN
        const idInput = document.getElementById('id_pelanggan');
        const statusBadge = document.getElementById('status_badge');
        const nominalSection = document.getElementById('nominal_section');
        const paymentSection = document.getElementById('payment_section');
        const submitSection = document.getElementById('submit_section');
        const radios = document.querySelectorAll('.id-produk-radio');
        const pricePreview = document.getElementById('price_preview');

        // Deklarasi Elemen Promo
        const btnPromo = document.getElementById('btn_terapkan_promo');
        const inputPromo = document.getElementById('input_kode_promo');
        const hiddenPromo = document.getElementById('hidden_kode_promo');
        const pesanPromo = document.getElementById('pesan_promo');
        const tampilDiskon = document.getElementById('tampil_diskon');

        // State Variabel
        let currentSelectedPrice = 0;
        let currentDiscount = 0;

        // 1. Fungsi Cek Validasi ID
        function checkIdLength(value) {
            if (value.length >= 11 && value.length <= 12) {
                statusBadge.classList.remove('hidden');
                nominalSection.classList.remove('hidden');
            } else {
                statusBadge.classList.add('hidden');
                nominalSection.classList.add('hidden');
                if (!document.querySelector('input[name="id_produk"]:checked')) {
                    paymentSection.classList.add('hidden');
                    submitSection.classList.add('hidden');
                }
            }
        }

        idInput.addEventListener('input', function() {
            checkIdLength(this.value.trim());
        });
        if (idInput.value.trim().length > 0) checkIdLength(idInput.value.trim());

        // 2. Pilih Produk & Hitung Harga
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Ambil harga asli
                currentSelectedPrice = parseInt(this.dataset.rawPrice);

                // Tampilkan section bawah
                paymentSection.classList.remove('hidden');
                submitSection.classList.remove('hidden');

                // Jika user mengganti paket saat promo aktif, reset promo
                if (hiddenPromo.value !== '') {
                    inputPromo.value = '';
                    tampilkanPesan('Nominal diubah. Silakan terapkan ulang kode promo.', 'text-yellow-500');
                    resetPromoUI();
                } else {
                    updatePriceDisplay();
                }
            });

            // Auto trigger jika radio button sudah terpilih (karena fungsi old())
            if (radio.checked) {
                currentSelectedPrice = parseInt(radio.dataset.rawPrice);
                paymentSection.classList.remove('hidden');
                submitSection.classList.remove('hidden');
                updatePriceDisplay();
            }
        });

        // 3. Logika Pengecekan Promo
        btnPromo.addEventListener('click', async function() {
            const kode = inputPromo.value.trim().toUpperCase();

            if (!kode) {
                tampilkanPesan('Silakan masukkan kode promo.', 'text-red-500');
                return;
            }

            if (currentSelectedPrice === 0) {
                tampilkanPesan('Silakan pilih nominal produk terlebih dahulu.', 'text-red-500');
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
            } catch (error) {
                tampilkanPesan('Terjadi kesalahan jaringan atau server.', 'text-red-500');
                resetPromoUI();
            } finally {
                btnPromo.textContent = 'Terapkan';
                btnPromo.disabled = false;
            }
        });

        // 4. Fungsi Bantuan
        function tampilkanPesan(text, colorClass) {
            pesanPromo.textContent = text;
            pesanPromo.className = `text-xs mt-2 font-bold ${colorClass}`;
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
            pricePreview.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalAkhir);
        }
    });
</script>

<style>
    .animate-fade-in {
        animation: fadeIn .4s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection