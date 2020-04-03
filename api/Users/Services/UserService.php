<?php

namespace Api\Users\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Api\Users\Events\UserWasCreated;
use Api\Users\Events\UserWasDeleted;
use Api\Users\Events\UserWasUpdated;
use Api\Users\Exceptions\UserNotFoundException;
use Api\Users\Models\User;
use Illuminate\Support\Arr;
use Kreait\Laravel\Firebase\Facades\FirebaseAuth;
use Spatie\QueryBuilder\QueryBuilder;

class UserService
{
	private $auth;

	private $database;

	private $dispatcher;

	public function __construct(
		AuthManager $auth,
		DatabaseManager $database,
		Dispatcher $dispatcher
	) {
		$this->auth = $auth;
		$this->database = $database;
		$this->dispatcher = $dispatcher;
	}

	// public function getAll($options = [])
	// {
	// 	Log::debug('fetching all users', ['options' => $options]);

	// 	return $this->repository->get($options);
	// }

	public function getByFbid($fbid): User
	{
		Log::debug('fetching user by fbid', ['fbid' => $fbid]);

		$user = QueryBuilder::for(User::where('fbid', $fbid))->first();

		if (empty($user)) {
			throw new UserNotFoundException();
		}

		return $user;
	}

	public function createRecipientUser($data): User
	{
		$user = User::create(
			Arr::only($data, ['phone', 'name_first', 'name_last'])
		);

		Log::debug('created user', ['user_id' => $user->id]);

		$fUser = FirebaseAuth::createUser([
			'phoneNumber' => sprintf('+1%d', substr($data['phone'], 0, 10)),
		]);

		$user->fbid = $fUser->uid;
		$user->save();

		Log::info('created user', ['user_id' => $user->id, 'fbid' => $user->fbid]);

		return $user;
	}

	protected function getRequestedUser($id): User
	{
		$id = expand_uuid($id);
		$user = User::find($id);

		if (empty($user)) {
			throw new UserNotFoundException();
		}

		return $user;
	}
}
