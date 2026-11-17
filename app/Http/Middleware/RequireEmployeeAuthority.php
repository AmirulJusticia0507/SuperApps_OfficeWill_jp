<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireEmployeeAuthority
{
	public function handle(Request $request, Closure $next, string ...$authorities): Response
	{
		$employee = auth()->guard('employee')->user();
		if (!$employee && auth()->guard('web')->check()) {
			return $next($request);
		}

		$affiliation = $employee?->employee_affiliation;

		if (!$affiliation) {
			abort(403, 'You are not authorized to access this area.');
		}

		$hasAuthority = $affiliation->system_administrator_privileges == 1;
		foreach ($authorities as $authority) {
			$hasAuthority = $hasAuthority || $affiliation->{$authority} == 1;
		}

		abort_unless($hasAuthority, 403, 'You are not authorized to access this area.');

		return $next($request);
	}
}
