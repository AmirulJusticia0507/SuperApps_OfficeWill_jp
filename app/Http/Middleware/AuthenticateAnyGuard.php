<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAnyGuard
{
	public function handle(Request $request, Closure $next): Response
	{
		if (auth()->guard('employee')->check() || auth()->guard('web')->check()) {
			return $next($request);
		}

		return redirect()->guest(route('login'));
	}
}
