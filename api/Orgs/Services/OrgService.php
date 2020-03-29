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
use Illuminate\Support\Facades\Auth;
use Infrastructure\Exceptions\UnauthorizedException;
use Spatie\QueryBuilder\AllowedFilter;

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

	public function getAll(): Collection
	{
		$user = Auth::user();
		Log::debug('fetching all orgs');

		if (empty($user->orgMember)) {
			throw new UnauthorizedException();
		}

		return QueryBuilder::for(Org::where('id', $user->orgMember->org_id))
			->allowedIncludes(['org_members.user', 'codes'])
			->allowedFilters([
				AllowedFilter::exact('id'),
				'name',
				AllowedFilter::exact('enabled'),
			])
			->get();
	}

	public function getById($id): Org
	{
		$user = Auth::user();
		$id = expand_uuid($id);

		if (empty($user->orgMember) || $id !== $user->orgMember->org_id) {
			throw new UnauthorizedException();
		}

		Log::debug('fetching org', ['org_id' => $id]);

		$org = QueryBuilder::for(Org::where('id', $id))
			->allowedIncludes(['org_members.user', 'codes'])
			->first();

		if (empty($org)) {
			throw new OrgNotFoundException();
		}

		return $org;
	}

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
