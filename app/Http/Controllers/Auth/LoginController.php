<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmployeeInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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
		$validated = $request->validate([
			'email' => ['required', 'string', 'email'],
			'password' => ['required', 'string'],
		]);

		$email = Str::lower($validated['email']);
		$credentials = ['email' => $email, 'password' => $validated['password']];
		$throttleKey = 'login:' . $email . '|' . $request->ip();
		$employee = EmployeeInformation::where('email', $email)->first();

		if ($employee) {
			if ($employee->account_status === 'disabled') {
				return $this->loginError('Your account has been disabled.');
			}

			if ($employee->account_lock_datetime && now()->lt($employee->account_lock_datetime)) {
				return $this->loginError('Your account is locked.');
			}

			if ($employee->account_lock_datetime) {
				$employee->numberofincorrect_passwords = 0;
				$employee->account_lock_datetime = null;
				$employee->save();
			}

			if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
				return $this->loginError('Too many failed login attempts. Please try again later.');
			}

			if (Auth::guard('employee')->attempt($credentials)) {
				$employee->numberofincorrect_passwords = 0;
				$employee->account_lock_datetime = null;
				$employee->save();
				RateLimiter::clear($throttleKey);
				$request->session()->regenerate();

				return redirect()->route('dashboard');
			}

			$employee->numberofincorrect_passwords = (int) $employee->numberofincorrect_passwords + 1;
			if ($employee->numberofincorrect_passwords >= 5) {
				$employee->account_lock_datetime = now()->addMinutes(15);
			}
			$employee->save();
			RateLimiter::hit($throttleKey, 900);

			return $this->loginError(
				$employee->account_lock_datetime
					? 'Your account is locked. Please try again in 15 minutes.'
					: 'Invalid credentials',
			);
		}

		if (User::where('email', $email)->exists() && Auth::guard('web')->attempt($credentials)) {
			RateLimiter::clear($throttleKey);
			$request->session()->regenerate();

			return redirect()->route('dashboard');
		}

		RateLimiter::hit($throttleKey, 60);

		return $this->loginError('Invalid credentials');
	}

	private function loginError(string $message)
	{
		return redirect()->route('login')->with('error', $message);
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
