<?php

namespace Admin\Users\Services;

use Exception;
use Illuminate\Support\Facades\Log;
// use Admin\Users\Events\UserWasCreated;
// use Admin\Users\Events\UserWasDeleted;
// use Admin\Users\Events\UserWasUpdated;
use Api\Users\Exceptions\UserNotFoundException;
use Api\Users\Models\User;
use Api\Users\Services\UserService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Kreait\Laravel\Firebase\Facades\FirebaseAuth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AdminUserService extends UserService
{
	private $auth;

	private $database;

	private $dispatcher;

	public function getAll(): Collection
	{
		Log::debug('fetching all users');

		return QueryBuilder::for(User::class)
			->allowedFilters([
				AllowedFilter::exact('id'),
				'email',
			])
			->get();
	}

	public function getById($id): User
	{
		$id = expand_uuid($id);
		Log::debug('fetching user', ['user_id' => $id]);

		$user = QueryBuilder::for(User::where('id', $id))->first();

		if (empty($user)) {
			throw new UserNotFoundException();
		}

		return $user;
	}

	public function create($data): User
	{
		$user = User::create(
			Arr::only($data, ['email', 'name_first', 'name_last'])
		);

		Log::info('created user', ['user_id' => $user->id]);

		$userProperties = [
			'email'       => $data['email'],
			'password'    => $data['password'],
			'displayName' => sprintf('%s %s', $data['name_first'], $data['name_last']),

			'emailVerified' => false,
			'disabled'      => false,
		];

		$fUser = FirebaseAuth::createUser($userProperties);

		$user->fbid = $fUser->uid;
		$user->save();

		Log::info('created user', ['user_id' => $user->id]);

		return $user;
	}

	public function update($id, array $data): User
	{
		$id = expand_uuid($id);
		$user = $this->getRequestedUser($id);

		if (! empty($data['password'])) {
			FirebaseAuth::changeUserPassword($user->fbid, $data['password']);
			Log::info('updated user password', ['user_id' => $user->id, 'fbid' => $user->fbid]);
		}

		Arr::forget($data, ['password', 'email']);

		$user->fill($data);
		$user->save();

		Log::info('updated user', ['user_id' => $user->id]);

		return $user;
	}

	public function delete($userId): void
	{
		$user = $this->getRequestedUser($userId);

		$this->repository->delete($userId);
		Log::info('deleted user', ['user_id' => $userId]);
	}
}
