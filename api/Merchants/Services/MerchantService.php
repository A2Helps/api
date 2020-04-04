<?php

namespace Api\Merchants\Services;

use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Api\Merchants\Exceptions\MerchantNotFoundException;
use Api\Merchants\Models\Merchant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MerchantService
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
		Log::debug('fetching all merchants');

		return QueryBuilder::for(Merchant::class)
			->allowedFilters([
				AllowedFilter::exact('id'),
				'name',
				AllowedFilter::exact('active'),
			])
			->get();
	}

	protected function getRequestedMerchant($id): Merchant
	{
		$id = expand_uuid($id);
		$merchant = Merchant::find($id);

		if (empty($merchant)) {
			throw new MerchantNotFoundException();
		}

		return $merchant;
	}
}
