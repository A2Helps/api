<?php

namespace Infrastructure\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Auth\AuthenticationException as IlluminateAuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as IlluminateAuthenticate;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Exceptions\AuthenticationException;

class OperatorEnforcement extends IlluminateAuthenticate
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
	public function handle($request, Closure $next)
	{
		if (app()->env !== 'testing') {
			if (! Auth::check() || ! Auth::user()->operator) {
				Log::info('Authentication failure');

				throw new AuthenticationException();
			}
		}

		return $next($request);
	}

}
