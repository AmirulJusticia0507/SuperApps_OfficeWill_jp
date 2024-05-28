<?php

namespace App\View\Components;

use App\Models\AffiliationInformation;
use App\Models\EmployeeAttributeSettingInformation;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AttributeEmployeeComponent extends Component
{
	/**
	 * Create a new component instance.
	 */
	public function __construct()
	{
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string
	{
		$attribute = null;
		$affiliation_code = request()->affiliation_code;
		if ($affiliation_code) {
			$affiliationsByFilter = AffiliationInformation::where('affiliation_code', $affiliation_code)->first();
			$attribute = EmployeeAttributeSettingInformation::where('company_id', $affiliationsByFilter->company_id)->latest()->first();
		}

		return view('components.attribute-employee-component', compact('attribute'));
	}
}
