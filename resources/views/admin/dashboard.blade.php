<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - J-Store</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-[#0a0a0a] text-white overflow-hidden">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-black/60 backdrop-blur-xl border-r border-white/10 p-6 flex flex-col">

        <div class="mb-10">
            <h1 class="text-2xl font-black italic tracking-tighter uppercase">
                J-<span class="text-[#DFFF00]">ADMIN</span>
            </h1>
        </div>

        <nav class="flex-1 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 p-3 bg-blue-600 rounded-xl font-bold">
                <span>📊</span> Dashboard
            </a>

            <a href="{{ route('admin.produk.create') }}"
               class="flex items-center gap-3 p-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl transition">
                <span>📦</span> Tambah Produk
            </a>

            <a href="#"
               class="flex items-center gap-3 p-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl transition">
                <span>📂</span> Kategori
            </a>

            <a href="#"
               class="flex items-center gap-3 p-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl transition">
                <span>🎟️</span> Promo & Voucher
            </a>

            <a href="#"
               class="flex items-center gap-3 p-3 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl transition">
                <span>🧾</span> Riwayat Transaksi
            </a>

        </nav>

        <div class="pt-6 border-t border-white/10">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 p-3 text-red-400 hover:bg-red-500/10 rounded-xl w-full transition">
                    <span>🚪</span> Logout
                </button>
            </form>
        </div>

    </aside>


    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-10 overflow-y-auto relative">

        {{-- Background glow --}}
        <div class="absolute inset-0 opacity-30 pointer-events-none">
            <img src="{{ asset('images/hero-bg.png') }}" class="w-full h-full object-cover">
        </div>

        <div class="relative z-10">

            {{-- HEADER --}}
            <header class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-3xl font-bold">Ringkasan Statistik</h2>
                    <p class="text-gray-400">Selamat datang kembali, Admin J-Store.</p>
                </div>

                <div class="bg-white/5 px-4 py-2 rounded-lg border border-white/10">
                    <span class="text-sm text-gray-400">{{ now()->format('d M Y') }}</span>
                </div>
            </header>


            {{-- STAT CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

                <div class="bg-white/5 p-6 rounded-2xl border border-white/10 backdrop-blur-md">
                    <p class="text-gray-400 text-sm uppercase font-bold mb-2">Total Produk</p>
                    <h3 class="text-4xl font-black">{{ $total_produk }}</h3>
                </div>

                <div class="bg-white/5 p-6 rounded-2xl border border-white/10 backdrop-blur-md">
                    <p class="text-gray-400 text-sm uppercase font-bold mb-2">Total Order</p>
                    <h3 class="text-4xl font-black text-blue-500">{{ $total_transaksi }}</h3>
                </div>

                <div class="bg-white/5 p-6 rounded-2xl border border-white/10 backdrop-blur-md">
                    <p class="text-gray-400 text-sm uppercase font-bold mb-2">Pelanggan</p>
                    <h3 class="text-4xl font-black text-purple-500">{{ $total_user }}</h3>
                </div>

                <div class="bg-white/5 p-6 rounded-2xl border border-white/10 backdrop-blur-md">
                    <p class="text-gray-400 text-sm uppercase font-bold mb-2">Pendapatan</p>
                    <h3 class="text-2xl font-black text-green-400">
                        Rp {{ number_format($pendapatan, 0, ',', '.') }}
                    </h3>
                </div>

            </div>


            {{-- TABLE --}}
            <section class="bg-white/5 rounded-3xl border border-white/10 overflow-hidden backdrop-blur-md">

                <div class="p-6 border-b border-white/10 flex justify-between items-center">
                    <h3 class="font-bold text-xl uppercase tracking-tighter">
                        Transaksi Terakhir
                    </h3>
                    <a href="#" class="text-blue-400 text-xs hover:underline font-bold">
                        Lihat Semua
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">

                        <thead class="bg-white/5 text-gray-400 text-xs uppercase">
                        <tr>
                            <th class="p-4">Produk</th>
                            <th class="p-4">Kontak Pelanggan</th>
                            <th class="p-4">Target</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Status</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-white/5">
                        @forelse($recent_orders as $order)
                            <tr class="hover:bg-white/5 text-sm">

                                <td class="p-4 font-bold">
                                    {{ $order->produk->nama_produk ?? 'N/A' }}
                                </td>

                                <td class="p-4 text-gray-400">
                                    {{ $order->kontak_pelanggan }}
                                </td>

                                <td class="p-4 italic">
                                    {{ $order->id_target }} ({{ $order->id_server ?? '-' }})
                                </td>

                                <td class="p-4 font-bold text-blue-400">
                                    Rp {{ number_format($order->total_akhir, 0, ',', '.') }}
                                </td>

                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                                        {{ $order->status_pembayaran == 'success'
                                            ? 'bg-green-500/20 text-green-400'
                                            : 'bg-yellow-500/20 text-yellow-400' }}">
                                        {{ $order->status_pembayaran }}
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-gray-500 italic">
                                    Belum ada transaksi masuk.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>

            </section>

        </div>

    </main>

</div>

</body>
</html>