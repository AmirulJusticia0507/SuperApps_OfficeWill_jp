<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AuthenticateAnyGuard;
use App\Http\Middleware\RequireEmployeeAuthority;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
		$middleware->appendToGroup('web', \App\Http\Middleware\SetLocale::class);
		$middleware->alias([
			'auth.any' => AuthenticateAnyGuard::class,
			'authority' => RequireEmployeeAuthority::class,
		]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
