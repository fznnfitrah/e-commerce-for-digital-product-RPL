@extends('layouts.admin')

@section('title', 'Edit Produk - ' . $produk->nama_produk)
@section('header_title', 'Edit Produk')
@section('header_subtitle', 'Perbarui detail data produk ' . $produk->nama_produk)

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- LOGIKA UNTUK MENDAPATKAN KATEGORI DARI BRAND SAAT INI --}}
        @php
        $currentBrand = $brands->firstWhere('id_brand', $produk->id_brand);
        $currentKategoriId = $currentBrand ? $currentBrand->id_kategori : '';
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- SEKSI KIRI: INFORMASI UTAMA --}}
            <div class="space-y-6 bg-white/5 p-8 rounded-3xl border border-white/10 backdrop-blur-md">
                <h3 class="text-lg font-bold text-blue-400 mb-4 flex items-center gap-2">
                    <span>✏️</span> Ubah Informasi Dasar
                </h3>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required
                        class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Deskripsi Produk</label>
                    <textarea name="deskripsi_produk" required rows="4"
                        class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- DROPDOWN KATEGORI (Ditambahkan Name agar old() berfungsi) --}}
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Kategori</label>
                        <select name="id_kategori" id="select_kategori" required onchange="handleKategoriChange()"
                            class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                            <option value="">Pilih Kategori</option>
                            @foreach($brands->pluck('kategori')->unique('id_kategori') as $kat)
                            @if($kat)
                            <option value="{{ $kat->id_kategori }}" {{ (old('id_kategori', $currentKategoriId) == $kat->id_kategori) ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- DROPDOWN BRAND (Yang disimpan ke Database) --}}
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Sub-Brand</label>
                        <select name="id_brand" id="select_brand" required
                            class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                            <option value="">Pilih Sub-Brand</option>
                            @foreach($brands as $b)
                            <option value="{{ $b->id_brand }}" data-kategori="{{ $b->id_kategori }}">
                                {{ $b->nama_brand }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Harga Produk (Rp)</label>
                    <input type="number" name="harga_produk" value="{{ old('harga_produk', $produk->harga_produk) }}" required
                        class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>

            {{-- SEKSI KANAN: MEDIA --}}
            <div class="space-y-6 bg-white/5 p-8 rounded-3xl border border-white/10 backdrop-blur-md">
                @if ($errors->any())
                <div class="max-w-4xl mx-auto mb-6 bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-2xl text-sm">
                    <ul class="list-disc ml-5 space-y-1 font-semibold">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <h3 class="text-lg font-bold text-[#DFFF00] mb-4 flex items-center gap-2">
                    <span>🖼️</span> Media Produk
                </h3>

                <div class="space-y-4">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Gambar Saat Ini</label>
                    <div class="relative w-full h-48 rounded-2xl overflow-hidden border border-white/10 bg-black/50">
                        @if($produk->gambar_produk)
                        <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="w-full h-full object-cover" id="img-preview">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-600">
                            <span class="text-xs italic">Belum ada gambar</span>
                        </div>
                        @endif
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2 ml-1">Ganti Gambar (Opsional)</label>
                        <input type="file" name="gambar" id="input-gambar" accept="image/*"
                            class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600/10 file:text-blue-400 hover:file:bg-blue-600/20 transition-all">
                    </div>
                </div>

                {{-- INFO TYPE --}}
                @php
                $asetTerkait = \App\Models\AsetProduk::where('id_produk', $produk->id_produk)->first();
                $namaAset = strtolower($asetTerkait->nama_aset ?? '');

                $labelTipe = 'Layanan Instan';
                if(str_contains($namaAset, 'e-book') || str_contains($namaAset, 'ebook')) $labelTipe = 'E-Book (File)';
                elseif(str_contains($namaAset, 'akun')) $labelTipe = 'Akun Premium';
                @endphp

                <div class="mt-10 p-4 bg-yellow-500/10 rounded-xl border border-yellow-500/20">
                    <p class="text-[10px] text-yellow-500 font-bold uppercase mb-1">Tipe Produk Terdeteksi</p>
                    <p class="text-sm font-bold text-white uppercase tracking-widest">
                        {{ $labelTipe }}
                    </p>
                    <p class="text-[10px] text-gray-500 mt-2 italic">
                        *Tipe dideteksi otomatis berdasarkan konfigurasi aset yang dibuat.
                    </p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.produk.index') }}"
                class="px-8 py-3 rounded-xl font-bold text-gray-400 hover:text-white transition-all flex items-center">
                Batal
            </a>
            <button type="submit"
                class="px-10 py-3 bg-[#DFFF00] hover:bg-[#c9e600] text-black font-extrabold rounded-xl 
               shadow-lg shadow-[#DFFF00]/20 transition-all active:scale-95 uppercase tracking-wider">
                PERBARUI DATA
            </button>
        </div>
    </form>
</div>

<script>
    // Live Preview Gambar
    document.getElementById('input-gambar').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            document.getElementById('img-preview').src = URL.createObjectURL(file);
        }
    };

    // LOGIKA FILTER BRANDS BERDASARKAN KATEGORI
    let masterBrandOptions = [];
    document.addEventListener('DOMContentLoaded', function() {
        const selectBrand = document.getElementById('select_brand');

        // Simpan referensi ke semua option asli di memori
        masterBrandOptions = Array.from(selectBrand.options).map(opt => opt.cloneNode(true));

        // Panggil filter untuk menyesuaikan isi dropdown brand
        handleKategoriChange();
    });

    function handleKategoriChange() {
        const idKategoriTerpilih = document.getElementById('select_kategori').value;
        const selectBrand = document.getElementById('select_brand');

        // Ambil nilai brand target (bisa dari input sebelumnya jika error, atau dari database)
        const targetBrandValue = "{{ old('id_brand', $produk->id_brand) }}";

        // Reset Dropdown
        selectBrand.innerHTML = '';
        selectBrand.appendChild(masterBrandOptions[0].cloneNode(true)); // Opsi default

        // Loop dan masukkan kembali option yang sesuai kategori
        masterBrandOptions.forEach(function(option) {
            const kategoriAset = option.getAttribute('data-kategori');

            if (idKategoriTerpilih === "" || kategoriAset === idKategoriTerpilih) {
                if (option.value !== "") {
                    let newOption = option.cloneNode(true);

                    // Tandai 'selected' jika value cocok dengan target
                    if (newOption.value === targetBrandValue) {
                        newOption.selected = true;
                    }

                    selectBrand.appendChild(newOption);
                }
            }
        });
    }
</script>
@endsection