<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmployeeInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Show the reset password form.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle an incoming reset password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
		$validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string',
        ]);

		$email = Str::lower($validated['email']);
		$credentials = [
			'email' => $email,
			'password' => $validated['password'],
			'password_confirmation' => $validated['password_confirmation'],
			'token' => $validated['token'],
		];

		if (EmployeeInformation::where('email', $email)->exists()) {
			$status = Password::broker('employee')->reset(
				$credentials,
				function (EmployeeInformation $employee, string $password): void {
					$employee->forceFill([
						'password' => $password,
						'numberofincorrect_passwords' => 0,
						'account_lock_datetime' => null,
					])->save();
				},
			);
		} else {
			$status = Password::broker('users')->reset(
				$credentials,
				function (User $user, string $password): void {
					$user->forceFill(['password' => $password])->save();
				},
			);
		}

        if ($status === Password::PASSWORD_RESET) {
            Session::flash('success', 'Your password has been reset successfully. You can now log in with your new password.');
            return redirect()->route('login');
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }
}
