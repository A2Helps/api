<?php

namespace Api\BatchItems\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Api\BatchItems\Exceptions\BatchItemNotFoundException;
use Api\BatchItems\Models\BatchItem;

class BatchItemService
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
		Log::debug('fetching all batch_items');
	}

	public function getById($id): BatchItem
	{
		Log::debug('fetching batch_item', ['batch_item_id' => $id]);
	}

	public function create($data): BatchItem
	{
		Log::info('created batch_item', ['batch_item_id' => $batchItem->id]);
	}

	public function update($id, array $data): BatchItem
	{
		Log::info('updated batch_item', ['batch_item_id' => $id]);
	}

	public function delete($id): void
	{
		Log::info('deleted batch_item', ['batch_item_id' => $id]);
	}

	private function getRequestedBatchItem($id): BatchItem
	{
		$id = expand_uuid($id);
		$batchItem = BatchItem::find($id);

		if (empty($batchItem)) {
			throw new BatchItemNotFoundException();
		}

		return $batchItem;
	}
}
