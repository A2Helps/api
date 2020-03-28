<?php

namespace Api\Orgs\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Orgs\Events\OrgWasCreated;
use Api\Orgs\Events\OrgWasDeleted;
use Api\Orgs\Events\OrgWasUpdated;
use Api\Orgs\Exceptions\OrgNotFoundException;
use Api\Orgs\Models\Org;
use Illuminate\Support\Collection;

class OrgService
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
	// 	Log::debug('fetching all orgs');
	// }

	// public function getById($id): Org
	// {
	// 	Log::debug('fetching org', ['org_id' => $id]);
	// }

	// public function create($data): Org
	// {
	// 	Log::info('created org', ['org_id' => $org->id]);
	// }

	// public function update($id, array $data): Org
	// {
	// 	Log::info('updated org', ['org_id' => $id]);
	// }

	// public function delete($id): void
	// {
	// 	Log::info('deleted org', ['org_id' => $id]);
	// }

	private function getRequestedOrg($id): Org
	{
		$id = expand_uuid($id);
		$org = Org::find($id);

		if (empty($org)) {
			throw new OrgNotFoundException();
		}

		return $org;
	}
}
