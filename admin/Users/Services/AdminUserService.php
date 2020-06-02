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
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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

		if (! empty($data['operator'])) {
			$user->operator = (bool) $data['operator'];
		}

		if (! empty($data['admin'])) {
			$user->admin = (bool) $data['admin'];
		}

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

		$lc = new LogContext(['user_id' => $userId]);
		$lc->info('deleting user');

		DB::transaction(function () use (&$user, $lc) {
			if ($user->fbid) {
				$lc->info('deleting firebase user', ['fbid' => $user->fbid]);
				FirebaseAuth::deleteUser($user->fbid);
			}

			$user->recipients->each(function($r) use ($lc) {
				$r->codes->each(function($c) use ($lc) {
					$lc->info('removing recipient from code', ['recipient_id' => $c->recipeint_id, 'code_id' => $c->id]);
					$c->recipient_id = null;
					$c->redeemed = false;
					$c->redeemed_at = null;
					$c->save();
				});

				$lc->info('deleting recipient', ['recipient_id' => $r->id]);
				$r->forceDelete();
			});

			$user->forceDelete();
		});

		$lc->info('deleted user');
	}

	public function deleteByPhone(string $phone): void
	{
		$user = $this->getByPhone($phone);

		$this->delete($user->id);
	}

	public function createAuthToken($id): array
	{
		$user = $this->getRequestedUser($id);

		Log::info('creating custom token for user', ['user_id' => $user->id, 'fbid' => $user->fbid]);

		$token = (string) FirebaseAuth::createCustomToken($user->fbid);
		$signIn = FirebaseAuth::signInWithCustomToken($token);

		return [
			'token' => $signIn->idToken()
		];
	}
}
