@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')
@section('header_title', 'Riwayat Transaksi')
@section('header_subtitle', 'Semua data transaksi pelanggan platform J-Store.')

@section('content')
<section class="bg-white/5 rounded-[2rem] border border-white/10 overflow-hidden backdrop-blur-md shadow-2xl">

    <div class="p-8 border-b border-white/10 flex justify-between items-center bg-white/[0.02]">
        <div>
            <h3 class="font-black text-xl uppercase tracking-tighter flex items-center gap-2">
                <span class="w-2 h-2 bg-purple-500 rounded-full animate-pulse"></span>
                Daftar Semua Transaksi
            </h3>
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Menampilkan keseluruhan log sistem pembayaran</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">

            <thead class="bg-black/20 text-gray-400 text-[10px] uppercase tracking-[0.2em] font-black">
                <tr>
                    <th class="p-6">Order ID & Produk</th>
                    <th class="p-6">Kontak Pelanggan</th>
                    <th class="p-6">ID Target (Game/Meter/Email)</th>
                    <th class="p-6">Metode</th>
                    <th class="p-6">Total Akhir</th>
                    <th class="p-6">Status</th>
                    <th class="p-6">Tanggal</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/5">
                @forelse($all_transaksi as $order)
                <tr class="hover:bg-white/[0.03] transition-all group">

                    {{-- Order ID & Produk --}}
                    <td class="p-6">
                        <p class="font-bold text-white group-hover:text-blue-400 transition-colors">
                            {{ $order->produk->nama_produk ?? 'Deleted Product' }}
                        </p>
                        <p class="text-[10px] text-gray-500 font-mono mt-0.5">
                            TRX-{{ $order->created_at->format('YmdHis') }}-{{ $order->id_transaksi }}
                        </p>
                    </td>

                    {{-- Kontak Pelanggan --}}
                    <td class="p-6 text-sm text-gray-300">
                        {{ $order->kontak_pelanggan }}
                    </td>

                    {{-- ID Target --}}
                    <td class="p-6">
                        <span class="text-xs font-mono bg-black/40 px-3 py-1 rounded-lg border border-white/5 italic">
                            {{ $order->id_target }} 
                            @if($order->id_server) 
                                <span class="text-blue-500">({{ $order->id_server }})</span> 
                            @endif
                        </span>
                    </td>

                    {{-- Metode Pembayaran --}}
                    <td class="p-6">
                        <span class="text-[10px] font-black text-blue-400 bg-blue-400/10 px-2.5 py-1 rounded-md uppercase tracking-wider">
                            {{ $order->metode_pembayaran }}
                        </span>
                    </td>

                    {{-- Total Pembayaran --}}
                    <td class="p-6 font-black text-white">
                        <span class="text-[#DFFF00]">Rp {{ number_format($order->total_akhir, 0, ',', '.') }}</span>
                    </td>

                    {{-- Status Pembayaran --}}
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

                    {{-- Tanggal Pembuatan --}}
                    <td class="p-6 text-xs text-gray-400 font-medium">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-20 text-center">
                        <span class="text-4xl block mb-4 opacity-20">📥</span>
                        <p class="text-gray-500 font-bold uppercase tracking-widest text-xs italic">
                            Belum ada riwayat transaksi yang tercatat.
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- LINK PAGINATION --}}
    @if($all_transaksi->hasPages())
    <div class="p-6 border-t border-white/10 bg-black/10">
        {{ $all_transaksi->links() }}
    </div>
    @endif

</section>
@endsection