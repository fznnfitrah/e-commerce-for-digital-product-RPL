@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', 'Ringkasan Statistik')
@section('header_subtitle', 'Selamat datang kembali, Admin J-Store.')

@section('content')
{{-- STAT CARDS SECTION --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <!-- Total Produk -->
    <div class="bg-white/5 p-6 rounded-3xl border border-white/10 backdrop-blur-md hover:border-blue-500/50 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-2xl">📦</span>
            <span class="text-[10px] font-black text-blue-400 bg-blue-400/10 px-2 py-1 rounded-lg uppercase tracking-widest">Katalog</span>
        </div>
        <p class="text-gray-400 text-xs uppercase font-bold tracking-tighter mb-1">Total Produk</p>
        <h3 class="text-4xl font-black group-hover:text-blue-400 transition-colors">{{ $total_produk }}</h3>
    </div>

    <!-- Total Order -->
    <div class="bg-white/5 p-6 rounded-3xl border border-white/10 backdrop-blur-md hover:border-blue-500/50 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-2xl">🛒</span>
            <span class="text-[10px] font-black text-purple-400 bg-purple-400/10 px-2 py-1 rounded-lg uppercase tracking-widest">Pesanan</span>
        </div>
        <p class="text-gray-400 text-xs uppercase font-bold tracking-tighter mb-1">Total Order</p>
        <h3 class="text-4xl font-black text-blue-500 group-hover:text-white transition-colors">{{ $total_transaksi }}</h3>
    </div>

    <!-- Pelanggan -->
    <div class="bg-white/5 p-6 rounded-3xl border border-white/10 backdrop-blur-md hover:border-blue-500/50 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-2xl">👥</span>
            <span class="text-[10px] font-black text-green-400 bg-green-400/10 px-2 py-1 rounded-lg uppercase tracking-widest">User</span>
        </div>
        <p class="text-gray-400 text-xs uppercase font-bold tracking-tighter mb-1">Pelanggan</p>
        <h3 class="text-4xl font-black text-purple-500 group-hover:text-white transition-colors">{{ $total_user }}</h3>
    </div>

    <!-- Pendapatan -->
    <div class="bg-white/5 p-6 rounded-3xl border border-white/10 backdrop-blur-md hover:border-[#DFFF00]/50 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-2xl">💰</span>
            <span class="text-[10px] font-black text-[#DFFF00] bg-[#DFFF00]/10 px-2 py-1 rounded-lg uppercase tracking-widest">Profit</span>
        </div>
        <p class="text-gray-400 text-xs uppercase font-bold tracking-tighter mb-1">Pendapatan</p>
        <h3 class="text-2xl font-black text-[#DFFF00]">
            <span class="text-sm font-normal mr-1 italic">Rp</span>{{ number_format($pendapatan, 0, ',', '.') }}
        </h3>
    </div>

</div>

{{-- RECENT TRANSACTIONS SECTION --}}
<section class="bg-white/5 rounded-[2rem] border border-white/10 overflow-hidden backdrop-blur-md shadow-2xl">

    <div class="p-8 border-b border-white/10 flex justify-between items-center bg-white/[0.02]">
        <div>
            <h3 class="font-black text-xl uppercase tracking-tighter flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                Transaksi Terakhir
            </h3>
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Update aktivitas terbaru hari ini</p>
        </div>
        <a href="{{ route('admin.transaksi.riwayat') }}" class="px-5 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-xs font-bold transition-all">
            LIHAT SEMUA
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">

            <thead class="bg-black/20 text-gray-400 text-[10px] uppercase tracking-[0.2em] font-black">
                <tr>
                    <th class="p-6">Produk</th>
                    <th class="p-6">Kontak</th>
                    <th class="p-6">ID Target</th>
                    <th class="p-6">Total Pembayaran</th>
                    <th class="p-6">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/5">
                @forelse($recent_orders as $order)
                <tr class="hover:bg-white/[0.03] transition-all group">


                    <td class="p-6">
                        <p class="font-bold text-white group-hover:text-blue-400 transition-colors">
                            {{ $order->produk->nama_produk ?? 'Deleted Product' }}
                        </p>
                        <p class="text-[10px] text-gray-500 font-mono">ID: {{ $order->id_transaksi ?? 'TRX-AUTO' }}</p>
                    </td>

                    <td class="p-6 text-sm text-gray-300">
                        {{ $order->kontak_pelanggan }}
                    </td>

                    <td class="p-6">
                        <span class="text-xs font-mono bg-black/40 px-3 py-1 rounded-lg border border-white/5 italic">
                            {{ $order->id_target }} @if($order->id_server) <span class="text-blue-500">({{ $order->id_server }})</span> @endif
                        </span>
                    </td>

                    <td class="p-6 font-black text-white">
                        <span class="text-[#DFFF00]">Rp {{ number_format($order->total_akhir, 0, ',', '.') }}</span>
                    </td>

                    <td class="p-6">
                        <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest
                            @if($order->status_pembayaran == 'success') 
                                bg-green-500/10 text-green-400 border border-green-500/20
                            @elseif($order->status_pembayaran == 'pending') 
                                bg-yellow-500/10 text-yellow-400 border border-yellow-500/20
                            @else 
                                bg-red-500/10 text-red-400 border border-red-500/20
                            @endif
                                ">
                            {{ $order->status_pembayaran }}
                        </span>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-20 text-center">
                        <span class="text-4xl block mb-4 opacity-20">📥</span>
                        <p class="text-gray-500 font-bold uppercase tracking-widest text-xs italic">
                            Belum ada transaksi yang tercatat.
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</section>
@endsection