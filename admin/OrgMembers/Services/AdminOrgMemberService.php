<?php

namespace Admin\OrgMembers\Services;

use Admin\Orgs\AdminOrgFacade;
use Admin\Users\AdminUserFacade;
use Api\Orgs\Exceptions\OrgNotFoundException;
use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Api\OrgMembers\Models\OrgMember;
use Api\OrgMembers\Services\OrgMemberService;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\AllowedFilter;

class AdminOrgMemberService extends OrgMemberService
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
		Log::debug('fetching all org_members');

		return QueryBuilder::for(OrgMember::class)
			->allowedIncludes(['org'])
			->allowedFilters([
				AllowedFilter::exact('id'),
				AllowedFilter::exact('user_id'),
				AllowedFilter::exact('org_id'),
			])
			->get();
	}

	public function getById($id): OrgMember
	{
		$id = expand_uuid($id);
		Log::debug('fetching org_member', ['org_member_id' => $id]);

		$org = QueryBuilder::for(OrgMember::where('id', $id))
			->allowedIncludes(['org'])
			->first();

		if (empty($org)) {
			throw new OrgNotFoundException();
		}

		return $org;
	}

	public function create($data): OrgMember
	{
		$data['count_distributed'] = 0;
		$data['user_id'] = expand_uuid($data['user_id']);
		$data['org_id'] = expand_uuid($data['org_id']);

		AdminOrgFacade::getById($data['org_id']);
		AdminUserFacade::getById($data['user_id']);

		$orgUser = OrgMember::create(
			Arr::only($data, ['user_id', 'org_id', 'allotment', 'enabled', 'count_distributed'])
		);

		Log::info('created org_member', ['org_member_id' => $orgUser->id]);

		return $orgUser;
	}

	public function update($id, array $data): OrgMember
	{
		$id = expand_uuid($id);
		$gu = $this->getRequestedOrgMember($id);

		if (!empty($data['allotment']) && $data['allotment'] < $gu->count_distributed) {
			$data['allotment'] = $gu->count_distributed;
		}

		$gu->fill(Arr::only($data, ['enabled', 'allotment']));
		$gu->save();

		Log::info('updated org_member', ['org_member_id' => $gu->id]);

		return $gu;
	}

	public function delete($id): void
	{
		// Log::info('deleted org_member', ['org_member_id' => $id]);
	}
}
