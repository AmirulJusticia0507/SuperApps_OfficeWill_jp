<?php

namespace App\Http\Controllers;

use App\Models\EmployeeInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
	public function show(): View
	{
		$account = $this->currentAccount();
		$isEmployee = $account instanceof EmployeeInformation;
		$displayName = $isEmployee ? $account->fullname : $account->name;
		$profilePhotoUrl = $account->profile_photo_path
			? Storage::disk('public')->url($account->profile_photo_path)
			: null;

		return view('profile.show', compact('account', 'isEmployee', 'displayName', 'profilePhotoUrl'));
	}

	public function updatePassword(Request $request): RedirectResponse
	{
		$account = $this->currentAccount();
		$validated = $request->validate([
			'current_password' => ['required', 'string'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);

		if (!Hash::check($validated['current_password'], $account->getAuthPassword())) {
			return back()->withErrors(['current_password' => __('The current password is incorrect.')]);
		}

		$account->password = $validated['password'];
		if ($account instanceof EmployeeInformation) {
			$account->numberofincorrect_passwords = 0;
			$account->account_lock_datetime = null;
		}
		$account->save();

		return back()->with('success', __('Your password has been changed.'));
	}

	public function updatePhoto(Request $request): RedirectResponse
	{
		$request->validate([
			'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
		]);

		$account = $this->currentAccount();
		$directory = $account instanceof EmployeeInformation
			? 'profile-photos/employees/' . $account->employee_id
			: 'profile-photos/users/' . $account->getKey();
		$newPath = $request->file('photo')->store($directory, 'public');
		if (!$newPath) {
			return back()->withErrors(['photo' => __('The profile photo could not be saved.')]);
		}

		$oldPath = $account->profile_photo_path;
		$account->profile_photo_path = $newPath;
		$account->save();
		if ($oldPath && $oldPath !== $newPath) {
			Storage::disk('public')->delete($oldPath);
		}

		return back()->with('success', __('Your profile photo has been updated.'));
	}

	public function deletePhoto(): RedirectResponse
	{
		$account = $this->currentAccount();
		if ($account->profile_photo_path) {
			Storage::disk('public')->delete($account->profile_photo_path);
			$account->profile_photo_path = null;
			$account->save();
		}

		return back()->with('success', __('Your profile photo has been removed.'));
	}

	private function currentAccount(): EmployeeInformation|\App\Models\User
	{
		$employee = auth()->guard('employee')->user();
		if ($employee) {
			return $employee;
		}

		return auth()->guard('web')->user();
	}
}
