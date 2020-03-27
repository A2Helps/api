<?php

namespace Infrastructure\Auth\Providers;

use Illuminate\Support\Facades\Log;
Use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Api\ApiTokens\Models\ApiToken;

class ApiTokenUserProvider implements UserProvider
{
	const CREDENTIAL_KEY = 'api_token';

	public function __construct()
	{

	}

	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveByCredentials(array $credentials)
	{
		// first thing we check is that we have a valid token,
		// and if not return ASAP and without lookups
		if (empty($credentials[static::CREDENTIAL_KEY])) {
			return null;
		}

		$token = $credentials[static::CREDENTIAL_KEY];
		if (strlen($token) !== ApiToken::TOKEN_LENGTH) {
			return null;
		}

		Log::debug('Validating access token');
		$st = microtime(true);

		$s = app()->ApiTokenService;
		$token = hash('sha256', $token);

		$at = $s->getByToken($token);

		if (empty($at)) {
			return $this->rejectToken($st, 'not found', $token);
		}

		if ($at->revoked) {
			return $this->rejectToken($st, 'revoked', $token, $at->id);
		}

		if ($at->expires_at && $at->expires_at->isBefore(now())) {
			return $this->rejectToken($st, 'expired', $token, $at->id);
		}

		Log::info('Accepted access token', [
			'atId' => $at->id,
			'duration' => round(microtime(true) - $st, 3),
		]);

		return $at->user;
	}

	private function rejectToken(float $st, string $reason, $token, int $atId = null)
	{
		$dur = round(microtime(true) - $st, 3);

		Log::info('Invalid access token', [
			'reson'    => $reason,
			'token'    => $token,
			'atId'     => $atId,
			'duration' => $dur,
		]);

		return null;
	}

	/**
	 * Retrieve a user by their unique identifier.
	 *
	 * @param  mixed  $identifier
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveById($identifier) {}

	/**
	 * Retrieve a user by their unique identifier and "remember me" token.
	 *
	 * @param  mixed  $identifier
	 * @param  string  $token
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	public function retrieveByToken($identifier, $token) {}

	/**
	 * Update the "remember me" token for the given user in storage.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
	 * @param  string  $token
	 * @return void
	 */
	public function updateRememberToken(Authenticatable $user, $token) {}

	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
	 * @param  array  $credentials
	 * @return bool
	 */
	public function validateCredentials(Authenticatable $user, array $credentials) {}
}
