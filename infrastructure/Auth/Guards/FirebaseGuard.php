<?php

namespace Infrastructure\Auth\Guards;

use Illuminate\Auth\TokenGuard as IlluminateTokenGuard;

class FirebaseGuard extends IlluminateTokenGuard
{
	/**
	 * Get the token for the current request.
	 *
	 * @return string
	 */
	public function getTokenForRequest()
	{
		$token = $this->request->query($this->inputKey);

		if (empty($token)) {
			$token = $this->request->bearerToken();
		}

		return $token;
	}
}
