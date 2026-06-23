@extends('layouts.admin')

@section('title', 'Edit Produk - ' . $produk->nama_produk)
@section('header_title', 'Edit Produk')
@section('header_subtitle', 'Perbarui detail data produk ' . $produk->nama_produk)

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- FORM UTAMA: UPDATE INFORMASI DASAR DAN MEDIA --}}
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
                    {{-- DROPDOWN KATEGORI --}}
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

                    {{-- DROPDOWN BRAND --}}
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
                <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-2xl text-sm">
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
            </div>
        </div>

        {{-- TOMBOL SUBMIT UTAMA DARI FORM --}}
        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('admin.produk.index') }}"
                class="px-8 py-3 rounded-xl font-bold text-gray-400 hover:text-white transition-all flex items-center">
                Batal
            </a>
            <button type="submit"
                class="px-10 py-3 bg-[#DFFF00] hover:bg-[#c9e600] text-black font-extrabold rounded-xl shadow-lg shadow-[#DFFF00]/20 transition-all active:scale-95 uppercase tracking-wider">
                PERBARUI DATA PRODUK
            </button>
        </div>
    </form>

    {{-- ========================================================================= --}}
    {{-- FORM AJAX TERPISAH: MANAJEMEN ASET (Diletakkan DI LUAR Form Update Produk) --}}
    {{-- ========================================================================= --}}

    @php
    // LOGIKA BARU: Deteksi tipe produk TANPA bergantung pada tabel aset_produks
    $isAkunPremium = false;

    // 1. Cek dari nama Kategori (Paling Akurat jika relasi terhubung)
    $currentBrand = $brands->firstWhere('id_brand', $produk->id_brand);
    // Pastikan Anda memanggil relasi 'kategori' di ProdukController: Brand::with('kategori')->get()
    $namaKategori = $currentBrand && $currentBrand->kategori ? strtolower($currentBrand->kategori->nama_kategori) : '';

    // 2. Fallback (Cadangan): Cek dari deskripsi produk atau nama produk
    $deskripsiProduk = strtolower($produk->deskripsi_produk);
    $namaProduk = strtolower($produk->nama_produk);

    // Jika salah satu mengandung kata "akun", maka tampilkan form
    if (str_contains($namaKategori, 'akun') || str_contains($deskripsiProduk, 'akun') || str_contains($namaProduk, 'akun')) {
    $isAkunPremium = true;
    }

    // Mengambil daftar aset yang ada untuk ditampilkan (Akan menghasilkan [] jika masih kosong)
    $daftarAset = \App\Models\AsetProduk::where('id_produk', $produk->id_produk)
    ->orderBy('id_aset', 'desc')
    ->get();
    @endphp

    @php
    // Memeriksa apakah produk ini adalah Akun Premium berdasarkan aset yang sudah ada
    $isAkunPremium = false;
    $contohAset = \App\Models\AsetProduk::where('id_produk', $produk->id_produk)->first();

    if ($contohAset && str_contains(strtolower($contohAset->nama_aset), 'akun')) {
    $isAkunPremium = true;
    }

    // Mengambil daftar aset yang ada untuk ditampilkan
    $daftarAset = \App\Models\AsetProduk::where('id_produk', $produk->id_produk)
    ->orderBy('id_aset', 'desc')
    ->get();
    @endphp

    @if($isAkunPremium)
    <div class="mt-12 bg-white/5 p-8 rounded-3xl border border-blue-500/30 backdrop-blur-md shadow-lg shadow-blue-500/10">
        <h3 class="text-lg font-bold text-blue-400 mb-6 flex items-center gap-2">
            <span>🔐</span> Manajemen Stok Aset (Akun Premium)
        </h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- KIRI: FORM TAMBAH CEPAT --}}
            <div class="space-y-4">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block ml-1">
                    Tambah Akun Cepat (Bulk Insert)
                </label>
                <p class="text-[10px] text-gray-500 italic ml-1 mb-2">
                    *Masukkan akun dengan format <b>email:password</b>. Satu baris untuk satu akun. Tekan Enter untuk akun baru.
                </p>

                <textarea id="bulk-aset-input" rows="6" placeholder="email1@test.com:pass123&#10;email2@test.com:pass456"
                    class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-600 font-mono text-sm"></textarea>

                <button type="button" id="btn-tambah-aset"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 transition-all active:scale-95">
                    Tambahkan ke Stok
                </button>
                <p id="pesan-aset" class="text-xs font-bold hidden text-center mt-2"></p>
            </div>

            {{-- KANAN: LIST ASET SAAT INI --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block ml-1">
                        Stok Saat Ini
                    </label>
                    <span class="text-xs font-black text-blue-400 bg-blue-400/10 px-2 py-1 rounded-md">
                        Tersedia: {{ $daftarAset->where('is_sold', 0)->count() }}
                    </span>
                </div>

                <div class="h-64 overflow-y-auto bg-black/40 border border-white/10 rounded-xl p-2 space-y-2 custom-scrollbar">
                    @forelse($daftarAset as $aset)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-white/5 border border-white/5 hover:border-white/10 group transition" id="aset-row-{{ $aset->id_aset }}">
                        <div class="truncate max-w-[70%]">
                            <p class="text-sm text-white font-mono truncate" title="{{ $aset->deskripsi }}">{{ $aset->deskripsi }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($aset->is_sold)
                            <span class="text-[10px] font-bold text-red-500 bg-red-500/10 px-2 py-1 rounded">TERJUAL</span>
                            @else
                            <span class="text-[10px] font-bold text-green-500 bg-green-500/10 px-2 py-1 rounded">TERSEDIA</span>
                            {{-- Tombol Hapus Asinkron --}}
                            <button type="button" onclick="hapusAset({{ $aset->id_aset }})" class="text-gray-500 hover:text-red-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="h-full flex items-center justify-center text-sm text-gray-500 italic">
                        Stok produk ini sedang kosong.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif
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
        masterBrandOptions = Array.from(selectBrand.options).map(opt => opt.cloneNode(true));
        handleKategoriChange();
    });

    function handleKategoriChange() {
        const idKategoriTerpilih = document.getElementById('select_kategori').value;
        const selectBrand = document.getElementById('select_brand');
        const targetBrandValue = "{{ old('id_brand', $produk->id_brand) }}";

        selectBrand.innerHTML = '';
        selectBrand.appendChild(masterBrandOptions[0].cloneNode(true));

        masterBrandOptions.forEach(function(option) {
            const kategoriAset = option.getAttribute('data-kategori');
            if (idKategoriTerpilih === "" || kategoriAset === idKategoriTerpilih) {
                if (option.value !== "") {
                    let newOption = option.cloneNode(true);
                    if (newOption.value === targetBrandValue) {
                        newOption.selected = true;
                    }
                    selectBrand.appendChild(newOption);
                }
            }
        });
    }

    // LOGIKA AJAX MANAJEMEN ASET
    document.addEventListener('DOMContentLoaded', function() {
        const btnTambah = document.getElementById('btn-tambah-aset');
        const textareaAset = document.getElementById('bulk-aset-input');
        const pesanAset = document.getElementById('pesan-aset');

        if (btnTambah) {
            btnTambah.addEventListener('click', async function() {
                const data = textareaAset.value.trim();

                if (!data) {
                    pesanAset.textContent = 'Harap masukkan data akun terlebih dahulu!';
                    pesanAset.className = 'text-xs font-bold text-red-500 text-center mt-2 block';
                    return;
                }

                btnTambah.textContent = 'Menyimpan...';
                btnTambah.disabled = true;

                try {
                    const response = await fetch("{{ route('admin.produk.aset.bulk', $produk->id_produk) ?? '#' }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            data_akun: data
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        textareaAset.value = '';
                        pesanAset.textContent = result.message;
                        pesanAset.className = 'text-xs font-bold text-green-500 text-center mt-2 block';
                        // Me-reload halaman setelah sukses agar tabel stok terupdate
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        throw new Error('Terjadi kesalahan.');
                    }
                } catch (error) {
                    pesanAset.textContent = 'Gagal menyimpan aset. Pastikan format benar.';
                    pesanAset.className = 'text-xs font-bold text-red-500 text-center mt-2 block';
                } finally {
                    btnTambah.textContent = 'Tambahkan ke Stok';
                    btnTambah.disabled = false;
                }
            });
        }
    });

    // Fungsi Hapus Aset Satuan
    async function hapusAset(id) {
        if (!confirm('Yakin ingin menghapus akun ini dari stok?')) return;

        try {
            const response = await fetch(`/admin/aset/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const row = document.getElementById(`aset-row-${id}`);
                if (row) row.remove();
            }
        } catch (error) {
            alert('Gagal menghapus aset.');
        }
    }
</script>
@endsection