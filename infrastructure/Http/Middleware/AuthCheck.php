<?php

namespace Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException as IlluminateAuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as IlluminateAuthenticate;
use Illuminate\Support\Facades\Auth;

class AuthCheck extends IlluminateAuthenticate
{
	/**
	 * Check authentication. Do not enforce, allowing us
	 * to optionally authenticate a route.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string[]  ...$guards
	 * @return mixed
	 *
	 * @throws \Infrastructure\Exceptions\UnauthorizedException
	 */
	public function handle($request, Closure $next, ...$guards)
	{
		try {
			$this->authenticate($request, config('auth.defaults.api_guards'));
		} catch (IlluminateAuthenticationException $e) {
			return $next($request);
		}

		$request->request->add([
			'xtra-user_id' => Auth::user()->id,
		]);

		return $next($request);
	}

}
