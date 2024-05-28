<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarComponent extends Component
{
	/**
	 * Create a new component instance.
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string
	{
		$yourCompany = null;
		$isSysAdmin = true;
		$isEmployeeRegis = $isCourseEnroll = $isAttendenceSetting = false;
		if (auth()->guard('employee')->check()) {
			$user = auth()->guard('employee')->user();
			$yourCompany = \App\Models\CompanyInformation::where(
				'company_id',
				$user->company_id,
			)->first();
			$isSysAdmin = $user->employee_affiliation->system_administrator_privileges == 1;
			$isEmployeeRegis = $user->employee_affiliation->employee_registration_authority == 1;
			$isCourseEnroll = $user->employee_affiliation->course_enrollment_privileges == 1;
			$isAttendenceSetting = $user->employee_affiliation->attendance_setting_authority == 1;
		}

		return view('components.sidebar-component', compact('yourCompany', 'isSysAdmin', 'isEmployeeRegis', 'isCourseEnroll', 'isAttendenceSetting'));
	}
}
