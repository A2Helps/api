<?php

namespace Api\OrderCards\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\OrderCards\Exceptions\OrderCardNotFoundException;
use Api\OrderCards\Models\OrderCard;

class OrderCardService
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

	// public function getAll(): QueryBuilder
	// {
	// 	Log::debug('fetching all order_cards');
	// }

	// public function getById($id): QueryBuilder
	// {
	// 	Log::debug('fetching order_card', ['order_card_id' => $id]);
	// }

	public function create($data): OrderCard
	{
		$oc = OrderCard::create($data);

		Log::info('created order_card', [
			'order_card_id' => $oc->id,
			'order_id'      => $oc->order_id,
		]);

		return $oc;
	}

	// public function update($id, array $data): OrderCard
	// {
	// 	Log::info('updated order_card', ['order_card_id' => $id]);
	// }

	// public function delete($id): void
	// {
	// 	Log::info('deleted order_card', ['order_card_id' => $id]);
	// }

	protected function getRequestedOrderCard($id): OrderCard
	{
		$id = expand_uuid($id);
		$orderCard = OrderCard::find($id);

		if (empty($orderCard)) {
			throw new OrderCardNotFoundException();
		}

		return $orderCard;
	}
}
