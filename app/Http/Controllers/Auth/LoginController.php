<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmployeeInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
	protected $throttleKey;
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
		$errorMsg = 'Invalid credentials';
		$credentials = $request->only('email', 'password');
		$this->throttleKey = $credentials['email'];
		$superuser = User::where('email', $credentials['email'])->first();
		$user = EmployeeInformation::where('email', $credentials['email'])->first();
		if (!$user && !$superuser) {
			return redirect()->route('login')->with('error', 'User not found');
		}

		if ($user && RateLimiter::tooManyAttempts($this->throttleKey, $user->numberofincorrect_passwords)) {
			$errorMsg = 'Too many failed login attempts.';
		} elseif ($user && Auth::guard('employee')->attempt($credentials)) {
			if ($user && $user->account_status == 'disabled') {
				$errorMsg = 'Your account has been disabled.';
			} elseif ($user && now()->diffInSeconds(Carbon::parse($user->account_lock_datetime)) > 0) {
				$errorMsg = 'Your account is locked.';
			} else {
				RateLimiter::cleanRateLimiterKey($this->throttleKey);
				return redirect()->route('dashboard');
			}
		} elseif ($superuser && Auth::attempt($credentials)) {
			RateLimiter::cleanRateLimiterKey($this->throttleKey);
			return redirect()->route('dashboard');
		}

		RateLimiter::hit($this->throttleKey, 60);

		// Jika otentikasi gagal, kembali ke halaman login dengan pesan kesalahan
		return redirect()->route('login')->with('error', $errorMsg);
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
