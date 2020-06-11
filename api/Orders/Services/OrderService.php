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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;

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

	public function getAll(): Collection
	{
		$user = Auth::user();
		Log::debug('fetching all orders');

		$qb = QueryBuilder::for(Order::where('user_id', $user->id));
		if ($user->operator) {
			$qb = QueryBuilder::for(Order::class)
				->allowedFilters([
					AllowedFilter::exact('user_id'),
				]);
		}

		return $qb->allowedIncludes(['order_cards.merchant'])
			->get();
	}

	public function getById($id): Order
	{
		$user = Auth::user();
		Log::debug('fetching order', ['order_id' => $id]);

		$order = QueryBuilder::for(Order::where('id', $id)->where('user_id', $user->id))
			->allowedIncludes(['order_cards.merchant'])
			->first();

		if (empty($order)) {
			throw new OrderNotFoundException($order);
		}

		return $order;
	}

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
