<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman auth (Login & Register Slide)
    public function showAuthForm()
    {
        return view('auth.auth');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            if (Auth::attempt($credentials, $request->remember)) {
                $request->session()->regenerate();

                // Redirect berdasarkan role
                return Auth::user()->role === 'admin' 
                    ? redirect()->intended('/admin/') 
                    : redirect()->intended('/');
            }
        } catch (\RuntimeException $e) {
            return back()->withErrors(['email' => 'Format keamanan akun tidak valid.'])->onlyInput('email');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}