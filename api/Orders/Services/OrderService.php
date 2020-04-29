<?php

namespace Api\Orders\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Orders\Exceptions\OrderNotFoundException;
use Api\Orders\Models\Order;
use Illuminate\Support\Arr;

class OrderService
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
	// 	Log::debug('fetching all orders');
	// }

	// public function getById($id): QueryBuilder
	// {
	// 	Log::debug('fetching order', ['order_id' => $id]);
	// }

	public function create($data): Order
	{
		$order = Order::create($data);

		Log::info('created order', [
			'order_id'     => $order->id,
			'recipient_id' => $order->recipient_id,
			'amount'       => $order->amount,
		]);

		return $order;
	}

	// public function update($id, array $data): Order
	// {
	// 	Log::info('updated order', ['order_id' => $id]);
	// }

	// public function delete($id): void
	// {
	// 	Log::info('deleted order', ['order_id' => $id]);
	// }

	protected function getRequestedOrder($id): Order
	{
		$id = expand_uuid($id);
		$order = Order::find($id);

		if (empty($order)) {
			throw new OrderNotFoundException();
		}

		return $order;
	}
}
