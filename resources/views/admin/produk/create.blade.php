@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')
@section('header_title', 'Tambah Produk')
@section('header_subtitle', 'Masukkan detail produk digital baru ke katalog J-Store.')

@section('content')
<div class="max-w-5xl mx-auto space-y-10">

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf

        {{-- Logika untuk memulihkan pilihan jika terjadi error validasi --}}
        @php
        $oldKatId = '';
        if(old('id_brand')) {
        $oldBrand = $brands->firstWhere('id_brand', old('id_brand'));
        $oldKatId = $oldBrand ? $oldBrand->id_kategori : '';
        }
        @endphp

        {{-- ERROR ALERT --}}
        @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-xl text-sm animate-fade-in">
            <ul class="list-disc ml-5 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- INFORMASI UTAMA --}}
        <div class="space-y-6">

            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">
                Informasi Produk
            </h3>

            <div class="grid md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <input type="text" name="nama_produk" required value="{{ old('nama_produk') }}"
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Nama Produk (Contoh: 385 UC PUBG)">
                </div>

                <div class="md:col-span-2">
                    <textarea name="deskripsi_produk" rows="3" required
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Deskripsi produk...">{{ old('deskripsi_produk') }}</textarea>
                </div>

                {{-- KOLOM KIRI 1: SELECT KATEGORI UTAMA --}}
                <div>
                    <select id="select_kategori" required onchange="filterBrandOptions()"
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">-- Pilih Kategori Utama --</option>
                        @foreach($brands->pluck('kategori')->unique('id_kategori') as $kat)
                        @if($kat)
                        <option value="{{ $kat->id_kategori }}" {{ $oldKatId == $kat->id_kategori ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                        @endif
                        @endforeach
                    </select>
                </div>

                {{-- KOLOM KANAN 1: SELECT BRAND (OTOMATIS TERFILTER) --}}
                <div>
                    <select name="id_brand" id="select_brand" required
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">-- Pilih Sub-Brand --</option>
                        @foreach($brands as $b)
                        <option value="{{ $b->id_brand }}" data-kategori="{{ $b->id_kategori }}" {{ old('id_brand') == $b->id_brand ? 'selected' : '' }}>
                            {{ $b->nama_brand }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- KOLOM KIRI 2: PILIH TIPE (MENGGANTIKAN HIDDEN INPUT & JS TEBAK KATA) --}}
                <div>
                    <select name="type" id="select_type" required onchange="handleTypeVisibility(this.value)"
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="topup" {{ old('type') == 'topup' ? 'selected' : '' }}>Tipe: Topup Game Instan</option>
                        <option value="akun" {{ old('type') == 'akun' ? 'selected' : '' }}>Tipe: Akun Premium (Email & Pass)</option>
                        <option value="ebook" {{ old('type') == 'ebook' ? 'selected' : '' }}>Tipe: E-Book (File PDF)</option>
                        <option value="pulsa" {{ old('type') == 'pulsa' ? 'selected' : '' }}>Tipe: Pulsa Reguler</option>
                        <option value="token" {{ old('type') == 'token' ? 'selected' : '' }}>Tipe: Token Listrik</option>
                    </select>
                </div>

                {{-- KOLOM KANAN 2: HARGA --}}
                <div>
                    <input type="number" name="harga_produk" required value="{{ old('harga_produk') }}"
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Harga (Rp)">
                </div>

                {{-- KOLOM BAWAH FULL: GAMBAR --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Thumbnail Produk</label>
                    <input type="file" name="gambar"
                        class="w-full text-sm text-gray-400 file:mr-3 file:px-4 file:py-2 file:rounded-lg 
                               file:border-0 file:bg-white/10 file:text-white hover:file:bg-white/20 transition h-full bg-black/60 border border-white/10">
                </div>

            </div>
        </div>

        {{-- KONFIGURASI ASET --}}
        <div class="space-y-6">

            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">
                Konfigurasi Aset
            </h3>

            <div class="bg-white/5 border border-white/10 rounded-xl p-6 space-y-6 shadow-inner">

                {{-- EBOOK --}}
                <div id="field_ebook" class="hidden animate-fade-in">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Upload File E-Book</label>
                    <input type="file" name="file_ebook"
                        class="w-full text-sm text-gray-400 file:mr-3 file:px-4 file:py-2 file:rounded-lg 
                               file:border-0 file:bg-blue-600/20 file:text-blue-400 hover:file:bg-blue-600/30 transition bg-black/40 border border-white/10">
                </div>

                {{-- AKUN --}}
                <div id="field_akun" class="hidden animate-fade-in">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Kredensial Akun</label>
                    <textarea name="data_akun" rows="5"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white 
                               placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Format: email:password (1 baris = 1 akun)">{{ old('data_akun') }}</textarea>
                </div>

                {{-- LAINNYA (TOPUP, PULSA, TOKEN) --}}
                <div id="field_topup" class="animate-fade-in">
                    <div class="bg-blue-500/10 border border-blue-500/20 p-4 rounded-xl flex items-center gap-3">
                        <span class="text-2xl">⚡</span>
                        <p class="text-sm text-blue-300 font-medium">
                            Produk bertipe ini akan dibuatkan aset <span class="font-bold">Layanan Otomatis</span>. Sistem akan menuntut pelanggan memasukkan ID Target saat checkout.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('admin.produk.index') }}"
                class="text-sm text-gray-400 hover:text-white transition">
                ← Batal & Kembali
            </a>
            <button type="submit"
                class="px-8 py-3.5 bg-blue-600 hover:bg-blue-500 rounded-xl font-black uppercase tracking-wider transition shadow-lg shadow-blue-600/30 text-white active:scale-95">
                💾 Simpan Produk
            </button>
        </div>

    </form>
</div>

<script>
    let masterBrandOptions = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Backup semua brand option di memori
        const selectBrand = document.getElementById('select_brand');
        masterBrandOptions = Array.from(selectBrand.options);

        // Memulihkan tampilan jika ada error validasi atau edit form
        const selectKat = document.getElementById('select_kategori');
        if (selectKat.value !== "") {
            const tempBrandValue = selectBrand.value;
            filterBrandOptions();
            selectBrand.value = tempBrandValue;
        }

        // Tampilkan field aset berdasarkan Tipe Produk yang aktif
        handleTypeVisibility(document.getElementById('select_type').value);
    });

    // Fungsi hanya memfilter brand berdasarkan kategori, TIDAK LAGI MENEBAK TYPE
    function filterBrandOptions() {
        const selectKat = document.getElementById('select_kategori');
        const idKategoriTerpilih = selectKat.value;
        const selectBrand = document.getElementById('select_brand');

        selectBrand.innerHTML = '';
        selectBrand.appendChild(masterBrandOptions[0]);

        masterBrandOptions.forEach(function(option) {
            const kategoriAset = option.getAttribute('data-kategori');
            if (idKategoriTerpilih === "" || kategoriAset === idKategoriTerpilih) {
                if (option.value !== "") {
                    selectBrand.appendChild(option);
                }
            }
        });
    }

    function handleTypeVisibility(type) {
        const ebook = document.getElementById('field_ebook');
        const akun = document.getElementById('field_akun');
        const topup = document.getElementById('field_topup');

        ebook.classList.add('hidden');
        akun.classList.add('hidden');
        topup.classList.add('hidden');

        if (type === 'ebook') {
            ebook.classList.remove('hidden');
        } else if (type === 'akun') {
            akun.classList.remove('hidden');
        } else {
            topup.classList.remove('hidden');
        }
    }
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection