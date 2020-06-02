<?php

namespace Api\Merchants\Services;

use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Api\Merchants\Exceptions\MerchantNotFoundException;
use Api\Merchants\Models\Merchant;
use Illuminate\Support\Arr;
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

	public function getById($id): Merchant
	{
		$id = expand_uuid($id);

		Log::debug('fetching merchant', ['merchant_id' => $id]);

		$merchant = QueryBuilder::for(Merchant::where('id', $id))
			->first();

		if (empty($merchant) || ! $merchant->active) {
			throw new MerchantNotFoundException();
		}

		return $merchant;
	}

	public function update($id, array $data): Merchant
	{
		$id = expand_uuid($id);
		$merchant = $this->getRequestedMerchant($id);

		if (!empty($data['amounts'])) {
			$data['amounts'] = preg_replace('/[^0-9,]/', '', $data['amounts']);
			$x = explode(',', $data['amounts']);
			$data['amounts'] = array_filter($x, fn($x) => !empty($x));
		}

		$merchant->fill(Arr::only($data, ['name', 'img_url', 'gc_url', 'active', 'amounts', 'custom_amount']));
		$merchant->save();

		Log::info('updated merchant', ['merchant_id' => $merchant->id]);

		return $merchant->fresh();
	}

	public function create($data): Merchant
	{
		$data = Arr::only($data, ['name', 'img_url', 'gc_url', 'active', 'custom_amount', 'amounts']);

		if (!empty($data['amounts'])) {
			$data['amounts'] = preg_replace('/[^0-9,]/', '', $data['amounts']);
			$x = explode(',', $data['amounts']);
			$data['amounts'] = array_filter($x, fn($x) => !empty($x));
		}

		$merchant = Merchant::create($data);

		Log::info('created merchant', ['merchant_id' => $merchant->id]);

		return $merchant;
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
