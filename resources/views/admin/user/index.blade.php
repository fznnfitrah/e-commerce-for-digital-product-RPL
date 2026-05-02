@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('header_title', 'Daftar Pengguna')
@section('header_subtitle', 'Kelola hak akses dan akun pengguna J-Store.')

@section('content')
<div class="bg-white/5 rounded-[2rem] border border-white/10 overflow-hidden backdrop-blur-md shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-black/20 text-gray-400 text-[10px] uppercase tracking-[0.2em] font-black">
                <tr>
                    <th class="p-6">Nama & Email</th>
                    <th class="p-6">Role Saat Ini</th>
                    <th class="p-6">Terdaftar Pada</th>
                    <th class="p-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($users as $user)
                <tr class="hover:bg-white/[0.03] transition-all group">
                    <td class="p-6">
                        <p class="font-bold text-white group-hover:text-blue-400 transition-colors">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </td>
                    <td class="p-6">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border 
                            {{ $user->role == 'admin' ? 'bg-purple-500/10 text-purple-400 border-purple-500/20' : 'bg-blue-500/10 text-blue-400 border-blue-500/20' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="p-6 text-sm text-gray-400">
                        {{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}
                    </td>
                    <td class="p-6">
                        <div class="flex justify-end items-center gap-3">
                            
                            {{-- TOMBOL EDIT PROFIL (BARU) --}}
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="p-2 bg-white/5 hover:bg-blue-500/20 rounded-lg text-gray-400 hover:text-blue-400 transition-all group/edit" 
                               title="Edit Detail User">
                                <span class="text-xs font-bold uppercase tracking-tighter">✏️ Edit</span>
                            </a>

                            {{-- Form Ubah Role Cepat --}}
                            <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PATCH')
                                <select name="role" onchange="this.form.submit()" 
                                    class="bg-black/40 border border-white/10 rounded-lg px-2 py-1.5 text-[10px] font-bold uppercase text-white focus:ring-1 focus:ring-blue-500 outline-none cursor-pointer">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>

                            {{-- Form Hapus --}}
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-red-500/20 rounded-lg transition group/btn" title="Hapus User">
                                    <span class="text-red-500 opacity-50 group-hover/btn:opacity-100 text-[10px] font-black uppercase">Hapus</span>
                                </button>
                            </form>
                            @else
                                <span class="text-[9px] text-gray-600 font-bold uppercase tracking-tighter px-2 italic">Akun Anda</span>
                            @endif

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection