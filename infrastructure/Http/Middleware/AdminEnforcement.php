<?php

namespace Infrastructure\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Auth\AuthenticationException as IlluminateAuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as IlluminateAuthenticate;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Exceptions\AuthenticationException;

class AdminEnforcement extends IlluminateAuthenticate
{
	/**
	 * Enforce authentication.
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
		if (app()->env === 'testing') {
			return $next($request);
		}

		$token = $request->bearerToken();

		if (empty($token)) {
			Log::debug('no admin token provided');

			throw new AuthenticationException();
		}

		$tokens = config('auth.admin.tokens');

		foreach ($tokens as $t) {
			if ($token === $t) {
				return $next($request);
			}
		}

		Log::debug('no admin token match');

		throw new AuthenticationException();
	}

}
