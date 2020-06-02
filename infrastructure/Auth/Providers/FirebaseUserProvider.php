<?php

namespace Infrastructure\Auth\Providers;

use Api\Users\Exceptions\UserNotFoundException;
use Api\Users\UserFacade;
use Firebase\Auth\Token\Exception\ExpiredToken;
use Firebase\Auth\Token\Exception\InvalidSignature;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Support\Facades\Log;
Use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use InvalidArgumentException;
use Kreait\Laravel\Firebase\Facades\FirebaseAuth;

class FirebaseUserProvider implements UserProvider
{
	const CREDENTIAL_KEY = 'firebase';

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

		$credential = $credentials[static::CREDENTIAL_KEY];

		Log::debug('Validating access token');
		$st = microtime(true);

		try {
			$token = FirebaseAuth::verifyIdToken($credential);
		} catch (ExpiredToken $e) {
			// expired
			return $this->rejectToken($st, 'expired token', $credential);
		} catch (InvalidToken $e) {
			// invalid
			return $this->rejectToken($st, 'invalid token', $credential);
		} catch (InvalidArgumentException $e) {
			// malformed
			return $this->rejectToken($st, 'malformed token', $credential);
		}

		$uid = $token->getClaim('sub');
		Log::debug('UID', ['uid' => $uid]);

		try {
			$user = UserFacade::getByFbid($uid);
		} catch (UserNotFoundException $e) {
			Log::info('received access token for fb user which does not exist', [
				'fbid' => $uid,
			]);

			return $this->rejectToken($st, 'auth error', $credential);
		}

		Log::info('Accepted access token', [
			'user_id' => $user->id,
			'uid' => $uid,
			'duration' => round(microtime(true) - $st, 3),
		]);

		return $user;
	}

	private function rejectToken(float $st, string $reason, $token)
	{
		$dur = round(microtime(true) - $st, 3);

		Log::info('Invalid token', [
			'reson'    => $reason,
			'token'    => $token,
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
