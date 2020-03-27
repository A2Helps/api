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

	// public function getById($id)
	// {
	// 	Log::debug('fetching user', ['user_id' => $id, 'options' => $options]);
	// 	$user = $this->getRequestedUser($id);

	// 	return $user;
	// }

	// public function create($data)
	// {
	// 	$user = $this->repository->create($data);
	// 	Log::info('created user', ['user_id' => $user->id]);

	// 	$this->dispatcher->dispatch(new UserWasCreated($user));

	// 	return $user;
	// }

	// public function update($userId, array $data)
	// {
	// 	$user = $this->getRequestedUser($userId);

	// 	$this->repository->update($user, $data);
	// 	Log::info('updated user', ['user_id' => $user->id]);

	// 	$this->dispatcher->dispatch(new UserWasUpdated($user));

	// 	return $user;
	// }

	// public function delete($userId)
	// {
	// 	$user = $this->getRequestedUser($userId);

	// 	$this->repository->delete($userId);
	// 	Log::info('deleted user', ['user_id' => $userId]);

	// 	$this->dispatcher->dispatch(new UserWasDeleted($user));
	// }

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
