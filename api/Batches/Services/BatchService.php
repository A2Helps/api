<?php

namespace Api\Batches\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Batches\Exceptions\BatchNotFoundException;
use Api\Batches\Models\Batch;
use Cumulati\Monolog\LogContext;
use Spatie\QueryBuilder\AllowedFilter;

class BatchService
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
		Log::debug('fetching all batches');

		return QueryBuilder::for(Batch::class)
			->allowedIncludes(['batch_items', 'merchant'])
			->allowedFilters([
				AllowedFilter::exact('id'),
				AllowedFilter::scope('completed'),
			])
			->get();
	}

	public function getById($id): Batch
	{
		Log::debug('fetching batch', ['batch_id' => $id]);

		$batch = QueryBuilder::for(Batch::where('id', $id))
			->allowedIncludes(['batch_items', 'merchant'])
			->first();

		if (empty($batch)) {
			throw new BatchNotFoundException();
		}

		return $batch;
	}

	public function create($data): Batch
	{
		Log::info('created batch', ['batch_id' => $batch->id]);
	}

	public function update($id, array $data): Batch
	{
		$account = $this->auth->user();

		$lc = new LogContext([
			'batchId' => $id,
		]);

		$lc->info('updating batch');

		$id = expand_uuid($id);
		$batch = $this->getRequestedBatch($id);

		if (! empty($data['assigned_to'])) {
			if ($batch->assigned_to) {
				throw new \Exception('already assigned');
			}

			$at = expand_uuid($data['assigned_to']);

			if ($at !== $account->id) {
				throw new \Exception('must assign to self');
			}

			$batch->assigned_to = $at;
		}

		if (! empty($data['completed'])) {
			$lc->debug('attemping to mark batch complete');

			$batch->batchItems->each(function($bi) {
				if (empty($bi->number)) {
					throw new \Exception('batch_item empty number');
				}
			});

			$batch->completed = true;
		}

		$batch->save();

		Log::info('updated batch', ['batch_id' => $batch->id]);

		return $batch->fresh();
	}

	public function delete($id): void
	{
		throw new \Exception('not implemented');
		// Log::info('deleted batch', ['batch_id' => $id]);
	}

	private function getRequestedBatch($id): Batch
	{
		$id = expand_uuid($id);
		$batch = Batch::find($id);

		if (empty($batch)) {
			throw new BatchNotFoundException();
		}

		return $batch;
	}
}
