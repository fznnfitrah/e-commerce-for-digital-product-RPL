@extends('layouts.admin')

@section('title', 'Manajemen Promo')
@section('header_title', 'Voucher & Promo')
@section('header_subtitle', 'Kelola kode diskon untuk pelanggan J-Store.')

@section('content')
<div class="space-y-6">
    <div class="flex justify-end">
        <a href="{{ route('admin.promo.create') }}"
            class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-purple-600/20">
            ✚ Tambah Promo
        </a>
    </div>

    <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden backdrop-blur-md">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-widest font-black">
                <tr>
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Potongan</th>
                    <th class="px-6 py-4">Min. Transaksi</th>
                    <th class="px-6 py-4">Limit User</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-white text-sm divide-y divide-white/5">
                @foreach($promos as $promo)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4 font-mono text-purple-400 font-bold">{{ $promo->kode_promo }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($promo->potongan_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-gray-400">Rp {{ number_format($promo->transaksi_min, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $promo->batasan_user }} Pengguna</td>
                    <td class="px-6 py-4 flex justify-center gap-3">
                        <form action="{{ route('admin.promo.destroy', $promo->id_promo) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="text-red-400 hover:text-red-300 btn-delete">🗑️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection