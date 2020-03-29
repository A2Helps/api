<?php

namespace Admin\Orgs\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Orgs\Exceptions\OrgNotFoundException;
use Api\Orgs\Models\Org;
use Api\Orgs\Services\OrgService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;

class AdminOrgService extends OrgService
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
		Log::debug('fetching all orgs');

		return QueryBuilder::for(Org::class)
			->allowedIncludes(['org_members.user'])
			->allowedFilters([
				AllowedFilter::exact('id'),
				'name',
				AllowedFilter::exact('enabled'),
			])
			->get();
	}

	public function getById($id): Org
	{
		$id = expand_uuid($id);
		Log::debug('fetching org', ['org_id' => $id]);

		$org = QueryBuilder::for(Org::where('id', $id))
			->allowedIncludes(['org_members.user'])
			->first();

		if (empty($org)) {
			throw new OrgNotFoundException();
		}

		return $org;
	}

	public function create($data): Org
	{
		$data['count_distributed'] = 0;
		$org = Org::create(
			Arr::only($data, ['name', 'allotment', 'enabled', 'count_distributed'])
		);

		Log::info('created org', ['org_id' => $org->id]);

		return $org;
	}

	public function update($id, array $data): Org
	{
		$id = expand_uuid($id);
		$org = $this->getRequestedOrg($id);

		if (!empty($data['allotment']) && $data['allotment'] < $org->count_distributed) {
			$data['allotment'] = $org->count_distributed;
		}

		$org->fill(Arr::only($data, ['enabled', 'allotment']));
		$org->save();

		Log::info('updated org', ['org_id' => $org->id]);

		return $org;
	}

	public function delete($id): void
	{
		// Log::info('deleted org', ['org_id' => $id]);
	}

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
