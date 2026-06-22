<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // 1. Simpan data user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // 2. HAPUS ATAU KOMENTARI BARIS INI:
        // Auth::login($user); 

        // 3. Alihkan kembali ke halaman login dengan membawa parameter register_success
        return redirect()->route('login')->with([
            'success' => 'Registrasi berhasil! Silakan login menggunakan akun baru Anda.',
            'register_success' => true
        ]);
    }
}