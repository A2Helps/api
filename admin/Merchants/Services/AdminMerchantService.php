<?php

namespace Admin\Merchants\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Merchants\Exceptions\MerchantNotFoundException;
use Api\Merchants\Models\Merchant;
use Api\Merchants\Services\MerchantService;
use Api\Orgs\Models\Org;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use LogicException;
use Spatie\QueryBuilder\AllowedFilter;

class AdminMerchantService extends MerchantService
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
			->get();
	}

	public function getById($id): Merchant
	{
		$id = expand_uuid($id);
		Log::debug('fetching merchant', ['merchant_id' => $id]);

		$merchant = QueryBuilder::for(Merchant::where('id', $id))
			->first();

		if (empty($merchant)) {
			throw new MerchantNotFoundException();
		}

		return $merchant;
	}

	public function create($data): Merchant
	{
		$data = Arr::only($data, ['name', 'img_url', 'active', 'amounts']);

		if (!empty($data['amounts'])) {
			$data['amounts'] = explode(',', $data['amounts']);
		}

		$merchant = Merchant::create($data);

		Log::info('created merchant', ['merchant_id' => $merchant->id]);

		return $merchant;
	}

	public function update($id, array $data): Merchant
	{
		$id = expand_uuid($id);
		$merchant = $this->getRequestedMerchant($id);

		$merchant->fill(Arr::only($data, ['name', 'img_url', 'active']));

		if (! empty($data['amounts'])) {
			$merchant->amounts = explode(',', $data['amounts']);
		}

		$merchant->save();

		Log::info('updated merchant', ['merchant_id' => $merchant->id]);

		return $merchant;
	}
}
