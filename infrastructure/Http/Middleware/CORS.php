<?php

namespace Infrastructure\Http\Middleware;

use Closure;
use Log;

class Cors
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$rsp = $next($request);

		$class = get_class($rsp);

		if ($class === 'Symfony\Component\HttpFoundation\BinaryFileResponse') {
			$this->setHeaders(function ($header) use ($rsp) {
				$rsp->headers->set($header[0], $header[1]);
			});
		}
		else if ($class !== 'Symfony\Component\HttpFoundation\Response') {
			$this->setHeaders(function ($header) use ($rsp) {
				$rsp->header($header[0], $header[1]);
			});
		}

		return $rsp;
	}

	protected function setHeaders(Closure $set)
	{
		$origin = '*';

		$allowedHeaders = [
			'X-XSRF-Token',
			'X-CSRF-Token',
			'X-Requested-With',
			'X-V-Rsession',
			'Content-Type',
			'Authorization',
			'Cache-Control',
		];

		$headers = [
			['Access-Control-Allow-Origin', $origin],
			['Access-Control-Allow-Headers', implode(', ', $allowedHeaders)],
			['Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS'],
			['X-Served-By', 'UniqueIdGoesHere'],
			['X-XSS-Protection', '1; mode=block'],
		];

		foreach($headers as $h) {
			$set($h);
		}
	}
}
