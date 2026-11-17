<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LimitWebUserAccess
{
	private const ALLOWED_ROUTES = [
		'dashboard' => ['GET', 'HEAD'],
		'profile.show' => ['GET', 'HEAD'],
		'profile.password.update' => ['PUT'],
		'profile.photo.update' => ['PUT'],
		'profile.photo.destroy' => ['DELETE'],
		'course-list' => ['GET', 'HEAD'],
		'course.filter' => ['GET', 'HEAD'],
		'course-information.show' => ['GET', 'HEAD'],
		'confirm-courses.index' => ['GET', 'HEAD'],
		'confirm-courses.certificate' => ['GET', 'HEAD'],
		'confirm-courses.attendence' => ['GET', 'HEAD'],
		'confirm-courses.todo-answer.index' => ['GET', 'HEAD'],
		'confirm-courses.todo-answer.store' => ['POST'],
		'confirm-courses.todo-answer.scoring' => ['GET', 'HEAD'],
	];

	public function handle(Request $request, Closure $next): Response
	{
		if (!auth()->guard('web')->check() || auth()->guard('employee')->check()) {
			return $next($request);
		}

		$routeName = $request->route()?->getName();
		$allowedMethods = self::ALLOWED_ROUTES[$routeName] ?? [];

		abort_unless(in_array($request->method(), $allowedMethods, true), 403, 'You are not authorized to access this area.');

		return $next($request);
	}
}
