<?php

namespace Api\Codes\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Codes\Exceptions\CodeNotFoundException;
use Api\Codes\Models\Code;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Infrastructure\Exceptions\UnauthorizedException;
use Infrastructure\Services\BaseService;
use Spatie\QueryBuilder\AllowedFilter;

class CodeService extends BaseService
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
		Log::debug('fetching all codes');

		return QueryBuilder::for(Code::where('org_id', $user->orgMember->org_id))
			->allowedFilters([
				'phone',
				'email',
				'sent',
				'printed',
				'distributed',
				AllowedFilter::scope('used'),
			])
			->get();
	}

	public function getById(string $id): Code
	{
		$id = expand_uuid($id);
		$user = Auth::user();
		Log::debug('fetching code', ['code_id' => $id]);

		$query = Code::where('org_id', $user->orgMember->org_id)->where('id', $id);
		$code = QueryBuilder::for($query)->first();

		if (empty($code)) {
			throw new CodeNotFoundException();
		}

		return $code;
	}

	public function getByCode(string $code): Code
	{
		$code = Code::where('code', $code)->first();

		if (empty($code)) {
			throw new CodeNotFoundException();
		}

		return $code;
	}

	public function update(string $id, array $data): Code
	{
		$id = expand_uuid($id);
		$user = Auth::user();

		$lc = new LogContext(['code_id' => $id]);
		$lc->debug('received request to update code');

		$code = $this->getRequestedCode($id);

		$this->checkUserOrgPerm($code->org_id);

		// FIXME:
		// $data = Arr::only($data, ['email', 'phone']);
		// if (! empty($data['email'])) {
		// 	$data['email'] = strtolower($data['email']);
		// }

		$code->fill(Arr::only($data, ['printed', 'sent', 'name']));

		// if code is now used, attach orgMember
		if ($code->used && empty($code->org_member_id)) {
			$code->org_member_id = $user->orgMember->id;
		}

		// mark code distributed if it has been printed
		if ($code->printed && ! $code->distributed) {
			$code->distributed = true;
			$code->org_member_id = $user->orgMember->id;

			$lc->info('marking code distributed', [
				'printed' => true
			]);
		}

		$code->save();
		$lc->info('updated code');

		if ($code->sent && ! $code->distributed) {
			$lc->warning('TODO: this is where we DISTRIB CODE', ['sent' => true]);
			// DistributeCode::dispatch($code);
		}

		return $code;
	}

	public function bulkUpdate(array $ids, array $data): Collection
	{
		$data = Arr::only($data, ['sent', 'printed']);
		$codes = new Collection();

		DB::transaction(function() use ($ids, $data, &$codes) {
			foreach ($ids as $id) {
				$codes->push($this->update($id, $data));
			}
		});

		return $codes;
	}

	private function getRequestedCode($id): Code
	{
		$id = expand_uuid($id);
		$code = Code::find($id);

		if (empty($code)) {
			throw new CodeNotFoundException();
		}

		return $code;
	}
}
