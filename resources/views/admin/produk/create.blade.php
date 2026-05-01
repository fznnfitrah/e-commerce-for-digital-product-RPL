@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')
@section('header_title', 'Tambah Produk')
@section('header_subtitle', 'Masukkan detail produk digital baru ke katalog J-Store.')

@section('content')
<div class="max-w-5xl mx-auto space-y-10">

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf

        {{-- ERROR --}}
        @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-xl text-sm">
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
                    <input type="text" name="nama_produk" required
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Nama Produk">
                </div>

                <div class="md:col-span-2">
                    <textarea name="deskripsi_produk" rows="3" required
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Deskripsi produk..."></textarea>
                </div>

                <div>
                    <select name="id_kategori" required
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="type" id="product_type" required onchange="handleTypeChange()"
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="topup">Top-up</option>
                        <option value="ebook">E-book</option>
                        <option value="akun">Akun</option>
                    </select>
                </div>

                <div>
                    <input type="number" name="harga_produk" required
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Harga (Rp)">
                </div>

                <div>
                    <input type="file" name="gambar"
                        class="w-full text-sm text-gray-400 file:mr-3 file:px-4 file:py-2 file:rounded-lg 
                               file:border-0 file:bg-white/10 file:text-white hover:file:bg-white/20 transition">
                </div>

            </div>
        </div>


        {{-- KONFIGURASI ASET --}}
        <div class="space-y-6">

            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">
                Konfigurasi Aset
            </h3>

            <div class="bg-white/5 border border-white/10 rounded-xl p-6 space-y-6">

                {{-- EBOOK --}}
                <div id="field_ebook" class="hidden">
                    <input type="file" name="file_ebook"
                        class="w-full text-sm text-gray-400 file:mr-3 file:px-4 file:py-2 file:rounded-lg 
                               file:border-0 file:bg-blue-600/20 file:text-blue-400 hover:file:bg-blue-600/30">
                </div>

                {{-- AKUN --}}
                <div id="field_akun" class="hidden">
                    <textarea name="data_akun" rows="5"
                        class="w-full bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                               placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="email:password (1 baris = 1 akun)"></textarea>
                </div>

                {{-- TOPUP --}}
                <div id="field_topup">
                    <p class="text-sm text-gray-400">
                        Produk top-up tidak membutuhkan aset otomatis.
                    </p>
                </div>

            </div>
        </div>


        {{-- ACTION --}}
        <div class="flex justify-between items-center pt-4">

            <a href="{{ route('admin.produk.index') }}"
                class="text-sm text-gray-400 hover:text-white transition">
                ← Kembali
            </a>

            <button type="submit"
                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl font-semibold transition">
                Simpan Produk
            </button>

        </div>

    </form>

</div>

<script>
    // Logika ganti input field
    function handleTypeChange() {
        const type = document.getElementById('product_type').value;
        const ebook = document.getElementById('field_ebook');
        const akun = document.getElementById('field_akun');
        const topup = document.getElementById('field_topup');

        ebook.classList.add('hidden');
        akun.classList.add('hidden');
        topup.classList.add('hidden');

        if (type === 'ebook') ebook.classList.remove('hidden');
        else if (type === 'akun') akun.classList.remove('hidden');
        else if (type === 'topup') topup.classList.remove('hidden');
    }

    // Menampilkan nama file saat e-book dipilih
    document.getElementById('file_input').onchange = function() {
        document.getElementById('file_label').innerHTML = this.files[0].name;
        document.getElementById('file_label').classList.add('text-blue-400');
    };
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 0.4s ease-out;
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