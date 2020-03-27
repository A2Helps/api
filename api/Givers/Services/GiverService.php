<?php

namespace Api\Givers\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Givers\Events\GiverWasCreated;
use Api\Givers\Events\GiverWasDeleted;
use Api\Givers\Events\GiverWasUpdated;
use Api\Givers\Exceptions\GiverNotFoundException;
use Api\Givers\Models\Giver;
use Illuminate\Support\Collection;

class GiverService
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

	// public function getAll(): Collection
	// {
	// 	Log::debug('fetching all givers');
	// }

	// public function getById($id): Giver
	// {
	// 	Log::debug('fetching giver', ['giver_id' => $id]);
	// }

	// public function create($data): Giver
	// {
	// 	Log::info('created giver', ['giver_id' => $giver->id]);
	// }

	// public function update($id, array $data): Giver
	// {
	// 	Log::info('updated giver', ['giver_id' => $id]);
	// }

	// public function delete($id): void
	// {
	// 	Log::info('deleted giver', ['giver_id' => $id]);
	// }

	private function getRequestedGiver($id): Giver
	{
		$id = expand_uuid($id);
		$giver = Giver::find($id);

		if (empty($giver)) {
			throw new GiverNotFoundException();
		}

		return $giver;
	}
}
