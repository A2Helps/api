<?php

namespace TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Exceptions\TEMPLATE_UC_CAMELNotFoundException;
use TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Models\TEMPLATE_UC_CAMEL;

class TEMPLATE_UC_CAMELService
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
		Log::debug('fetching all TEMPLATE_LC_PLURAL_SNAKE');
	}

	public function getById($id): TEMPLATE_UC_CAMEL
	{
		Log::debug('fetching TEMPLATE_LC_SNAKE', ['TEMPLATE_LC_SNAKE_id' => $id]);
	}

	public function create($data): TEMPLATE_UC_CAMEL
	{
		Log::info('created TEMPLATE_LC_SNAKE', ['TEMPLATE_LC_SNAKE_id' => $TEMPLATE_LC_CAMEL->id]);
	}

	public function update($id, array $data): TEMPLATE_UC_CAMEL
	{
		Log::info('updated TEMPLATE_LC_SNAKE', ['TEMPLATE_LC_SNAKE_id' => $id]);
	}

	public function delete($id): void
	{
		Log::info('deleted TEMPLATE_LC_SNAKE', ['TEMPLATE_LC_SNAKE_id' => $id]);
	}

	private function getRequestedTEMPLATE_UC_CAMEL($id): TEMPLATE_UC_CAMEL
	{
		$id = expand_uuid($id);
		$TEMPLATE_LC_CAMEL = TEMPLATE_UC_CAMEL::find($id);

		if (empty($TEMPLATE_LC_CAMEL)) {
			throw new TEMPLATE_UC_CAMELNotFoundException();
		}

		return $TEMPLATE_LC_CAMEL;
	}
}
