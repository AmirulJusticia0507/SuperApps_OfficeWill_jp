<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
		$status = Password::broker('employee')->reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user, $password) {
				$user->password = Hash::make($password);
				$user->save();
			}
		);

        if ($status === Password::PASSWORD_RESET) {
            Session::flash('success', 'Your password has been reset successfully. You can now log in with your new password.');
            return redirect()->route('login');
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }
}
