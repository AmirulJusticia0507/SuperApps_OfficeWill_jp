<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan formulir login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
		$credentials = $request->only('email', 'password');

		if (Auth::attempt($credentials) || Auth::guard('employee')->attempt($credentials)) {
            // Jika otentikasi berhasil, arahkan pengguna ke dashboard
            return redirect()->route('dashboard');
        }

        // Jika otentikasi gagal, kembali ke halaman login dengan pesan kesalahan
        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

    /**
     * Menangani permintaan logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
		Auth::guard('employee')->logout();

        return redirect()->route('login');
    }
}
