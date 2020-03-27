<?php

namespace Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExecutionTime
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		$rsp = $next($request);

		Log::info('Execution Time', [
			'method' => $request->method(),
			'path' => $request->path(),
			'time' => round(microtime(true) - LARAVEL_START, 3),
		]);

		return $rsp;
	}
}
