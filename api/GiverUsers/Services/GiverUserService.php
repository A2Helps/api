<?php

namespace Api\GiverUsers\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\GiverUsers\Exceptions\GiverUserNotFoundException;
use Api\GiverUsers\Models\GiverUser;

class GiverUserService
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

	// public function getAll(): QueryBuilder
	// {
	// 	Log::debug('fetching all giver_users');
	// }

	// public function getById($id): QueryBuilder
	// {
	// 	Log::debug('fetching giver_user', ['giver_user_id' => $id]);
	// }

	// public function create($data): GiverUser
	// {
	// 	Log::info('created giver_user', ['giver_user_id' => $giverUser->id]);
	// }

	// public function update($id, array $data): GiverUser
	// {
	// 	Log::info('updated giver_user', ['giver_user_id' => $id]);
	// }

	// public function delete($id): void
	// {
	// 	Log::info('deleted giver_user', ['giver_user_id' => $id]);
	// }

	protected function getRequestedGiverUser($id): GiverUser
	{
		$id = expand_uuid($id);
		$giverUser = GiverUser::find($id);

		if (empty($giverUser)) {
			throw new GiverUserNotFoundException();
		}

		return $giverUser;
	}
}
