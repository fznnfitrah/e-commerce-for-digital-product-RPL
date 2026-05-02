@extends('layouts.admin')

@section('title', 'Edit User - ' . $user->name)
@section('header_title', 'Edit Pengguna')
@section('header_subtitle', 'Sesuaikan informasi profil dan hak akses pengguna.')

@section('content')
<div class="max-w-2xl mx-auto">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white/5 p-8 rounded-[2.5rem] border border-white/10 backdrop-blur-md shadow-2xl">
            <h3 class="text-lg font-bold text-blue-400 mb-6 flex items-center gap-2">
                <span>👤</span> Profil Pengguna
            </h3>

            <div class="space-y-5">
                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full bg-black/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full bg-black/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-2 ml-1">Role / Hak Akses</label>
                    <select name="role" required
                        class="w-full bg-black/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Pelanggan)</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Pengelola)</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end items-center gap-6 mt-10">
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-gray-500 hover:text-white transition">Batal</a>
                <button type="submit" 
                    class="px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-600/20 transition-all active:scale-95 uppercase tracking-tighter">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection