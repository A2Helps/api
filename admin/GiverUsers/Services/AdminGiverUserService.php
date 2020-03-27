<?php

namespace Admin\GiverUsers\Services;

use Admin\Givers\AdminGiverFacade;
use Admin\Users\AdminUserFacade;
use Api\Givers\Exceptions\GiverNotFoundException;
use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Api\GiverUsers\Models\GiverUser;
use Api\GiverUsers\Services\GiverUserService;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\AllowedFilter;

class AdminGiverUserService extends GiverUserService
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
		Log::debug('fetching all giver_users');

		return QueryBuilder::for(GiverUser::class)
			->allowedIncludes(['giver'])
			->allowedFilters([
				AllowedFilter::exact('id'),
				AllowedFilter::exact('user_id'),
				AllowedFilter::exact('giver_id'),
			])
			->get();
	}

	public function getById($id): GiverUser
	{
		$id = expand_uuid($id);
		Log::debug('fetching giver_user', ['giver_user_id' => $id]);

		$giver = QueryBuilder::for(GiverUser::where('id', $id))
			->allowedIncludes(['giver'])
			->first();

		if (empty($giver)) {
			throw new GiverNotFoundException();
		}

		return $giver;
	}

	public function create($data): GiverUser
	{
		$data['count_given'] = 0;
		$data['user_id'] = expand_uuid($data['user_id']);
		$data['giver_id'] = expand_uuid($data['giver_id']);

		AdminGiverFacade::getById($data['giver_id']);
		AdminUserFacade::getById($data['user_id']);

		$giverUser = GiverUser::create(
			Arr::only($data, ['user_id', 'giver_id', 'allotment', 'enabled', 'count_given'])
		);

		Log::info('created giver_user', ['giver_user_id' => $giverUser->id]);

		return $giverUser;
	}

	public function update($id, array $data): GiverUser
	{
		$id = expand_uuid($id);
		$gu = $this->getRequestedGiverUser($id);

		if (!empty($data['allotment']) && $data['allotment'] < $gu->count_given) {
			$data['allotment'] = $gu->count_given;
		}

		$gu->fill(Arr::only($data, ['enabled', 'allotment']));
		$gu->save();

		Log::info('updated giver_user', ['giver_user_id' => $gu->id]);

		return $gu;
	}

	public function delete($id): void
	{
		// Log::info('deleted giver_user', ['giver_user_id' => $id]);
	}
}
