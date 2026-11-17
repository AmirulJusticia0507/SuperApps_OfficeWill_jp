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
		$isSysAdmin = false;
		$isEmployeeRegis = $isCourseEnroll = $isAttendenceSetting = false;
		$isLimitedUser = auth()->guard('web')->check() && !auth()->guard('employee')->check();
		if (auth()->guard('employee')->check()) {
			$user = auth()->guard('employee')->user();
			$yourCompany = \App\Models\CompanyInformation::where(
				'company_id',
				$user->company_id,
			)->first();
			$affiliation = $user->employee_affiliation;
			$isSysAdmin = $affiliation?->system_administrator_privileges == 1;
			$isEmployeeRegis = $affiliation?->employee_registration_authority == 1;
			$isCourseEnroll = $affiliation?->course_enrollment_privileges == 1;
			$isAttendenceSetting = $affiliation?->attendance_setting_authority == 1;
		}

		return view('components.sidebar-component', compact('yourCompany', 'isSysAdmin', 'isEmployeeRegis', 'isCourseEnroll', 'isAttendenceSetting', 'isLimitedUser'));
	}
}
