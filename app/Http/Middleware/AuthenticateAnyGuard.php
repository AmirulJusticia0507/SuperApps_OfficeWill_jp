<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;

class AuthenticateAnyGuard
{
	public function handle(Request $request, Closure $next): Response
	{
		App::setLocale($request->session()->get('locale', config('app.locale', 'ja')));

		if (Schema::hasTable('employee_information')) {
			$employeeGuard = auth()->guard('employee');
			if ($employeeGuard->check()) {
				$request->attributes->set('tenant.company_id', $employeeGuard->user()->company_id);
				return $next($request);
			}
		}

		if (auth()->guard('web')->check()) {
			return $next($request);
		}

		return redirect()->guest(route('login'));
	}
}
