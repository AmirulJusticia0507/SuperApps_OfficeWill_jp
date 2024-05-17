<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    // Memeriksa apakah pengguna sudah login
    if (Auth::check()) {
        // Jika sudah login, tampilkan halaman dashboard
        return view('dashboard');
    } else {
        // Jika belum login, arahkan ke halaman login
        return redirect()->route('login');
    }
}
}
