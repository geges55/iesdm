<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan formulir login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Coba login dengan kredensial yang diberikan
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Redirect ke dashboard setelah login sukses
            return redirect()->intended('/dashboard');
        }

        // Jika gagal, kembalikan ke halaman login dengan error
        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
