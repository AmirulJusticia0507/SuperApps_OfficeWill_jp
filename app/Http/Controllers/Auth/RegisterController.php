<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeInformation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
		if (auth()->guard('web')->check() || auth()->guard('employee')->check()) {
			return redirect()->route('dashboard');
		}

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
		if (auth()->guard('web')->check() || auth()->guard('employee')->check()) {
			return redirect()->route('dashboard');
		}

		$email = Str::lower(trim((string) $request->input('email')));
		$request->merge(['email' => $email]);
		$validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

		if (EmployeeInformation::whereRaw('LOWER(email) = ?', [$email])->exists()) {
			return back()
				->withErrors(['email' => __('This email already belongs to an employee account. Please log in with it.')])
				->withInput($request->except(['password', 'password_confirmation']));
		}

        $photoPath = $request->file('photo')?->store('profile-photos/users', 'public');
        if ($request->hasFile('photo') && !$photoPath) {
            return back()
                ->withErrors(['photo' => __('The profile photo could not be saved.')])
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'profile_photo_path' => $photoPath,
        ]);

        // Optionally, you can login the user after registration
        // auth()->login($user);

        return redirect()->route('login')->with('success', __('Registration successful. Please log in.'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
