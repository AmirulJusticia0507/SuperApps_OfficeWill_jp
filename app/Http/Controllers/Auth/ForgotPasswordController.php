<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Handle an incoming forgot password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validasi input
        $request->validate(['email' => 'required|email']);

        // Kirim email reset password
        $status = Password::sendResetLink($request->only('email'));

        // Berikan respons berdasarkan status pengiriman email
        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->route('password.request')->with('status', 'Reset password link has been sent to your email.');
        } else {
            return back()->withErrors(['email' => trans($status)]);
        }
    }
}

?>
