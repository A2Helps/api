<?php

namespace Admin\Codes\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Codes\Exceptions\CodeNotFoundException;
use Api\Codes\Models\Code;
use Api\Codes\Services\CodeService;
use Api\Orgs\Models\Org;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use LogicException;
use Spatie\QueryBuilder\AllowedFilter;

class AdminCodeService extends CodeService
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
		Log::debug('fetching all codes');

		return QueryBuilder::for(Code::class)
			->get();
	}

	public function getById($id): Code
	{
		$id = expand_uuid($id);
		Log::debug('fetching code', ['code_id' => $id]);

		$code = QueryBuilder::for(Code::where('id', $id))
			->first();

		if (empty($code)) {
			throw new CodeNotFoundException();
		}

		return $code;
	}

	public function create($data): Code
	{
		$data = Arr::only($data, ['email', 'phone', 'org_id', 'org_member_id']);

		if (empty($data['org_id'])) {
			throw new InvalidArgumentException('org is required');
		}

		if (! empty($data['org_member_id'])) {
			$data['org_member_id'] = expand_uuid($data['org_member_id']);
		}

		if (! empty($data['email'])) {
			$data['email'] = strtolower($data['email']);
		}

		$x = null;
		while (true) {
			$x = strtoupper(Str::random(8));

			try {
				$this->getByCode($x);
			} catch (CodeNotFoundException $e) {
				break;
			}
		}

		$data['code'] = $x;
		$code = Code::create($data);

		Log::info('created code', ['code_id' => $code->id]);

		return $code;
	}

	public function allocate(Org $org): void
	{
		$lc = new LogContext(['org_id' => $org->id]);

		// get total
		$total = $org->codes->count();
		$used = $org->codes->filter(function($c) { return $c->used; })->count();

		if ($total === $org->allotment) {
			$lc->info('noop; all codes already allocated');
			return;
		}
		else if ($total > $org->allotment) {
			// TODO:
			// 1. remove those which have not been used
			// 2. if $used is greater than allotment, update allotment to be $used
			throw new Exception('not implemented');
		}
		else if ($total < $org->allotment) {
			$add = $org->allotment - $total;

			$lc->info('adding codes', ['count' => $add]);
			$this->addCodes($add, $org);
		}
		else {
			throw new LogicException();
		}
	}

	public function addCodes($count, Org $org): void
	{
		$total = 0;
		while ($total < $count) {
			$this->create([
				'org_id' => $org->id
			]);

			$total++;
		}
	}
}
