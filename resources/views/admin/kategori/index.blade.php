@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('header_title', 'Master Kategori')
@section('header_subtitle', 'Kelola pengelompokan produk digital Anda.')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    {{-- FORM CARD --}}
    <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md">

        <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">
            Tambah Kategori
        </h3>

        <form action="{{ route('admin.kategori.store') }}" method="POST" class="flex gap-3">
            @csrf

            <input type="text" name="nama_kategori" required
                class="flex-1 bg-black/60 border border-white/10 rounded-xl px-4 py-3 text-white 
                       placeholder-gray-500 focus:ring-2 focus:ring-blue-500 outline-none"
                placeholder="Contoh: Voucher Game, Akun Premium...">

            <button type="submit"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-xl font-semibold transition">
                Simpan
            </button>
        </form>

        @error('nama_kategori')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>


    {{-- LIST SECTION --}}
    <div class="bg-white/5 border border-white/10 rounded-2xl backdrop-blur-md">

        {{-- HEADER --}}
        <div class="flex justify-between items-center px-6 py-4 border-b border-white/10">
            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">
                Daftar Kategori
            </h3>

            <span class="text-xs text-gray-500">
                {{ $kategoris->count() }} kategori
            </span>
        </div>

        {{-- LIST --}}
        <div class="divide-y divide-white/5">

            @forelse($kategoris as $k)
            <div class="flex items-center justify-between px-6 py-4 hover:bg-white/5 transition group">

                {{-- LEFT --}}
                <div>
                    <p class="text-xs text-gray-500">
                        #{{ $loop->iteration }}
                    </p>

                    <p class="font-semibold text-white group-hover:text-blue-400 transition">
                        {{ $k->nama_kategori }}
                    </p>
                </div>

                {{-- RIGHT --}}
                <div class="flex items-center gap-4">

                    <span class="text-xs text-blue-400">
                        {{ $k->produks_count ?? 0 }} produk
                    </span>

                    <form action="{{ route('admin.kategori.destroy', $k->id_kategori) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus kategori ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="text-red-400 text-xs hover:text-red-300 transition">
                            Hapus
                        </button>
                    </form>

                </div>

            </div>

            @empty
            <div class="text-center py-12 text-gray-500 text-sm">
                Belum ada kategori.
            </div>
            @endforelse

        </div>

    </div>

</div>
@endsection