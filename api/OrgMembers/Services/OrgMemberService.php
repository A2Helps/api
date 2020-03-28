<?php

namespace Api\OrgMembers\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\OrgMembers\Exceptions\OrgMemberNotFoundException;
use Api\OrgMembers\Models\OrgMember;

class OrgMemberService
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
	// 	Log::debug('fetching all org_members');
	// }

	// public function getById($id): QueryBuilder
	// {
	// 	Log::debug('fetching org_member', ['org_member_id' => $id]);
	// }

	// public function create($data): OrgMember
	// {
	// 	Log::info('created org_member', ['org_member_id' => $orgUser->id]);
	// }

	// public function update($id, array $data): OrgMember
	// {
	// 	Log::info('updated org_member', ['org_member_id' => $id]);
	// }

	// public function delete($id): void
	// {
	// 	Log::info('deleted org_member', ['org_member_id' => $id]);
	// }

	protected function getRequestedOrgMember($id): OrgMember
	{
		$id = expand_uuid($id);
		$orgUser = OrgMember::find($id);

		if (empty($orgUser)) {
			throw new OrgMemberNotFoundException();
		}

		return $orgUser;
	}
}
