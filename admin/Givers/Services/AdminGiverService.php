<?php

namespace Admin\Givers\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Givers\Exceptions\GiverNotFoundException;
use Api\Givers\Models\Giver;
use Api\Givers\Services\GiverService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;

class AdminGiverService extends GiverService
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
		Log::debug('fetching all givers');

		return QueryBuilder::for(Giver::class)
			->allowedIncludes(['giver_users'])
			->allowedFilters([
				AllowedFilter::exact('id'),
				'name',
				AllowedFilter::exact('enabled'),
			])
			->get();
	}

	public function getById($id): Giver
	{
		$id = expand_uuid($id);
		Log::debug('fetching giver', ['giver_id' => $id]);

		$giver = QueryBuilder::for(Giver::where('id', $id))
			->allowedIncludes(['giver_users'])
			->first();

		if (empty($giver)) {
			throw new GiverNotFoundException();
		}

		return $giver;
	}

	public function create($data): Giver
	{
		$data['count_given'] = 0;
		$giver = Giver::create(
			Arr::only($data, ['name', 'allotment', 'enabled', 'count_given'])
		);

		Log::info('created giver', ['giver_id' => $giver->id]);

		return $giver;
	}

	public function update($id, array $data): Giver
	{
		$id = expand_uuid($id);
		$giver = $this->getRequestedGiver($id);

		if (!empty($data['allotment']) && $data['allotment'] < $giver->count_given) {
			$data['allotment'] = $giver->count_given;
		}

		$giver->fill(Arr::only($data, ['enabled', 'allotment']));
		$giver->save();

		Log::info('updated giver', ['giver_id' => $giver->id]);

		return $giver;
	}

	public function delete($id): void
	{
		// Log::info('deleted giver', ['giver_id' => $id]);
	}

	private function getRequestedGiver($id): Giver
	{
		$id = expand_uuid($id);
		$giver = Giver::find($id);

		if (empty($giver)) {
			throw new GiverNotFoundException();
		}

		return $giver;
	}
}
