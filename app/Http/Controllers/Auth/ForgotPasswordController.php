<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmployeeInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming forgot password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
		$validated = $request->validate(['email' => ['required', 'email']]);
		$email = Str::lower($validated['email']);
		$broker = EmployeeInformation::where('email', $email)->exists()
			? 'employee'
			: 'users';

		if ($broker === 'users' && !User::where('email', $email)->exists()) {
			return back()->with('status', __('passwords.sent'));
		}

		$status = Password::broker($broker)->sendResetLink(['email' => $email]);

		if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }
}
