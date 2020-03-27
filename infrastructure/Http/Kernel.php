<?php

namespace Infrastructure\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Infrastructure\Http\Middleware\AuthCheck;

class Kernel extends HttpKernel
{
	/**
	* The application's global HTTP middleware stack.
	*
	* These middleware are run during every request to your application.
	*
	* @var array
	*/
	protected $middleware = [
		\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		\Infrastructure\Http\Middleware\RequestId::class,
		\Infrastructure\Http\Middleware\AuthCheck::class,
		\Infrastructure\Http\Middleware\EncryptCookies::class,
		\Infrastructure\Http\Middleware\CORS::class,
		\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
		\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
		\Infrastructure\Http\Middleware\ExecutionTime::class,
	];

	/**
	* The application's route middleware groups.
	*
	* @var array
	*/
	protected $middlewareGroups = [

	];

	/**
	* The application's route middleware.
	*
	* These middleware may be assigned to groups or used individually.
	*
	* @var array
	*/
	protected $routeMiddleware = [
		'admin' => \Infrastructure\Http\Middleware\AdminEnforcement::class,
		'auth' => \Infrastructure\Http\Middleware\AuthEnforcement::class,
		'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
		'can' => \Illuminate\Auth\Middleware\Authorize::class,
		// 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
		'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

		'api_token_scopes' => \Infrastructure\Http\Middleware\ApiToken\CheckScopes::class,
		'api_token_scope' => \Infrastructure\Http\Middleware\ApiToken\CheckForAnyScope::class,
	];
}
