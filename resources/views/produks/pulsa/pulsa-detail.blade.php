@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-6xl px-4 py-10">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT SIDE --}}
        <div class="lg:col-span-3">

            <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden backdrop-blur-xl sticky top-24">

                {{-- HEADER --}}
                <div class="p-6 border-b border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-500/20 to-orange-500/20 flex items-center justify-center text-3xl border border-yellow-500/20">
                            📶
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-white">Pulsa Reguler</h2>
                            <p class="text-sm text-yellow-400 font-semibold">Semua Provider</p>
                        </div>
                    </div>
                </div>

                {{-- PROVIDER INFO --}}
                <div class="p-6">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-4">
                        Provider Terdeteksi
                    </h3>

                    <div id="provider_badge" class="hidden w-full rounded-2xl bg-yellow-500/10 border border-yellow-500/20 px-5 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider">Provider</p>
                                <h4 id="provider_name" class="text-lg font-black text-yellow-400 mt-1">Telkomsel</h4>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-yellow-500/20 flex items-center justify-center text-xl">
                                ⚡
                            </div>
                        </div>
                    </div>

                    {{-- INFO --}}
                    <div class="mt-6 space-y-3">
                        <div class="flex items-center gap-3 text-sm text-gray-300">
                            <span class="text-green-400">●</span> Proses otomatis
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-300">
                            <span class="text-green-400">●</span> Pembayaran aman
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-300">
                            <span class="text-green-400">●</span> Masuk dalam hitungan detik
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="lg:col-span-9">

            <form action="{{ route('transaksi.checkout') }}" method="POST" class="space-y-6">
                @csrf

                {{-- STEP 1: TARGET --}}
                <div class="bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-blue-600 flex items-center justify-center text-white font-black">1</div>
                        <div>
                            <h3 class="text-lg font-black text-white">Masukkan Nomor HP</h3>
                            <p class="text-sm text-gray-400">Sistem akan mendeteksi provider otomatis</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        {{-- PHONE (ID TARGET) --}}
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">
                                Nomor Handphone (Target Pengisian)
                            </label>
                            <input
                                type="number"
                                id="phone_number"
                                name="id_target"
                                value="{{ old('id_target') }}"
                                required
                                autocomplete="off"
                                placeholder="08xxxxxxxxxx"
                                class="w-full bg-black/30 border @error('id_target') border-red-500 @else border-white/10 @enderror rounded-2xl px-5 py-4 text-white text-lg font-bold tracking-wider placeholder:text-gray-500 focus:ring-2 focus:ring-yellow-500 outline-none transition">
                            @error('id_target')
                            <p class="text-red-500 text-sm mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- WHATSAPP (KONTAK PELANGGAN) --}}
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">
                                WhatsApp (Kontak Pelanggan)
                            </label>
                            <input
                                type="text"
                                name="kontak_pelanggan"
                                value="{{ old('kontak_pelanggan') }}"
                                autocomplete="off"
                                placeholder="08xxxxxxxxxx"
                                class="w-full bg-black/30 border @error('kontak_pelanggan') border-red-500 @else border-white/10 @enderror rounded-2xl px-5 py-4 text-white placeholder:text-gray-500 focus:ring-2 focus:ring-yellow-500 outline-none transition">
                            @error('kontak_pelanggan')
                            <p class="text-red-500 text-sm mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- STEP 2: PRODUK --}}
                <div id="nominal_section" class="hidden bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl animate-fade-in">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-yellow-500 flex items-center justify-center text-black font-black">2</div>
                        <div>
                            <h3 class="text-lg font-black text-white">Pilih Nominal</h3>
                            <p class="text-sm text-gray-400">Pilih nominal pulsa yang tersedia</p>
                        </div>
                    </div>

                    @error('id_produk')
                    <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-500 text-sm font-semibold">
                        Pilih produk terlebih dahulu.
                    </div>
                    @enderror

                    {{-- PRODUCTS --}}
                    @foreach($allProviders as $provider)
                    <div id="brand_group_{{ $provider->id_brand }}" class="provider-products-group hidden grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($provider->produks as $produk)
                        <label class="cursor-pointer">
                            <input
                                type="radio"
                                name="id_produk"
                                value="{{ $produk->id_produk }}"
                                class="hidden peer nominal-radio"
                                data-name="{{ $produk->nama_produk }}"
                                data-price="{{ number_format($produk->harga_produk, 0, ',', '.') }}"
                                {{ old('id_produk') == $produk->id_produk ? 'checked' : '' }}
                                required>

                            <div class="border border-white/10 bg-black/20 rounded-2xl p-5 transition hover:border-yellow-500/50 peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10">
                                <div class="flex flex-col h-full justify-between">
                                    <div>
                                        <h4 class="text-lg font-black text-white">{{ $produk->nama_produk }}</h4>
                                        <p class="text-xs text-gray-400 mt-1">Pulsa Provider</p>
                                    </div>
                                    <div class="mt-5">
                                        <p class="text-lg font-black text-yellow-400">
                                            Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @endforeach
                </div>

                {{-- STEP 3: METODE PEMBAYARAN --}}
                <div id="payment_section" class="hidden bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl animate-fade-in">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-purple-600 flex items-center justify-center text-white font-black">3</div>
                        <div>
                            <h3 class="text-lg font-black text-white">Metode Pembayaran</h3>
                            <p class="text-sm text-gray-400">Pilih E-Wallet atau Virtual Account Bank</p>
                        </div>
                    </div>

                    @error('metode_pembayaran')
                    <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500 text-red-500 text-sm font-semibold">
                        Pilih metode pembayaran terlebih dahulu.
                    </div>
                    @enderror

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {{-- DANA --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="dana" class="hidden peer" {{ old('metode_pembayaran') == 'dana' ? 'checked' : '' }} required>
                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex flex-col items-center justify-center text-white transition hover:border-cyan-500 peer-checked:border-cyan-500 peer-checked:bg-cyan-500/10">
                                <span class="font-bold">DANA</span>
                            </div>
                        </label>

                        {{-- GOPAY --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="gopay" class="hidden peer" {{ old('metode_pembayaran') == 'gopay' ? 'checked' : '' }}>
                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex flex-col items-center justify-center text-white transition hover:border-blue-500 peer-checked:border-blue-500 peer-checked:bg-blue-500/10">
                                <span class="font-bold">GoPay</span>
                            </div>
                        </label>

                        {{-- OVO --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="ovo" class="hidden peer" {{ old('metode_pembayaran') == 'ovo' ? 'checked' : '' }}>
                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex flex-col items-center justify-center text-white transition hover:border-purple-500 peer-checked:border-purple-500 peer-checked:bg-purple-500/10">
                                <span class="font-bold">OVO</span>
                            </div>
                        </label>

                        {{-- BCA VA --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="bca_va" class="hidden peer" {{ old('metode_pembayaran') == 'bca_va' ? 'checked' : '' }}>
                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex flex-col items-center justify-center text-white transition hover:border-blue-600 peer-checked:border-blue-600 peer-checked:bg-blue-600/10">
                                <span class="font-bold">BCA VA</span>
                                <span class="text-xs text-gray-400 mt-1">Virtual Account</span>
                            </div>
                        </label>

                        {{-- MANDIRI VA --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="echannel" class="hidden peer" {{ old('metode_pembayaran') == 'echannel' ? 'checked' : '' }}>
                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex flex-col items-center justify-center text-white transition hover:border-yellow-500 peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10">
                                <span class="font-bold">Mandiri VA</span>
                                <span class="text-xs text-gray-400 mt-1">Bill Payment</span>
                            </div>
                        </label>

                        {{-- BNI VA --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="bni_va" class="hidden peer" {{ old('metode_pembayaran') == 'bni_va' ? 'checked' : '' }}>
                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex flex-col items-center justify-center text-white transition hover:border-orange-500 peer-checked:border-orange-500 peer-checked:bg-orange-500/10">
                                <span class="font-bold">BNI VA</span>
                                <span class="text-xs text-gray-400 mt-1">Virtual Account</span>
                            </div>
                        </label>

                        {{-- BRI VA --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="bri_va" class="hidden peer" {{ old('metode_pembayaran') == 'bri_va' ? 'checked' : '' }}>
                            <div class="h-20 rounded-2xl border border-white/10 bg-black/20 flex flex-col items-center justify-center text-white transition hover:border-blue-400 peer-checked:border-blue-400 peer-checked:bg-blue-400/10">
                                <span class="font-bold">BRI VA</span>
                                <span class="text-xs text-gray-400 mt-1">Virtual Account</span>
                            </div>
                        </label>

                    </div>
                </div>
                {{-- STEP 4: SUBMIT --}}
                <div id="submit_section" class="hidden bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-xl animate-fade-in">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-2xl bg-orange-500 flex items-center justify-center text-black font-black">4</div>
                        <div>
                            <h3 class="text-lg font-black text-white">Detail Pembelian</h3>
                            <p class="text-sm text-gray-400">Ringkasan transaksi Anda</p>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            <p id="selected-product" class="text-sm text-gray-400">Belum memilih nominal</p>
                            <h2 id="selected-price" class="text-4xl font-black text-white mt-2">Rp 0</h2>
                        </div>

                        <button
                            type="submit"
                            class="px-10 py-4 rounded-2xl bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-black font-black uppercase tracking-wide shadow-xl shadow-yellow-500/20 transition active:scale-95">
                            Lanjutkan Pembayaran
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const phoneInput = document.getElementById('phone_number');

        const providerBadge = document.getElementById('provider_badge');

        const providerName = document.getElementById('provider_name');

        const nominalSection = document.getElementById('nominal_section');

        const paymentSection = document.getElementById('payment_section');

        const submitSection = document.getElementById('submit_section');

        const selectedProduct = document.getElementById('selected-product');

        const selectedPrice = document.getElementById('selected-price');

        const providers = @json($allProviders);

        // DETECT PROVIDER
        phoneInput.addEventListener('input', function() {

            const number = this.value.trim();

            if (number.length >= 4) {

                const prefixInput = number.substring(0, 4);

                let providerFound = null;

                providers.forEach(provider => {

                    if (provider.prefix) {

                        const prefixArray = provider.prefix.split(',');

                        if (prefixArray.includes(prefixInput)) {
                            providerFound = provider;
                        }
                    }
                });

                if (providerFound) {

                    providerName.textContent = providerFound.nama_brand;

                    providerBadge.classList.remove('hidden');

                    document.querySelectorAll('.provider-products-group')
                        .forEach(el => el.classList.add('hidden'));

                    const targetGroup = document.getElementById(
                        'brand_group_' + providerFound.id_brand
                    );

                    if (targetGroup) {

                        targetGroup.classList.remove('hidden');

                        nominalSection.classList.remove('hidden');
                    }

                } else {

                    providerName.textContent = 'Tidak Dikenal';

                    providerBadge.classList.remove('hidden');

                    resetSections();
                }

            } else {

                providerBadge.classList.add('hidden');

                resetSections();
            }
        });

        // PRODUCT SELECT
        document.addEventListener('change', function(e) {

            if (e.target.classList.contains('nominal-radio')) {

                selectedProduct.textContent = e.target.dataset.name;

                selectedPrice.textContent = 'Rp ' + e.target.dataset.price;

                paymentSection.classList.remove('hidden');

                submitSection.classList.remove('hidden');
            }
        });

        function resetSections() {

            nominalSection.classList.add('hidden');

            paymentSection.classList.add('hidden');

            submitSection.classList.add('hidden');

            document.querySelectorAll('.provider-products-group')
                .forEach(el => el.classList.add('hidden'));
        }
    });
</script>
@endsection