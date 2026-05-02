<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Menampilkan form input email
    public function showLinkRequestForm()
    {
        return view('auth.password');
    }

    // Mengirim link reset password
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        Mail::send('auth.emails.password-reset', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password Notification - J-Store');
        });

        return back()->with('success', 'Kami telah mengirimkan link reset password ke email Anda!');
    }
}